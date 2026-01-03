<?php

namespace Packages\Sports\SportClub\Filament\Resources\Matches\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Enums\MatchStatus;
use Packages\Sports\SportClub\Enums\MatchType;

class MatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('scheduled_at')
                    ->label(__('sports::matches.scheduled_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('match_display')
                    ->label(__('sports::matches.match'))
                    ->formatStateUsing(function ($record): string {
                        if ($record->match_type === MatchType::Team->value) {
                            $home = $record->homeTeam?->name ?? __('sports::matches.tbd');
                            $away = $record->awayTeam?->name ?? __('sports::matches.tbd');
                            return "{$home} vs {$away}";
                        } else {
                            $home = $record->homePlayer?->name ?? __('sports::matches.tbd');
                            $away = $record->awayPlayer?->name ?? __('sports::matches.tbd');
                            return "{$home} vs {$away}";
                        }
                    })
                    ->searchable(query: function ($query, string $search): void {
                        $query->whereHas('homeTeam', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('awayTeam', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('homePlayer', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('awayPlayer', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        });
                    }),

                TextColumn::make('tournament.name')
                    ->label(__('sports::matches.tournament'))
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('court')
                    ->label(__('sports::matches.court'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('match_type')
                    ->label(__('sports::matches.match_type'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => MatchType::from($state)->getLabel())
                    ->color(fn (string $state): string => match($state) {
                        MatchType::Team->value => 'info',
                        MatchType::Individual->value => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label(__('sports::matches.status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => MatchStatus::from($state)->getLabel())
                    ->color(fn (string $state): string => match($state) {
                        MatchStatus::Scheduled->value => 'info',
                        MatchStatus::InProgress->value => 'warning',
                        MatchStatus::Completed->value => 'success',
                        MatchStatus::Cancelled->value => 'danger',
                        MatchStatus::Postponed->value => 'gray',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label(__('sports::matches.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('sports::matches.filter_by_status'))
                    ->options(MatchStatus::class),

                SelectFilter::make('match_type')
                    ->label(__('sports::matches.filter_by_match_type'))
                    ->options(MatchType::class),

                SelectFilter::make('tournament_id')
                    ->label(__('sports::matches.filter_by_tournament'))
                    ->relationship('tournament', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('scheduled_at', 'desc');
    }
}
