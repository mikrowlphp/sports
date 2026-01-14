<?php

namespace Packages\Sports\SportClub\Filament\Resources\Sponsors;

use BackedEnum;
use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\Sponsors\Pages\CreateSponsor;
use Packages\Sports\SportClub\Filament\Resources\Sponsors\Pages\EditSponsor;
use Packages\Sports\SportClub\Filament\Resources\Sponsors\Pages\ListSponsors;
use Packages\Sports\SportClub\Filament\Resources\Sponsors\Schemas\SponsorForm;
use Packages\Sports\SportClub\Filament\Resources\Sponsors\Tables\SponsorsTable;
use Packages\Sports\SportClub\Models\Sponsor;

class SponsorResource extends Resource
{
    protected static ?string $model = Sponsor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedMegaphone;

    public static function form(Schema $schema): Schema
    {
        return SponsorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SponsorsTable::configure($table);
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
            'index' => ListSponsors::route('/'),
            'create' => CreateSponsor::route('/create'),
            'edit' => EditSponsor::route('/{record}/edit'),
        ];
    }
}
