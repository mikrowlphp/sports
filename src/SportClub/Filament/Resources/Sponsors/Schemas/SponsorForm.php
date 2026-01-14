<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sponsors\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class SponsorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sports::sponsors.sponsor_information'))
                    ->description(__('sports::sponsors.sponsor_information_desc'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('sports::sponsors.name'))
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->columnSpanFull(),

                        FileUpload::make('logo')
                            ->label(__('sports::sponsors.logo'))
                            ->image()
                            ->imageEditor()
                            ->disk('s3')
                            ->directory(fn (Get $get) => 'sponsors/' . Str::slug($get('name') ?: 'new'))
                            ->visibility('private')
                            ->helperText(__('sports::sponsors.logo_helper'))
                            ->columnSpanFull(),

                        TextInput::make('url')
                            ->label(__('sports::sponsors.url'))
                            ->url()
                            ->nullable()
                            ->maxLength(255)
                            ->helperText(__('sports::sponsors.url_helper'))
                            ->columnSpanFull(),

                        Toggle::make('active')
                            ->label(__('sports::sponsors.active'))
                            ->default(true)
                            ->helperText(__('sports::sponsors.active_helper')),
                    ]),
            ]);
    }
}
