<?php

namespace Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class MembershipTypesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('sports::members.name'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('slug')
                    ->label(__('sports::members.slug'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('duration_days')
                    ->label(__('sports::members.duration'))
                    ->formatStateUsing(fn ($state) => __('sports::members.days_count', ['count' => $state]))
                    ->sortable(),

                TextColumn::make('price')
                    ->label(__('sports::members.price'))
                    ->money('EUR')
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label(__('sports::members.active'))
                    ->boolean(),

                TextColumn::make('subscriptions_count')
                    ->label(__('sports::members.subscriptions_count'))
                    ->counts('subscriptions')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('sports::members.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('sports::members.active_filter'))
                    ->placeholder(__('sports::members.all'))
                    ->trueLabel(__('sports::members.active_only'))
                    ->falseLabel(__('sports::members.inactive_only')),
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
