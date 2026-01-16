<?php

namespace Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Schemas;

use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\HtmlString;

class MembershipTypeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        // HEADER ZONE - Name only (fullspan)
                        Grid::make(12)->schema([
                            TextInput::make('name')
                                ->hiddenLabel()
                                ->placeholder(__('sports::members.name'))
                                ->required()
                                ->main()
                                ->maxLength(255)
                                ->columnSpanFull(),
                        ])->columnSpanFull(),

                        // IMPORTANT INFO ZONE - Key data below name, before hr
                        Grid::make(12)->schema([
                            TextInput::make('price')
                                ->hiddenLabel()
                                ->placeholder(__('sports::members.price'))
                                ->required()
                                ->numeric()
                                ->prefix('€')
                                ->minValue(0)
                                ->step(0.01)
                                ->suffixIcon('heroicon-o-currency-euro')
                                ->columnSpan(['default' => 12, 'xl' => 6]),
                            TextInput::make('duration_days')
                                ->hiddenLabel()
                                ->placeholder(__('sports::members.duration_days'))
                                ->required()
                                ->numeric()
                                ->minValue(1)
                                ->suffix(__('sports::members.days'))
                                ->suffixIcon('heroicon-o-calendar')
                                ->columnSpan(['default' => 12, 'xl' => 6]),
                        ])->columnSpanFull(),

                        // SEPARATOR
                        Html::make("<hr class='my-6 text-gray-300 w-full' />")
                            ->columnSpanFull(),

                        // BODY ZONE - 7/5 split with inlineLabel
                        Section::make()
                            ->schema([
                                Group::make([
                                    // Slug field removed
                                ])->inlineLabel()->columns(12)->columnSpan([
                                    'default' => 12,
                                    'xl' => 7,
                                ]),
                                Group::make([
                                    Toggle::make('is_active')
                                        ->default(true)
                                        ->columnSpanFull(),
                                    KeyValue::make('benefits')
                                        ->keyLabel(__('sports::members.benefit_name'))
                                        ->valueLabel(__('sports::members.benefit_description'))
                                        ->addActionLabel(__('sports::members.add_benefit'))
                                        ->reorderable()
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
                            ->label(__('sports::members.description'))
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columns(12)
                    ->columnSpanFull(),
            ]);
    }
}
