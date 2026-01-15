<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sports\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SportForm
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
                            ->placeholder(__('sports::sports.form.name'))
                            ->required()
                            ->main()
                            ->maxLength(100)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state)))
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // IMPORTANT INFO ZONE - Key identifying info (before hr)
                    Grid::make(12)->schema([
                        TextInput::make('slug')
                            ->hiddenLabel()
                            ->placeholder(__('sports::sports.form.slug'))
                            ->required()
                            ->maxLength(100)
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // SEPARATOR
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                    // BODY ZONE - Two columns (7/5 split)
                    Section::make()
                        ->schema([
                            Group::make([
                                TextInput::make('icon')
                                    ->label(__('sports::sports.form.icon'))
                                    ->placeholder('heroicon-o-...')
                                    ->maxLength(50)
                                    ->columnSpanFull(),
                                TextInput::make('sort_order')
                                    ->label(__('sports::sports.form.sort_order'))
                                    ->numeric()
                                    ->default(0)
                                    ->columnSpanFull(),
                            ])->inlineLabel()->columns(12)->columnSpan([
                                'default' => 12,
                                'xl' => 7,
                            ]),

                            Group::make([
                                Toggle::make('is_active')
                                    ->label(__('sports::sports.form.is_active'))
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

                    // NOTES ZONE - Always last, fullspan
                    Textarea::make('description')
                        ->label(__('sports::sports.form.description'))
                        ->rows(4)
                        ->maxLength(1000)
                        ->columnSpanFull(),
                ])->columns(12)->columnSpanFull(),
            ]);
    }
}
