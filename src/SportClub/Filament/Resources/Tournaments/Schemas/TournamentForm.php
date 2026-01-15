<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Packages\Sports\SportClub\Enums\TournamentFormat;
use Packages\Sports\SportClub\Enums\TournamentStatus;

class TournamentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // HEADER ZONE - Name only (fullspan)
                    Grid::make(12)->schema([
                        TextInput::make('name')
                            ->hiddenLabel()
                            ->placeholder(__('sports::tournaments.name'))
                            ->required()
                            ->main()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // IMPORTANT INFO ZONE - Sport and dates (before hr)
                    Grid::make(12)->schema([
                        Select::make('sport_id')
                            ->relationship('sport', 'name')
                            ->hiddenLabel()
                            ->placeholder(__('sports::tournaments.sport'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->native(false)
                            ->columnSpan(['default' => 12, 'xl' => 4]),

                        DatePicker::make('start_date')
                            ->hiddenLabel()
                            ->placeholder(__('sports::tournaments.start_date'))
                            ->required()
                            ->native(false)
                            ->columnSpan(['default' => 12, 'xl' => 4]),

                        DatePicker::make('end_date')
                            ->hiddenLabel()
                            ->placeholder(__('sports::tournaments.end_date'))
                            ->required()
                            ->native(false)
                            ->after('start_date')
                            ->columnSpan(['default' => 12, 'xl' => 4]),
                    ])->columnSpanFull(),

                    // SEPARATOR
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")
                        ->columnSpanFull(),

                    // BODY ZONE - Two columns (7/5 split)
                    Section::make()
                        ->schema([
                            Group::make([
                                TextInput::make('slug')
                                    ->label(__('sports::tournaments.slug'))
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->columnSpanFull(),

                                Select::make('format')
                                    ->label(__('sports::tournaments.format'))
                                    ->required()
                                    ->options(TournamentFormat::class)
                                    ->native(false)
                                    ->columnSpanFull(),

                                Select::make('status')
                                    ->label(__('sports::tournaments.status'))
                                    ->required()
                                    ->options(TournamentStatus::class)
                                    ->native(false)
                                    ->default(TournamentStatus::Draft->value)
                                    ->columnSpanFull(),

                                TextInput::make('max_teams')
                                    ->label(__('sports::tournaments.max_teams'))
                                    ->numeric()
                                    ->minValue(2)
                                    ->default(8)
                                    ->columnSpanFull(),
                            ])
                                ->inlineLabel()
                                ->columns(12)
                                ->columnSpan([
                                    'default' => 12,
                                    'xl' => 7,
                                ]),

                            Group::make([
                                TextInput::make('entry_fee')
                                    ->label(__('sports::tournaments.entry_fee'))
                                    ->numeric()
                                    ->prefix('€')
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->columnSpanFull(),

                                TextInput::make('prize')
                                    ->label(__('sports::tournaments.prize'))
                                    ->numeric()
                                    ->prefix('€')
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->columnSpanFull(),
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

                    // NOTES ZONE - Always last, fullspan
                    RichEditor::make('description')
                        ->label(__('sports::tournaments.description'))
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'underline',
                            'bulletList',
                            'orderedList',
                            'link',
                        ]),

                    MarkdownEditor::make('rules')
                        ->label(__('sports::tournaments.rules'))
                        ->columnSpanFull()
                        ->toolbarButtons([
                            'bold',
                            'italic',
                            'heading',
                            'bulletList',
                            'orderedList',
                            'codeBlock',
                            'table',
                        ]),
                ])->columns(12)->columnSpanFull(),
            ]);
    }
}
