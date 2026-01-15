<?php

namespace Packages\Sports\SportClub\Filament\Resources\Fields\Schemas;

use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FieldForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // HEADER - Name only (fullspan)
                    Grid::make(12)->schema([
                        TextInput::make('name')
                            ->hiddenLabel()
                            ->placeholder(__('sports::fields.form.name'))
                            ->required()
                            ->main()
                            ->maxLength(100)
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // IMPORTANT INFO - Sport and Description (key identifying info)
                    Grid::make(12)->schema([
                        Select::make('sport_id')
                            ->hiddenLabel()
                            ->placeholder(__('sports::fields.form.sport'))
                            ->relationship('sport', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpan(['default' => 12, 'xl' => 6]),
                        Textarea::make('description')
                            ->hiddenLabel()
                            ->placeholder(__('sports::fields.form.description'))
                            ->rows(2)
                            ->maxLength(1000)
                            ->columnSpan(['default' => 12, 'xl' => 6]),
                    ])->columnSpanFull(),

                    // SEPARATOR
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                    // BODY - Two columns (7/5 split)
                    Section::make()
                        ->schema([
                            Group::make([
                                TextInput::make('capacity')
                                    ->label(__('sports::fields.form.capacity'))
                                    ->inlineLabel()
                                    ->numeric()
                                    ->minValue(1)
                                    ->suffix(__('sports::fields.form.people'))
                                    ->columnSpanFull(),
                                TextInput::make('hourly_rate')
                                    ->label(__('sports::fields.form.hourly_rate'))
                                    ->inlineLabel()
                                    ->numeric()
                                    ->prefix('€')
                                    ->minValue(0)
                                    ->step(0.01)
                                    ->columnSpanFull(),
                                ColorPicker::make('color')
                                    ->label(__('sports::fields.form.color'))
                                    ->inlineLabel()
                                    ->columnSpanFull(),
                                TextInput::make('sort_order')
                                    ->label(__('sports::fields.form.sort_order'))
                                    ->inlineLabel()
                                    ->numeric()
                                    ->default(0)
                                    ->columnSpanFull(),
                            ])->columnSpan(['default' => 12, 'xl' => 7])->columns(12),

                            Group::make([
                                Toggle::make('is_indoor')
                                    ->label(__('sports::fields.form.is_indoor'))
                                    ->inlineLabel()
                                    ->default(false)
                                    ->columnSpanFull(),
                                Toggle::make('is_active')
                                    ->label(__('sports::fields.form.is_active'))
                                    ->inlineLabel()
                                    ->default(true)
                                    ->columnSpanFull(),
                            ])->columnSpan(['default' => 12, 'xl' => 5])->columns(12),
                        ])
                        ->contained(false)
                        ->columns(12)
                        ->columnSpan(12),
                ])->columnSpan(12),
            ]);
    }
}
