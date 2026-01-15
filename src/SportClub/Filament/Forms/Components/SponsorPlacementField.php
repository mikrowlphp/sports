<?php

namespace Packages\Sports\SportClub\Filament\Forms\Components;

use Filament\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Components\Radio;
use Packages\Sports\SportClub\Enums\SponsorPosition;
use Packages\Sports\SportClub\Models\MatchSponsorPlacement;
use Packages\Sports\SportClub\Models\Sponsor;

class SponsorPlacementField extends Field
{
    protected string $view = 'sports::filament.forms.components.sponsor-placement-field';

    protected function setUp(): void
    {
        parent::setUp();

        $this->default([]);

        $this->registerActions([
            Action::make('selectSponsor')
                ->iconButton()
                ->icon('heroicon-o-plus')
                ->color('gray')
                ->size('sm')
                ->modalHeading(__('sports::matches.select_sponsor'))
                ->modalWidth('sm')
                ->schema(function (self $component) {
                    // Get already selected sponsor IDs
                    $state = $component->getState() ?? [];
                    $selectedIds = array_filter(array_values($state));

                    $sponsors = Sponsor::where('active', true)
                        ->whereHas('contracts', function ($query) {
                            $query->where('is_active', true)
                                  ->where('start_date', '<=', now())
                                  ->where('end_date', '>=', now())
                                  ->where(function ($q) {
                                      $q->whereNull('max_views')
                                        ->orWhereColumn('used_views', '<', 'max_views');
                                  });
                        })
                        ->whereNotIn('id', $selectedIds)
                        ->orderBy('name')
                        ->get();
                    $options = $sponsors->mapWithKeys(fn ($s) => [$s->id => $s->name])->toArray();

                    return [
                        Radio::make('sponsor_id')
                            ->label(__('sports::sponsors.sponsor'))
                            ->options($options)
                            ->required(),
                    ];
                })
                ->action(function (array $data, array $arguments, self $component) {
                    $position = $arguments['position'] ?? null;
                    if ($position && $data['sponsor_id']) {
                        $state = $component->getState() ?? [];
                        $state[$position] = (int) $data['sponsor_id'];
                        $component->state($state);
                    }
                })
                ->modalSubmitActionLabel(__('sports::matches.select_sponsor'))
                ->modalCancelActionLabel(__('sports::matches.cancel')),
        ]);

        // Load existing placements when editing
        $this->afterStateHydrated(function (SponsorPlacementField $component, $state, $record) {
            if ($record && $record->exists) {
                $record->load('sponsorPlacements');

                if ($record->sponsorPlacements->isNotEmpty()) {
                    $placements = $record->sponsorPlacements->mapWithKeys(function ($placement) {
                        return [$placement->position->value => $placement->sponsor_id];
                    })->toArray();
                    $component->state($placements);
                }
            }
        });

        // Save relationships after the record is saved
        $this->saveRelationshipsUsing(function (SponsorPlacementField $component, $record, $state) {
            if (!$record || !$record->exists) {
                return;
            }

            // Delete existing placements
            $record->sponsorPlacements()->delete();

            if (!is_array($state) || empty($state)) {
                return;
            }

            // Create new placements
            foreach ($state as $position => $sponsorId) {
                if ($sponsorId) {
                    MatchSponsorPlacement::create([
                        'match_id' => $record->id,
                        'sponsor_id' => $sponsorId,
                        'position' => $position,
                    ]);
                }
            }
        });
    }

    public function getPositions(): array
    {
        return SponsorPosition::cases();
    }

    /**
     * Get sponsors with active contracts (for selecting NEW sponsors)
     */
    public function getSponsors()
    {
        return Sponsor::where('active', true)
            ->whereHas('contracts', function ($query) {
                $query->where('is_active', true)
                      ->where('start_date', '<=', now())
                      ->where('end_date', '>=', now())
                      ->where(function ($q) {
                          $q->whereNull('max_views')
                            ->orWhereColumn('used_views', '<', 'max_views');
                      });
            })
            ->orderBy('name')
            ->get()
            ->map(function ($sponsor) {
                $sponsor->logo_url = $sponsor->logo
                    ? \Storage::disk('s3')->temporaryUrl($sponsor->logo, now()->addHour())
                    : null;
                return $sponsor;
            });
    }

    /**
     * Get ALL active sponsors (for displaying already assigned sponsors)
     * No contract filter - assigned sponsors should always be visible
     */
    public function getAllSponsors()
    {
        return Sponsor::where('active', true)
            ->orderBy('name')
            ->get()
            ->map(function ($sponsor) {
                $sponsor->logo_url = $sponsor->logo
                    ? \Storage::disk('s3')->temporaryUrl($sponsor->logo, now()->addHour())
                    : null;
                return $sponsor;
            });
    }

    public function getHasAnySponsors(): bool
    {
        return Sponsor::where('active', true)
            ->whereHas('contracts', function ($query) {
                $query->where('is_active', true)
                      ->where('start_date', '<=', now())
                      ->where('end_date', '>=', now())
                      ->where(function ($q) {
                          $q->whereNull('max_views')
                            ->orWhereColumn('used_views', '<', 'max_views');
                      });
            })
            ->exists();
    }

    public function getAvailableSponsorsCount(): int
    {
        $state = $this->getState() ?? [];
        $selectedIds = array_filter(array_values($state));

        return Sponsor::where('active', true)
            ->whereHas('contracts', function ($query) {
                $query->where('is_active', true)
                      ->where('start_date', '<=', now())
                      ->where('end_date', '>=', now())
                      ->where(function ($q) {
                          $q->whereNull('max_views')
                            ->orWhereColumn('used_views', '<', 'max_views');
                      });
            })
            ->whereNotIn('id', $selectedIds)
            ->count();
    }

}
