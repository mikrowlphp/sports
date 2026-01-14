<?php

namespace Packages\Sports\SportClub\Filament\Resources\Instructors;

use App\Library\Extensions\Resource;
use BackedEnum;

use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\Instructors\Pages\CreateInstructor;
use Packages\Sports\SportClub\Filament\Resources\Instructors\Pages\EditInstructor;
use Packages\Sports\SportClub\Filament\Resources\Instructors\Pages\ListInstructors;
use Packages\Sports\SportClub\Filament\Resources\Instructors\Schemas\InstructorForm;
use Packages\Sports\SportClub\Filament\Resources\Instructors\Tables\InstructorsTable;
use Packages\Sports\SportClub\Models\Instructor;

class InstructorResource extends Resource
{
    protected static ?string $model = Instructor::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return InstructorForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return InstructorsTable::configure($table);
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
            'index' => ListInstructors::route('/'),
            'create' => CreateInstructor::route('/create'),
            'edit' => EditInstructor::route('/{record}/edit'),
        ];
    }
}
