<?php

namespace Packages\Sports\SportClub\Filament\Resources\SponsorContracts;

use BackedEnum;
use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Pages\CreateSponsorContract;
use Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Pages\EditSponsorContract;
use Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Pages\ListSponsorContracts;
use Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Schemas\SponsorContractForm;
use Packages\Sports\SportClub\Filament\Resources\SponsorContracts\Tables\SponsorContractsTable;
use Packages\Sports\SportClub\Models\SponsorContract;

class SponsorContractResource extends Resource
{
    protected static ?string $model = SponsorContract::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    public static function getModelLabel(): string
    {
        return __('sports::sponsor_contracts.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sports::sponsor_contracts.navigation.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sports::sponsor_contracts.navigation.group');
    }

    public static function form(Schema $schema): Schema
    {
        return SponsorContractForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SponsorContractsTable::configure($table);
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
            'index' => ListSponsorContracts::route('/'),
            'create' => CreateSponsorContract::route('/create'),
            'edit' => EditSponsorContract::route('/{record}/edit'),
        ];
    }
}
