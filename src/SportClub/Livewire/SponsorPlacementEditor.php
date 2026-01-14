<?php

namespace Packages\Sports\SportClub\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Modelable;
use Packages\Sports\SportClub\Models\Sponsor;
use Packages\Sports\SportClub\Enums\SponsorPosition;

class SponsorPlacementEditor extends Component
{
    #[Modelable]
    public array $placements = [];

    public ?string $selectedPosition = null;
    public array $sponsorSizes = [];

    public function mount(array $placements = []): void
    {
        // Convert placements to position => sponsor_id map
        $this->placements = collect($placements)
            ->mapWithKeys(fn ($p) => [$p['position'] => $p['sponsor_id']])
            ->toArray();

        // Initialize sizes (default 100%)
        foreach (SponsorPosition::cases() as $position) {
            $this->sponsorSizes[$position->value] = 100;
        }
    }

    #[Computed]
    public function positions(): array
    {
        return SponsorPosition::cases();
    }

    #[Computed]
    public function sponsors()
    {
        return Sponsor::where('active', true)->orderBy('name')->get();
    }

    #[Computed]
    public function selectedSponsors(): array
    {
        $result = [];
        foreach ($this->placements as $position => $sponsorId) {
            if ($sponsorId) {
                $result[$position] = Sponsor::find($sponsorId);
            }
        }
        return $result;
    }

    public function selectPosition(string $position): void
    {
        $this->selectedPosition = $position;
        $this->dispatch('open-modal', id: 'sponsor-selector-modal');
    }

    public function assignSponsor(int $sponsorId): void
    {
        if ($this->selectedPosition) {
            $this->placements[$this->selectedPosition] = $sponsorId;
            $this->selectedPosition = null;
            $this->dispatch('close-modal', id: 'sponsor-selector-modal');
            $this->syncToForm();
        }
    }

    public function removeSponsor(string $position): void
    {
        unset($this->placements[$position]);
        $this->syncToForm();
    }

    public function updateSize(string $position, int $size): void
    {
        $this->sponsorSizes[$position] = max(30, min(150, $size));
    }

    protected function syncToForm(): void
    {
        // Convert back to array format for Filament relationship
        $data = [];
        foreach ($this->placements as $position => $sponsorId) {
            if ($sponsorId) {
                $data[] = [
                    'position' => $position,
                    'sponsor_id' => $sponsorId,
                ];
            }
        }
        $this->dispatch('placements-updated', placements: $data);
    }

    public function render()
    {
        return view('sports::livewire.sponsor-placement-editor');
    }
}
