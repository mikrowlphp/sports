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
                        if ($record->match_type === MatchType::Team) {
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
                    ->color(fn (MatchType $state): string => match($state) {
                        MatchType::Team => 'info',
                        MatchType::Individual => 'warning',
                    }),

                TextColumn::make('status')
                    ->label(__('sports::matches.status'))
                    ->badge()
                    ->color(fn (MatchStatus $state): string => match($state) {
                        MatchStatus::Scheduled => 'info',
                        MatchStatus::InProgress => 'warning',
                        MatchStatus::Completed => 'success',
                        MatchStatus::Cancelled => 'danger',
                        MatchStatus::Postponed => 'gray',
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
