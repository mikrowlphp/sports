<?php

namespace Packages\Sports\SportClub\Filament\Resources\Instructors\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
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

                TextColumn::make('is_active')
                    ->label(__('sports::instructors.status'))
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? __('sports::instructors.active') : __('sports::instructors.inactive'))
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),

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
                TernaryFilter::make('is_active')
                    ->label(__('sports::instructors.active_filter'))
                    ->placeholder(__('sports::instructors.all'))
                    ->trueLabel(__('sports::instructors.active_only'))
                    ->falseLabel(__('sports::instructors.inactive_only')),
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
