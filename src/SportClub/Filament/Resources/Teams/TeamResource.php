<?php

namespace Packages\Sports\SportClub\Filament\Resources\Teams;

use BackedEnum;
use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\Teams\Pages\CreateTeam;
use Packages\Sports\SportClub\Filament\Resources\Teams\Pages\EditTeam;
use Packages\Sports\SportClub\Filament\Resources\Teams\Pages\ListTeams;
use Packages\Sports\SportClub\Filament\Resources\Teams\Schemas\TeamForm;
use Packages\Sports\SportClub\Filament\Resources\Teams\Tables\TeamsTable;
use Packages\Sports\SportClub\Models\Team;

class TeamResource extends Resource
{
    protected static ?string $model = Team::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('sports::teams.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sports::teams.navigation.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sports::teams.navigation.group');
    }

    public static function form(Schema $schema): Schema
    {
        return TeamForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return TeamsTable::configure($table);
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
            'index' => ListTeams::route('/'),
            'create' => CreateTeam::route('/create'),
            'edit' => EditTeam::route('/{record}/edit'),
        ];
    }
}
