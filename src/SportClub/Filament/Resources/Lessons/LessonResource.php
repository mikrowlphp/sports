<?php

namespace Packages\Sports\SportClub\Filament\Resources\Lessons;

use App\Library\Extensions\Resource;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Filament\Resources\Lessons\Pages\CreateLesson;
use Packages\Sports\SportClub\Filament\Resources\Lessons\Pages\EditLesson;
use Packages\Sports\SportClub\Filament\Resources\Lessons\Pages\ListLessons;
use Packages\Sports\SportClub\Filament\Resources\Lessons\Schemas\LessonForm;
use Packages\Sports\SportClub\Filament\Resources\Lessons\Tables\LessonsTable;
use Packages\Sports\SportClub\Models\Lesson;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function getModelLabel(): string
    {
        return __('sports::lessons.navigation.label');
    }

    public static function getPluralModelLabel(): string
    {
        return __('sports::lessons.navigation.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('sports::lessons.navigation.group');
    }

    public static function form(Schema $schema): Schema
    {
        return LessonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return LessonsTable::configure($table);
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
            'index' => ListLessons::route('/'),
            'create' => CreateLesson::route('/create'),
            'edit' => EditLesson::route('/{record}/edit'),
        ];
    }
}
