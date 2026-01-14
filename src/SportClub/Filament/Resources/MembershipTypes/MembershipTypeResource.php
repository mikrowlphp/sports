<?php

namespace Packages\Sports\SportClub\Filament\Resources\MembershipTypes;

use BackedEnum;
use App\Library\Extensions\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Pages\CreateMembershipType;
use Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Pages\EditMembershipType;
use Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Pages\ListMembershipTypes;
use Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Schemas\MembershipTypeForm;
use Packages\Sports\SportClub\Filament\Resources\MembershipTypes\Tables\MembershipTypesTable;
use Packages\Sports\SportClub\Models\MembershipType;

class MembershipTypeResource extends Resource
{
    protected static ?string $model = MembershipType::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static string|\UnitEnum|null $navigationGroup = 'Members';

    public static function form(Schema $schema): Schema
    {
        return MembershipTypeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return MembershipTypesTable::configure($table);
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
            'index' => ListMembershipTypes::route('/'),
            'create' => CreateMembershipType::route('/create'),
            'edit' => EditMembershipType::route('/{record}/edit'),
        ];
    }
}
