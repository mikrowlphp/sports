<?php

namespace Packages\Sports\SportClub\Filament\Resources\Matches;

use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\Matches\Pages\CreateMatch;
use Packages\Sports\SportClub\Filament\Resources\Matches\Pages\EditMatch;
use Packages\Sports\SportClub\Filament\Resources\Matches\Pages\ListMatches;
use Packages\Sports\SportClub\Filament\Resources\Matches\Schemas\MatchForm;
use Packages\Sports\SportClub\Filament\Resources\Matches\Tables\MatchesTable;
use Packages\Sports\SportClub\Models\SportMatch;

class MatchResource extends Resource
{
    protected static ?string $model = SportMatch::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return MatchForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MatchesTable::configure($table);
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
            'index' => ListMatches::route('/'),
            'create' => CreateMatch::route('/create'),
            'edit' => EditMatch::route('/{record}/edit'),
        ];
    }
}
