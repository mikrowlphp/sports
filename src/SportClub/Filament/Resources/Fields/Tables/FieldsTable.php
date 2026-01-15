<?php

namespace Packages\Sports\SportClub\Filament\Resources\Fields\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class FieldsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sport.name')
                    ->label(__('Sport'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('Nome'))
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                TextColumn::make('capacity')
                    ->label(__('Capienza'))
                    ->numeric()
                    ->sortable()
                    ->suffix(' ' . __('persone'))
                    ->alignCenter(),

                TextColumn::make('hourly_rate')
                    ->label(__('Tariffa/h'))
                    ->money('EUR')
                    ->sortable()
                    ->alignEnd(),

                ColorColumn::make('color')
                    ->label(__('Colore'))
                    ->alignCenter(),

                IconColumn::make('is_indoor')
                    ->label(__('Coperto'))
                    ->boolean()
                    ->trueIcon('heroicon-o-home')
                    ->falseIcon('heroicon-o-sun')
                    ->alignCenter(),

                IconColumn::make('is_active')
                    ->label(__('Attivo'))
                    ->boolean()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('sort_order')
                    ->label(__('Ordine'))
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('created_at')
                    ->label(__('Creato'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('sport_id')
                    ->label(__('Sport'))
                    ->relationship('sport', 'name')
                    ->preload()
                    ->multiple(),

                TernaryFilter::make('is_indoor')
                    ->label(__('Tipo Campo'))
                    ->trueLabel(__('Solo Coperti'))
                    ->falseLabel(__('Solo Scoperti'))
                    ->placeholder(__('Tutti')),

                TernaryFilter::make('is_active')
                    ->label(__('Stato'))
                    ->trueLabel(__('Solo Attivi'))
                    ->falseLabel(__('Solo Disattivati'))
                    ->placeholder(__('Tutti')),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
    }
}
