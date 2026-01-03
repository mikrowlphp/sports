<?php

namespace Packages\Sports\SportClub\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Enums\SubscriptionStatus;
use Packages\Sports\SportClub\Models\MembershipType;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sports::members.subscription_information'))
                    ->description(__('sports::members.subscription_information_desc'))
                    ->columns(2)
                    ->schema([
                        Select::make('customer_id')
                            ->label(__('sports::members.customer'))
                            ->required()
                            ->searchable()
                            ->relationship('customer', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Contact $record) => $record->name)
                            ->preload(),

                        Select::make('membership_type_id')
                            ->label(__('sports::members.membership_type'))
                            ->required()
                            ->relationship('membershipType', 'name')
                            ->preload(),

                        DatePicker::make('start_date')
                            ->label(__('sports::members.start_date'))
                            ->required()
                            ->native(false),

                        DatePicker::make('end_date')
                            ->label(__('sports::members.end_date'))
                            ->required()
                            ->native(false)
                            ->afterOrEqual('start_date'),

                        Select::make('status')
                            ->label(__('sports::members.status'))
                            ->required()
                            ->options(SubscriptionStatus::class)
                            ->default(SubscriptionStatus::Active),

                        TextInput::make('amount_paid')
                            ->label(__('sports::members.amount_paid'))
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01),
                    ]),
            ]);
    }
}
