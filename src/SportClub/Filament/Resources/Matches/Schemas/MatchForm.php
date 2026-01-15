<?php

namespace Packages\Sports\SportClub\Filament\Resources\Matches\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Packages\Sports\SportClub\Enums\MatchStatus;
use Packages\Sports\SportClub\Enums\MatchType;
use Packages\Sports\SportClub\Filament\Forms\Components\SponsorPlacementField;

class MatchForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // Header - Name only
                    Grid::make(12)->schema([
                        TextInput::make('name')
                            ->hiddenLabel()
                            ->placeholder(__('sports::matches.name'))
                            ->required()
                            ->maxLength(255)
                            ->main()
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // Important info below name (before hr)
                    Grid::make(12)->schema([
                        DateTimePicker::make('scheduled_at')
                            ->hiddenLabel()
                            ->placeholder(__('sports::matches.scheduled_at'))
                            ->required()
                            ->native(false)
                            ->seconds(false)
                            ->suffixIcon(Heroicon::Calendar)
                            ->columnSpan([
                                'default' => 12,
                                'xl' => 6,
                            ]),
                        TextInput::make('court')
                            ->hiddenLabel()
                            ->placeholder(__('sports::matches.court'))
                            ->maxLength(255)
                            ->suffixIcon(Heroicon::MapPin)
                            ->columnSpan([
                                'default' => 12,
                                'xl' => 6,
                            ]),
                    ])->columnSpanFull(),

                    // Separator
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                    // Body - Two columns
                    Section::make()
                        ->schema([
                            // Left column - Main fields
                            Group::make([
                                Select::make('match_type')
                                    ->placeholder(__('sports::matches.match_type'))
                                    ->required()
                                    ->options(MatchType::class)
                                    ->native(false)
                                    ->default(MatchType::Team->value)
                                    ->live()
                                    ->columnSpanFull(),

                                Select::make('status')
                                    ->placeholder(__('sports::matches.status'))
                                    ->required()
                                    ->options(MatchStatus::class)
                                    ->native(false)
                                    ->default(MatchStatus::Scheduled->value)
                                    ->columnSpanFull(),

                                // Team Match Fields
                                Section::make(__('sports::matches.team_match'))
                                    ->description(__('sports::matches.team_match_desc'))
                                    ->schema([
                                        Select::make('home_team_id')
                                            ->hiddenLabel()
                                            ->placeholder(__('sports::matches.home_team'))
                                            ->relationship('homeTeam', 'name')
                                            ->required(fn (Get $get) => $get('match_type') === MatchType::Team->value)
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(['default' => 12, 'lg' => 6]),

                                        Select::make('away_team_id')
                                            ->hiddenLabel()
                                            ->placeholder(__('sports::matches.away_team'))
                                            ->relationship('awayTeam', 'name')
                                            ->required(fn (Get $get) => $get('match_type') === MatchType::Team->value)
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(['default' => 12, 'lg' => 6]),
                                    ])
                                    ->columns(12)
                                    ->visible(fn (Get $get) => $get('match_type') === MatchType::Team->value)
                                    ->columnSpanFull(),

                                // Individual Match Fields
                                Section::make(__('sports::matches.individual_match'))
                                    ->description(__('sports::matches.individual_match_desc'))
                                    ->schema([
                                        Select::make('home_player_id')
                                            ->hiddenLabel()
                                            ->placeholder(__('sports::matches.home_player'))
                                            ->relationship('homePlayer', 'name')
                                            ->required(fn (Get $get) => $get('match_type') === MatchType::Individual->value)
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(['default' => 12, 'lg' => 6]),

                                        Select::make('away_player_id')
                                            ->hiddenLabel()
                                            ->placeholder(__('sports::matches.away_player'))
                                            ->relationship('awayPlayer', 'name')
                                            ->required(fn (Get $get) => $get('match_type') === MatchType::Individual->value)
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(['default' => 12, 'lg' => 6]),
                                    ])
                                    ->columns(12)
                                    ->visible(fn (Get $get) => $get('match_type') === MatchType::Individual->value)
                                    ->columnSpanFull(),

                            ])->inlineLabel()->columns(12)->columnSpan([
                                'default' => 12,
                                'xl' => 7,
                            ]),

                            // Right column - Secondary fields
                            Group::make([
                                Toggle::make('recording_enabled')
                                    ->label(__('sports::matches.recording_enabled'))
                                    ->default(false)
                                    ->live()
                                    ->columnSpanFull(),

                                TextInput::make('video_url')
                                    ->label(__('sports::matches.video_url'))
                                    ->placeholder(__('sports::matches.video_url_placeholder'))
                                    ->url()
                                    ->visible(fn (Get $get) => $get('recording_enabled'))
                                    ->columnSpanFull(),
                            ])->inlineLabel()->columns(12)->columnSpan([
                                'default' => 12,
                                'xl' => 5,
                            ]),
                        ])
                        ->contained(false)
                        ->columns(12)
                        ->columnSpanFull(),

                    // Sponsor Placement - Full width at bottom (only when recording enabled)
                    Section::make(__('sports::matches.sponsor_placements'))
                        ->description(__('sports::matches.video_section_desc'))
                        ->schema([
                            SponsorPlacementField::make('sponsorPlacements')
                                ->hiddenLabel()
                                ->columnSpanFull(),
                        ])
                        ->visible(fn (Get $get) => $get('recording_enabled'))
                        ->columnSpanFull(),

                    // Notes - Always last, fullspan
                    Textarea::make('notes')
                        ->label(__('sports::matches.notes'))
                        ->rows(4)
                        ->columnSpanFull(),

                ])->columns(12)->columnSpanFull(),
            ]);
    }
}
