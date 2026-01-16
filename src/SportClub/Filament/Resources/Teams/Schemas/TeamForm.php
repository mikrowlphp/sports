<?php

namespace Packages\Sports\SportClub\Filament\Resources\Teams\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // ========================================
                    // HEADER ZONE: Name + Logo
                    // ========================================
                    Grid::make(12)->schema([
                        TextInput::make('name')
                            ->hiddenLabel()
                            ->placeholder(__('sports::teams.name'))
                            ->required()
                            ->main()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                            ->columnSpan(['default' => 12, 'xl' => 8]),

                        FileUpload::make('logo')
                            ->label(__('sports::teams.logo'))
                            ->image()
                            ->disk('s3')
                            ->visibility('public')
                            ->directory('teams/logos')
                            ->maxSize(5120)
                            ->columnSpan(['default' => 12, 'xl' => 4]),
                    ])->columnSpanFull(),

                    // ========================================
                    // IMPORTANT INFO ZONE: Key fields before hr
                    // ========================================
                    Grid::make(12)->schema([
                        Select::make('sport_id')
                            ->hiddenLabel()
                            ->placeholder(__('sports::teams.sport'))
                            ->relationship('sport', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->suffixIcon('heroicon-o-trophy')
                            ->columnSpan(['default' => 12, 'xl' => 4]),

                        TextInput::make('category')
                            ->hiddenLabel()
                            ->placeholder(__('sports::teams.category'))
                            ->maxLength(255)
                            ->suffixIcon('heroicon-o-tag')
                            ->columnSpan(['default' => 12, 'xl' => 4]),

                        TextInput::make('slug')
                            ->hiddenLabel()
                            ->placeholder(__('sports::teams.slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->suffixIcon('heroicon-o-link')
                            ->columnSpan(['default' => 12, 'xl' => 4]),
                    ])->columnSpanFull(),

                    // ========================================
                    // SEPARATOR
                    // ========================================
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                    // ========================================
                    // BODY ZONE: 7/5 split with inlineLabel
                    // ========================================
                    Section::make()
                        ->schema([
                            Group::make([
                                TextInput::make('level')
                                    ->label(__('sports::teams.level'))
                                    ->inlineLabel()
                                    ->maxLength(255)
                                    ->columnSpanFull(),

                                TextInput::make('max_members')
                                    ->label(__('sports::teams.max_members'))
                                    ->inlineLabel()
                                    ->numeric()
                                    ->minValue(1)
                                    ->default(20)
                                    ->columnSpanFull(),
                            ])->inlineLabel()->columns(12)->columnSpan([
                                'default' => 12,
                                'xl' => 7,
                            ]),

                            Group::make([
                                Toggle::make('is_active')
                                    ->label(__('sports::teams.is_active'))
                                    ->inlineLabel()
                                    ->default(true)
                                    ->columnSpanFull(),
                            ])->inlineLabel()->columns(12)->columnSpan([
                                'default' => 12,
                                'xl' => 5,
                            ]),
                        ])
                        ->contained(false)
                        ->columns(12)
                        ->columnSpanFull(),

                ])->columns(12)->columnSpanFull(),
            ]);
    }
}
