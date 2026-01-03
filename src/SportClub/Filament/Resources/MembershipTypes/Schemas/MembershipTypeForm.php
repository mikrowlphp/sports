<?php

namespace Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class MembershipTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sports::members.membership_type_information'))
                    ->description(__('sports::members.membership_type_information_desc'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('sports::members.name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label(__('sports::members.slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText(__('sports::members.slug_helper')),

                        TextInput::make('duration_days')
                            ->label(__('sports::members.duration_days'))
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->suffix(__('sports::members.days'))
                            ->helperText(__('sports::members.duration_days_helper')),

                        TextInput::make('price')
                            ->label(__('sports::members.price'))
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01),

                        Toggle::make('is_active')
                            ->label(__('sports::members.is_active'))
                            ->default(true)
                            ->columnSpanFull(),
                    ]),

                Section::make(__('sports::members.benefits'))
                    ->description(__('sports::members.benefits_desc'))
                    ->schema([
                        KeyValue::make('benefits')
                            ->label(__('sports::members.benefits'))
                            ->keyLabel(__('sports::members.benefit_name'))
                            ->valueLabel(__('sports::members.benefit_description'))
                            ->addActionLabel(__('sports::members.add_benefit'))
                            ->reorderable(),
                    ]),
            ]);
    }
}
