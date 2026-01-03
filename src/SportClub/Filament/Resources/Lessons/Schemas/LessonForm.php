<?php

namespace Packages\Sports\SportClub\Filament\Resources\Lessons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Sports\SportClub\Enums\LessonStatus;
use Packages\Sports\SportClub\Enums\LessonType;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sports::lessons.lesson_information'))
                    ->description(__('sports::lessons.lesson_information_desc'))
                    ->columns(2)
                    ->schema([
                        Select::make('instructor_id')
                            ->label(__('sports::lessons.instructor'))
                            ->relationship('instructor.customer', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),

                        TextInput::make('title')
                            ->label(__('sports::lessons.title'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Textarea::make('description')
                            ->label(__('sports::lessons.description'))
                            ->rows(4)
                            ->columnSpanFull(),

                        Select::make('lesson_type')
                            ->label(__('sports::lessons.lesson_type'))
                            ->required()
                            ->options(LessonType::class)
                            ->native(false)
                            ->default(LessonType::Group->value),

                        TextInput::make('sport')
                            ->label(__('sports::lessons.sport'))
                            ->required()
                            ->maxLength(255),

                        DateTimePicker::make('scheduled_at')
                            ->label(__('sports::lessons.scheduled_at'))
                            ->required()
                            ->native(false)
                            ->seconds(false),

                        TextInput::make('duration_minutes')
                            ->label(__('sports::lessons.duration_minutes'))
                            ->required()
                            ->numeric()
                            ->minValue(15)
                            ->suffix(__('sports::lessons.minutes'))
                            ->default(60)
                            ->helperText(__('sports::lessons.duration_helper')),

                        TextInput::make('max_participants')
                            ->label(__('sports::lessons.max_participants'))
                            ->numeric()
                            ->minValue(1)
                            ->default(10)
                            ->helperText(__('sports::lessons.max_participants_helper')),

                        TextInput::make('price_per_person')
                            ->label(__('sports::lessons.price_per_person'))
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01),

                        TextInput::make('location')
                            ->label(__('sports::lessons.location'))
                            ->maxLength(255)
                            ->helperText(__('sports::lessons.location_helper')),

                        Select::make('status')
                            ->label(__('sports::lessons.status'))
                            ->required()
                            ->options(LessonStatus::class)
                            ->native(false)
                            ->default(LessonStatus::Scheduled->value),
                    ]),
            ]);
    }
}
