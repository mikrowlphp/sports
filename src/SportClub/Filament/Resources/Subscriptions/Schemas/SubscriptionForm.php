<?php

namespace Packages\Sports\SportClub\Filament\Resources\Subscriptions\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconSize;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Enums\SubscriptionStatus;
use Packages\Sports\SportClub\Models\MembershipType;

class SubscriptionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // HEADER ZONE - Customer and Membership Type (identifiers for subscription)
                    Grid::make(12)->schema([
                        Select::make('customer_id')
                            ->hiddenLabel()
                            ->placeholder(__('sports::members.customer'))
                            ->required()
                            ->searchable()
                            ->relationship('customer', 'name')
                            ->getOptionLabelFromRecordUsing(fn (Contact $record) => $record->name)
                            ->preload()
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 8,
                            ]),

                        Select::make('membership_type_id')
                            ->hiddenLabel()
                            ->placeholder(__('sports::members.membership_type'))
                            ->required()
                            ->relationship('membershipType', 'name')
                            ->preload()
                            ->columnSpan([
                                'default' => 12,
                                'lg' => 4,
                            ]),
                    ])->columnSpanFull(),

                    // IMPORTANT INFO ZONE - Key dates and amount (before hr)
                    Grid::make(12)->schema([
                        DatePicker::make('start_date')
                            ->hiddenLabel()
                            ->placeholder(__('sports::members.start_date'))
                            ->required()
                            ->native(false)
                            ->suffixIcon('heroicon-o-calendar')
                            ->suffixIconSize(IconSize::Small)
                            ->columnSpan([
                                'default' => 12,
                                'xl' => 4,
                            ]),

                        DatePicker::make('end_date')
                            ->hiddenLabel()
                            ->placeholder(__('sports::members.end_date'))
                            ->required()
                            ->native(false)
                            ->afterOrEqual('start_date')
                            ->suffixIcon('heroicon-o-calendar')
                            ->suffixIconSize(IconSize::Small)
                            ->columnSpan([
                                'default' => 12,
                                'xl' => 4,
                            ]),

                        TextInput::make('amount_paid')
                            ->hiddenLabel()
                            ->placeholder(__('sports::members.amount_paid'))
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01)
                            ->suffixIcon('heroicon-o-currency-euro')
                            ->suffixIconSize(IconSize::Small)
                            ->columnSpan([
                                'default' => 12,
                                'xl' => 4,
                            ]),
                    ])->columnSpanFull(),

                    // SEPARATOR
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")
                        ->columnSpanFull(),

                    // BODY ZONE - Status field (7/5 split)
                    Section::make()
                        ->schema([
                            Group::make([
                                Select::make('status')
                                    ->label(__('sports::members.status'))
                                    ->required()
                                    ->options(SubscriptionStatus::class)
                                    ->default(SubscriptionStatus::Active)
                                    ->columnSpanFull(),
                            ])
                                ->inlineLabel()
                                ->columns(12)
                                ->columnSpan([
                                    'default' => 12,
                                    'xl' => 7,
                                ]),

                            Group::make([
                                // Right column - empty for now, but maintains structure
                            ])
                                ->inlineLabel()
                                ->columns(12)
                                ->columnSpan([
                                    'default' => 12,
                                    'xl' => 5,
                                ]),
                        ])
                        ->contained(false)
                        ->columns(12)
                        ->columnSpanFull(),
                ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
