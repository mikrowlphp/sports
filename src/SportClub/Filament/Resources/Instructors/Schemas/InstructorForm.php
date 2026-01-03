<?php

namespace Packages\Sports\SportClub\Filament\Resources\Instructors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InstructorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sports::instructors.instructor_information'))
                    ->description(__('sports::instructors.instructor_information_desc'))
                    ->columns(2)
                    ->schema([
                        Select::make('customer_id')
                            ->label(__('sports::instructors.customer'))
                            ->relationship('customer', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->helperText(__('sports::instructors.customer_helper'))
                            ->columnSpanFull(),

                        TagsInput::make('specializations')
                            ->label(__('sports::instructors.specializations'))
                            ->placeholder(__('sports::instructors.specializations_placeholder'))
                            ->helperText(__('sports::instructors.specializations_helper'))
                            ->columnSpanFull(),

                        TextInput::make('hourly_rate')
                            ->label(__('sports::instructors.hourly_rate'))
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01)
                            ->helperText(__('sports::instructors.hourly_rate_helper')),

                        Toggle::make('is_active')
                            ->label(__('sports::instructors.is_active'))
                            ->default(true),
                    ]),

                Section::make(__('sports::instructors.bio'))
                    ->description(__('sports::instructors.bio_desc'))
                    ->schema([
                        Textarea::make('bio')
                            ->label(__('sports::instructors.bio'))
                            ->rows(6)
                            ->columnSpanFull()
                            ->helperText(__('sports::instructors.bio_helper')),
                    ]),
            ]);
    }
}
