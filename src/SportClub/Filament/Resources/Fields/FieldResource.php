<?php

namespace Packages\Sports\SportClub\Filament\Resources\Fields;

use App\Library\Extensions\Resource;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Models\Field;
use Packages\Sports\SportClub\Filament\Resources\Fields\Pages;
use Packages\Sports\SportClub\Filament\Resources\Fields\Schemas\FieldForm;
use Packages\Sports\SportClub\Filament\Resources\Fields\Tables\FieldsTable;

class FieldResource extends Resource
{
    protected static ?string $model = Field::class;
    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-map';
    protected static ?int $navigationSort = 2;

    public static function getModelLabel(): string
    {
        return __('sports::fields.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sports::fields.navigation.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sports::fields.navigation.group');
    }

    public static function form(Schema $schema): Schema
    {
        return FieldForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FieldsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFields::route('/'),
            'create' => Pages\CreateField::route('/create'),
            'edit' => Pages\EditField::route('/{record}/edit'),
        ];
    }
}
