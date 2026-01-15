<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sports;

use App\Library\Extensions\Resource;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Models\Sport;
use Packages\Sports\SportClub\Filament\Resources\Sports\Pages;
use Packages\Sports\SportClub\Filament\Resources\Sports\Schemas\SportForm;
use Packages\Sports\SportClub\Filament\Resources\Sports\Tables\SportsTable;

class SportResource extends Resource
{
    protected static ?string $model = Sport::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-trophy';
    protected static ?int $navigationSort = 1;

    public static function getModelLabel(): string
    {
        return __('sports::sports.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sports::sports.navigation.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sports::sports.navigation.group');
    }

    public static function form(Schema $schema): Schema
    {
        return SportForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SportsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSports::route('/'),
            'create' => Pages\CreateSport::route('/create'),
            'edit' => Pages\EditSport::route('/{record}/edit'),
        ];
    }
}
