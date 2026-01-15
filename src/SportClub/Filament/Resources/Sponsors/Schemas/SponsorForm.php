<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sponsors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Enums\IconPosition;
use Illuminate\Support\Str;

class SponsorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // HEADER ZONE - Name + Logo
                    Grid::make(12)->schema([
                        Section::make([
                            TextInput::make('name')
                                ->hiddenLabel()
                                ->placeholder(__('sports::sponsors.name_placeholder'))
                                ->required()
                                ->main()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->columnSpan([
                                    'default' => 12,
                                    'lg' => 8,
                                ]),
                            FileUpload::make('logo')
                                ->hiddenLabel()
                                ->image()
                                ->imageEditor()
                                ->disk('s3')
                                ->directory(fn (Get $get) => 'sponsors/' . Str::slug($get('name') ?: 'new'))
                                ->visibility('private')
                                ->avatar()
                                ->nullable()
                                ->extraFieldWrapperAttributes([
                                    'class' => 'justify-start lg:justify-end',
                                ])
                                ->columnOrder(['default' => 1, 'lg' => 2])
                                ->columnSpan(['default' => 12, 'lg' => 4]),
                        ])->contained(false)->columns(12)->columnSpan(['default' => 12]),
                    ])->columnSpanFull(),

                    // IMPORTANT INFO ZONE - URL before hr
                    Grid::make(12)->schema([
                        TextInput::make('url')
                            ->hiddenLabel()
                            ->placeholder(__('sports::sponsors.url'))
                            ->url()
                            ->nullable()
                            ->maxLength(255)
                            ->suffixIcon('heroicon-o-link')
                            ->suffixIconColor('gray')
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // SEPARATOR
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")
                        ->columnSpanFull(),

                    // BODY ZONE - 7/5 split for secondary fields
                    Section::make()
                        ->schema([
                            Group::make([
                                // Left column (empty for now - reserved for future fields)
                            ])->inlineLabel()->columnSpan([
                                'default' => 12,
                                'xl' => 7,
                            ])->columns(12),
                            Group::make([
                                // Right column - Active toggle
                                Toggle::make('active')
                                    ->label(__('sports::sponsors.active'))
                                    ->default(true)
                                    ->columnSpanFull(),
                            ])->inlineLabel()->columnSpan([
                                'default' => 12,
                                'xl' => 5,
                            ])->columns(12),
                        ])
                        ->contained(false)
                        ->columns(12)
                        ->columnSpanFull(),

                    // NOTES ZONE - Always last, fullspan
                    Textarea::make('description')
                        ->label(__('sports::sponsors.description'))
                        ->rows(4)
                        ->nullable()
                        ->columnSpanFull(),
                ])->columns(12)->columnSpanFull(),
            ]);
    }
}
