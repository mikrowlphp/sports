<?php

namespace Packages\Sports\SportClub\Filament\Resources\Matches\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Packages\Sports\SportClub\Enums\MatchStatus;
use Packages\Sports\SportClub\Enums\MatchType;
use Packages\Sports\SportClub\Filament\Forms\Components\SponsorPlacementField;

class MatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('sports::matches.match_information'))
                    ->description(__('sports::matches.match_information_desc'))
                    ->columns(2)
                    ->schema([
                        Select::make('match_type')
                            ->label(__('sports::matches.match_type'))
                            ->required()
                            ->options(MatchType::class)
                            ->native(false)
                            ->default(MatchType::Team->value)
                            ->live(),

                        Select::make('status')
                            ->label(__('sports::matches.status'))
                            ->required()
                            ->options(MatchStatus::class)
                            ->native(false)
                            ->default(MatchStatus::Scheduled->value),

                        DateTimePicker::make('scheduled_at')
                            ->label(__('sports::matches.scheduled_at'))
                            ->required()
                            ->native(false)
                            ->seconds(false),

                        TextInput::make('court')
                            ->label(__('sports::matches.court'))
                            ->maxLength(255),
                    ]),

                Section::make(__('sports::matches.team_match'))
                    ->description(__('sports::matches.team_match_desc'))
                    ->columns(2)
                    ->visible(fn (Get $get) => $get('match_type') === MatchType::Team->value)
                    ->schema([
                        Select::make('home_team_id')
                            ->label(__('sports::matches.home_team'))
                            ->relationship('homeTeam', 'name')
                            ->required(fn (Get $get) => $get('match_type') === MatchType::Team->value)
                            ->searchable()
                            ->preload(),

                        Select::make('away_team_id')
                            ->label(__('sports::matches.away_team'))
                            ->relationship('awayTeam', 'name')
                            ->required(fn (Get $get) => $get('match_type') === MatchType::Team->value)
                            ->searchable()
                            ->preload(),
                    ]),

                Section::make(__('sports::matches.individual_match'))
                    ->description(__('sports::matches.individual_match_desc'))
                    ->columns(2)
                    ->visible(fn (Get $get) => $get('match_type') === MatchType::Individual->value)
                    ->schema([
                        Select::make('home_player_id')
                            ->label(__('sports::matches.home_player'))
                            ->relationship('homePlayer', 'name')
                            ->required(fn (Get $get) => $get('match_type') === MatchType::Individual->value)
                            ->searchable()
                            ->preload(),

                        Select::make('away_player_id')
                            ->label(__('sports::matches.away_player'))
                            ->relationship('awayPlayer', 'name')
                            ->required(fn (Get $get) => $get('match_type') === MatchType::Individual->value)
                            ->searchable()
                            ->preload(),
                    ]),

                Section::make(__('sports::matches.video_section'))
                    ->description(__('sports::matches.video_section_desc'))
                    ->schema([
                        Toggle::make('recording_enabled')
                            ->label(__('sports::matches.recording_enabled'))
                            ->default(false)
                            ->live(),

                        TextInput::make('video_url')
                            ->label(__('sports::matches.video_url'))
                            ->placeholder(__('sports::matches.video_url_placeholder'))
                            ->url()
                            ->visible(fn (Get $get) => $get('recording_enabled')),

                        SponsorPlacementField::make('sponsorPlacements')
                            ->label(__('sports::matches.sponsor_placements'))
                            ->visible(fn (Get $get) => $get('recording_enabled'))
                            ->columnSpanFull(),
                    ])
                    ->collapsible()
                    ->collapsed(fn (?Model $record) => $record && !$record->recording_enabled),

                Section::make(__('sports::matches.notes'))
                    ->description(__('sports::matches.notes_desc'))
                    ->schema([
                        Textarea::make('notes')
                            ->label(__('sports::matches.notes'))
                            ->rows(4)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull()
            ]);
    }
}
