<?php

namespace Packages\Sports\SportClub\Filament\Resources\Teams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class TeamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label(__('sports::teams.logo'))
                    ->circular()
                    ->defaultImageUrl(url('/images/team_placeholder.webp')),

                TextColumn::make('name')
                    ->label(__('sports::teams.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('sport.name')
                    ->label(__('sports::teams.sport'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('category')
                    ->label(__('sports::teams.category'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('level')
                    ->label(__('sports::teams.level'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('members_count')
                    ->label(__('sports::teams.members_count'))
                    ->counts('members')
                    ->sortable(),

                TextColumn::make('is_active')
                    ->label(__('sports::teams.status'))
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? __('sports::teams.active') : __('sports::teams.inactive'))
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),

                TextColumn::make('created_at')
                    ->label(__('sports::teams.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('sport_id')
                    ->label(__('sports::teams.filter_by_sport'))
                    ->relationship('sport', 'name')
                    ->searchable()
                    ->preload(),

                TernaryFilter::make('is_active')
                    ->label(__('sports::teams.active_filter'))
                    ->placeholder(__('sports::teams.all'))
                    ->trueLabel(__('sports::teams.active_only'))
                    ->falseLabel(__('sports::teams.inactive_only')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
    }
}
