<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sponsors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SponsorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label(__('sports::sponsors.logo'))
                    ->circular(),

                TextColumn::make('name')
                    ->label(__('sports::sponsors.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('url')
                    ->label(__('sports::sponsors.url'))
                    ->url(fn ($record) => $record->url)
                    ->openUrlInNewTab()
                    ->limit(50),

                IconColumn::make('active')
                    ->label(__('sports::sponsors.active'))
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label(__('sports::sponsors.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('active')
                    ->label(__('sports::sponsors.active_filter'))
                    ->placeholder(__('sports::sponsors.all'))
                    ->trueLabel(__('sports::sponsors.active_only'))
                    ->falseLabel(__('sports::sponsors.inactive_only')),
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
