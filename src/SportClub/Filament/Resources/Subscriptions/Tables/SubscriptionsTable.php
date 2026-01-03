<?php

namespace Packages\Sports\SportClub\Filament\Resources\Subscriptions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Enums\SubscriptionStatus;

class SubscriptionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('customer.name')
                    ->label(__('sports::members.customer'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('membershipType.name')
                    ->label(__('sports::members.membership_type'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('start_date')
                    ->label(__('sports::members.start_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('sports::members.end_date'))
                    ->date()
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('sports::members.status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => SubscriptionStatus::from($state)->getLabel())
                    ->color(fn (string $state): string => match($state) {
                        SubscriptionStatus::Active->value => 'success',
                        SubscriptionStatus::Expired->value => 'danger',
                        SubscriptionStatus::Cancelled->value => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('amount_paid')
                    ->label(__('sports::members.amount_paid'))
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('sports::members.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('sports::members.filter_by_status'))
                    ->options(SubscriptionStatus::class),

                SelectFilter::make('membership_type_id')
                    ->label(__('sports::members.filter_by_type'))
                    ->relationship('membershipType', 'name'),
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
