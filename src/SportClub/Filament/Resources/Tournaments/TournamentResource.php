<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\Pages\CreateTournament;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\Pages\EditTournament;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\Pages\ListTournaments;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\Schemas\TournamentForm;
use Packages\Sports\SportClub\Filament\Resources\Tournaments\Tables\TournamentsTable;
use Packages\Sports\SportClub\Models\Tournament;

class TournamentResource extends Resource
{
    protected static ?string $model = Tournament::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TournamentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TournamentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListTournaments::route('/'),
            'create' => CreateTournament::route('/create'),
            'edit' => EditTournament::route('/{record}/edit'),
        ];
    }
}
