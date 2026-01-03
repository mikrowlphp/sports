<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Enums\TournamentFormat;
use Packages\Sports\SportClub\Enums\TournamentStatus;

class TournamentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('sports::tournaments.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sport')
                    ->label(__('sports::tournaments.sport'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label(__('sports::tournaments.start_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('sports::tournaments.end_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('format')
                    ->label(__('sports::tournaments.format'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => TournamentFormat::from($state)->getLabel())
                    ->color(fn (string $state): string => match($state) {
                        TournamentFormat::SingleElimination->value => 'info',
                        TournamentFormat::DoubleElimination->value => 'warning',
                        TournamentFormat::RoundRobin->value => 'success',
                        TournamentFormat::SwissSystem->value => 'primary',
                        default => 'gray',
                    }),

                TextColumn::make('status')
                    ->label(__('sports::tournaments.status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => TournamentStatus::from($state)->getLabel())
                    ->color(fn (string $state): string => match($state) {
                        TournamentStatus::Draft->value => 'gray',
                        TournamentStatus::Open->value => 'info',
                        TournamentStatus::InProgress->value => 'warning',
                        TournamentStatus::Completed->value => 'success',
                        TournamentStatus::Cancelled->value => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('teams_count')
                    ->label(__('sports::tournaments.teams_count'))
                    ->counts('teams')
                    ->sortable(),

                TextColumn::make('entry_fee')
                    ->label(__('sports::tournaments.entry_fee'))
                    ->money('EUR')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label(__('sports::tournaments.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('sports::tournaments.filter_by_status'))
                    ->options(TournamentStatus::class),

                SelectFilter::make('format')
                    ->label(__('sports::tournaments.filter_by_format'))
                    ->options(TournamentFormat::class),

                SelectFilter::make('sport')
                    ->label(__('sports::tournaments.filter_by_sport'))
                    ->options(function () {
                        return \Packages\Sports\SportClub\Models\Tournament::query()
                            ->distinct()
                            ->pluck('sport', 'sport')
                            ->toArray();
                    }),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('start_date', 'desc');
    }
}
