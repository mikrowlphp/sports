<?php

namespace Packages\Sports\SportClub\Filament\Resources\Instructors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InstructorsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label(__('sports::instructors.customer'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('specializations')
                    ->label(__('sports::instructors.specializations'))
                    ->badge()
                    ->separator(',')
                    ->searchable(),

                TextColumn::make('hourly_rate')
                    ->label(__('sports::instructors.hourly_rate'))
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('lessons_count')
                    ->label(__('sports::instructors.lessons_count'))
                    ->counts('lessons')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('sports::instructors.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('customer.name');
    }
}
