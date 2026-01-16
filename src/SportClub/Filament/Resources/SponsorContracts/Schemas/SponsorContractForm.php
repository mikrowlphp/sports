<?php

namespace Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;

class SponsorContractForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // HEADER - Contract name (fullspan)
                    Grid::make(12)->schema([
                        TextInput::make('name')
                            ->hiddenLabel()
                            ->placeholder(__('sports::sponsor_contracts.name'))
                            ->required()
                            ->main()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // Sponsor selection
                    Grid::make(12)->schema([
                        Select::make('sponsor_id')
                            ->hiddenLabel()
                            ->placeholder(__('sports::sponsor_contracts.sponsor'))
                            ->relationship('sponsor', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // IMPORTANT INFO - Contract dates below header, before hr
                    Grid::make(12)->schema([
                        DatePicker::make('start_date')
                            ->hiddenLabel()
                            ->placeholder(__('sports::sponsor_contracts.start_date'))
                            ->suffixIcon('heroicon-o-calendar')
                            ->required()
                            ->native(false)
                            ->columnSpan(['default' => 12, 'xl' => 6]),
                        DatePicker::make('end_date')
                            ->hiddenLabel()
                            ->placeholder(__('sports::sponsor_contracts.end_date'))
                            ->suffixIcon('heroicon-o-calendar')
                            ->required()
                            ->native(false)
                            ->afterOrEqual('start_date')
                            ->columnSpan(['default' => 12, 'xl' => 6]),
                    ])->columnSpanFull(),

                    // SEPARATOR
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                    // BODY - Two columns (7/5)
                    Section::make()
                        ->schema([
                            Group::make([
                                TextInput::make('max_views')
                                    ->label(__('sports::sponsor_contracts.max_views'))
                                    ->placeholder(__('sports::sponsor_contracts.max_views_placeholder'))
                                    ->numeric()
                                    ->nullable()
                                    ->minValue(0)
                                    ->columnSpanFull(),
                                TextInput::make('used_views')
                                    ->label(__('sports::sponsor_contracts.used_views'))
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->columnSpanFull(),
                            ])->inlineLabel()->columns(12)->columnSpan([
                                'default' => 12,
                                'xl' => 7,
                            ]),
                            Group::make([
                                Toggle::make('is_active')
                                    ->label(__('sports::sponsor_contracts.is_active'))
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

                    // NOTES - Always last, fullspan
                    Textarea::make('notes')
                        ->label(__('sports::sponsor_contracts.notes'))
                        ->rows(4)
                        ->columnSpanFull(),

                ])->columns(12)->columnSpanFull(),
            ]);
    }
}
