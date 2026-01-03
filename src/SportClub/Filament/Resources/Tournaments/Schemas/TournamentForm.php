<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
                Section::make(__('sports::tournaments.tournament_information'))
                    ->description(__('sports::tournaments.tournament_information_desc'))
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label(__('sports::tournaments.name'))
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        TextInput::make('slug')
                            ->label(__('sports::tournaments.slug'))
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('sport')
                            ->label(__('sports::tournaments.sport'))
                            ->required()
                            ->maxLength(255),

                        DatePicker::make('start_date')
                            ->label(__('sports::tournaments.start_date'))
                            ->required()
                            ->native(false),

                        DatePicker::make('end_date')
                            ->label(__('sports::tournaments.end_date'))
                            ->required()
                            ->native(false)
                            ->after('start_date'),

                        Select::make('format')
                            ->label(__('sports::tournaments.format'))
                            ->required()
                            ->options(TournamentFormat::class)
                            ->native(false),

                        Select::make('status')
                            ->label(__('sports::tournaments.status'))
                            ->required()
                            ->options(TournamentStatus::class)
                            ->native(false)
                            ->default(TournamentStatus::Draft->value),

                        TextInput::make('max_teams')
                            ->label(__('sports::tournaments.max_teams'))
                            ->numeric()
                            ->minValue(2)
                            ->default(8),

                        TextInput::make('entry_fee')
                            ->label(__('sports::tournaments.entry_fee'))
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01),

                        TextInput::make('prize')
                            ->label(__('sports::tournaments.prize'))
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01),
                    ]),

                Section::make(__('sports::tournaments.description'))
                    ->description(__('sports::tournaments.description_desc'))
                    ->schema([
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
                    ]),

                Section::make(__('sports::tournaments.rules'))
                    ->description(__('sports::tournaments.rules_desc'))
                    ->schema([
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
                    ]),
            ]);
    }
}
