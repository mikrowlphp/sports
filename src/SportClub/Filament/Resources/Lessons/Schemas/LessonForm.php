<?php

namespace Packages\Sports\SportClub\Filament\Resources\Lessons\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Packages\Sports\SportClub\Enums\LessonStatus;
use Packages\Sports\SportClub\Enums\LessonType;
use Packages\Sports\SportClub\Models\Field;
use Packages\Sports\SportClub\Models\Sport;

class LessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // HEADER ZONE - Title only (fullspan)
                    Grid::make(12)->schema([
                        TextInput::make('title')
                            ->hiddenLabel()
                            ->placeholder(__('sports::lessons.title'))
                            ->required()
                            ->main()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // IMPORTANT INFO ZONE - Key lesson info before hr
                    Grid::make(12)->schema([
                        DateTimePicker::make('scheduled_at')
                            ->hiddenLabel()
                            ->placeholder(__('sports::lessons.scheduled_at'))
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->suffixIcon('heroicon-o-calendar')
                            ->columnSpan(['default' => 12, 'xl' => 6]),

                        Select::make('instructor_id')
                            ->hiddenLabel()
                            ->placeholder(__('sports::lessons.instructor'))
                            ->relationship('instructor.customer', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->suffixIcon('heroicon-o-user')
                            ->columnSpan(['default' => 12, 'xl' => 6]),

                        Select::make('field_id')
                            ->hiddenLabel()
                            ->placeholder(__('sports::fields.field'))
                            ->relationship('field', 'name')
                            ->options(function (Get $get) {
                                $sportId = $get('sport_id');

                                if (!$sportId) {
                                    return [];
                                }

                                return Field::query()
                                    ->where('sport_id', $sportId)
                                    ->active()
                                    ->ordered()
                                    ->pluck('name', 'id');
                            })
                            ->searchable()
                            ->preload()
                            ->live()
                            ->suffixIcon('heroicon-o-map-pin')
                            ->columnSpan(['default' => 12, 'xl' => 6]),

                        TextInput::make('price_per_person')
                            ->hiddenLabel()
                            ->placeholder(__('sports::lessons.price_per_person'))
                            ->required()
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01)
                            ->suffixIcon('heroicon-o-currency-euro')
                            ->columnSpan(['default' => 12, 'xl' => 6]),
                    ])->columnSpanFull(),

                    // SEPARATOR
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")
                        ->columnSpanFull(),

                    // BODY ZONE - Two columns (7/5 split)
                    Section::make()
                        ->schema([
                            Group::make([
                                Select::make('sport_id')
                                    ->label(__('sports::sports.sport'))
                                    ->relationship('sport', 'name')
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->live()
                                    ->columnSpanFull(),

                                Select::make('lesson_type')
                                    ->label(__('sports::lessons.lesson_type'))
                                    ->required()
                                    ->options(LessonType::class)
                                    ->native(false)
                                    ->default(LessonType::Group->value)
                                    ->live()
                                    ->columnSpanFull(),

                                TextInput::make('duration_minutes')
                                    ->label(__('sports::lessons.duration_minutes'))
                                    ->required()
                                    ->numeric()
                                    ->minValue(15)
                                    ->suffix(__('sports::lessons.minutes'))
                                    ->default(60)
                                    ->helperText(__('sports::lessons.duration_helper'))
                                    ->columnSpanFull(),
                            ])->inlineLabel()->columns(12)->columnSpan([
                                'default' => 12,
                                'xl' => 7,
                            ]),

                            Group::make([
                                TextInput::make('max_participants')
                                    ->label(__('sports::lessons.max_participants'))
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(10)
                                    ->helperText(__('sports::lessons.max_participants_helper'))
                                    ->visible(fn (Get $get) => $get('lesson_type') !== LessonType::Individual->value)
                                    ->columnSpanFull(),

                                Select::make('status')
                                    ->label(__('sports::lessons.status'))
                                    ->required()
                                    ->options(LessonStatus::class)
                                    ->native(false)
                                    ->default(LessonStatus::Scheduled->value)
                                    ->columnSpanFull(),
                            ])->inlineLabel()->columns(12)->columnSpan([
                                'default' => 12,
                                'xl' => 5,
                            ]),
                        ])
                        ->contained(false)
                        ->columns(12)
                        ->columnSpanFull(),

                    // NOTES ZONE - Always last, fullspan
                    Textarea::make('description')
                        ->label(__('sports::lessons.description'))
                        ->rows(4)
                        ->columnSpanFull(),

                ])->columns(12)->columnSpanFull(),
            ]);
    }
}
