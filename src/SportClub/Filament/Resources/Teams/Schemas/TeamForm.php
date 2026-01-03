<?php

namespace Packages\Sports\SportClub\Filament\Resources\Teams\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TeamForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sports::teams.team_information'))
                    ->description(__('sports::teams.team_information_desc'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('sports::teams.name'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('slug')
                            ->label(__('sports::teams.slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('sport')
                            ->label(__('sports::teams.sport'))
                            ->required()
                            ->maxLength(255),

                        TextInput::make('category')
                            ->label(__('sports::teams.category'))
                            ->maxLength(255),

                        TextInput::make('level')
                            ->label(__('sports::teams.level'))
                            ->maxLength(255),

                        TextInput::make('max_members')
                            ->label(__('sports::teams.max_members'))
                            ->numeric()
                            ->minValue(1)
                            ->default(20),

                        Toggle::make('is_active')
                            ->label(__('sports::teams.is_active'))
                            ->default(true),

                        FileUpload::make('logo')
                            ->label(__('sports::teams.logo'))
                            ->image()
                            ->disk('s3')
                            ->visibility('public')
                            ->directory('teams/logos')
                            ->maxSize(5120)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
