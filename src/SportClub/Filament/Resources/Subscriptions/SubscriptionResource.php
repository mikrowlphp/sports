<?php

namespace Packages\Sports\SportClub\Filament\Resources\Subscriptions;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\Subscriptions\Pages\CreateSubscription;
use Packages\Sports\SportClub\Filament\Resources\Subscriptions\Pages\EditSubscription;
use Packages\Sports\SportClub\Filament\Resources\Subscriptions\Pages\ListSubscriptions;
use Packages\Sports\SportClub\Filament\Resources\Subscriptions\Schemas\SubscriptionForm;
use Packages\Sports\SportClub\Filament\Resources\Subscriptions\Tables\SubscriptionsTable;
use Packages\Sports\SportClub\Models\Subscription;

class SubscriptionResource extends Resource
{
    protected static ?string $model = Subscription::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return SubscriptionForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SubscriptionsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSubscriptions::route('/'),
            'create' => CreateSubscription::route('/create'),
            'edit' => EditSubscription::route('/{record}/edit'),
        ];
    }
}
