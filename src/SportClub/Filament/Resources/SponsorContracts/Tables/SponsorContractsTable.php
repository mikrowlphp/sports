<?php

namespace Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Models\Sponsor;

class SponsorContractsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('sponsor.name')
                    ->label(__('sports::sponsor_contracts.sponsor'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label(__('sports::sponsor_contracts.start_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('sports::sponsor_contracts.end_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('views')
                    ->label(__('sports::sponsor_contracts.views'))
                    ->formatStateUsing(function ($record) {
                        $max = $record->max_views ?? '∞';
                        $used = $record->used_views ?? 0;
                        return "{$used}/{$max}";
                    })
                    ->badge()
                    ->color(function ($record) {
                        if ($record->max_views === null) {
                            return 'success';
                        }
                        $percentage = ($record->used_views / $record->max_views) * 100;
                        if ($percentage >= 90) {
                            return 'danger';
                        }
                        if ($percentage >= 70) {
                            return 'warning';
                        }
                        return 'success';
                    }),

                IconColumn::make('is_active')
                    ->label(__('sports::sponsor_contracts.is_active'))
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label(__('sports::sponsor_contracts.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TernaryFilter::make('is_active')
                    ->label(__('sports::sponsor_contracts.is_active_filter'))
                    ->placeholder(__('sports::sponsor_contracts.all'))
                    ->trueLabel(__('sports::sponsor_contracts.active_only'))
                    ->falseLabel(__('sports::sponsor_contracts.inactive_only')),

                SelectFilter::make('sponsor_id')
                    ->label(__('sports::sponsor_contracts.sponsor_filter'))
                    ->relationship('sponsor', 'name')
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
            ->defaultSort('start_date', 'desc');
    }
}
