<?php

namespace Packages\Sports\SportClub\Filament\Resources\Lessons\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Packages\Sports\SportClub\Enums\LessonStatus;
use Packages\Sports\SportClub\Enums\LessonType;

class LessonsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label(__('sports::lessons.title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('instructor.customer.name')
                    ->label(__('sports::lessons.instructor'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('lesson_type')
                    ->label(__('sports::lessons.lesson_type'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => LessonType::from($state)->getLabel())
                    ->color(fn (string $state): string => match($state) {
                        LessonType::Individual->value => 'info',
                        LessonType::Group->value => 'success',
                        LessonType::Workshop->value => 'warning',
                        default => 'gray',
                    }),

                TextColumn::make('scheduled_at')
                    ->label(__('sports::lessons.scheduled_at'))
                    ->dateTime()
                    ->sortable(),

                TextColumn::make('participants_display')
                    ->label(__('sports::lessons.participants'))
                    ->formatStateUsing(function ($record): string {
                        $current = $record->participants()->count();
                        $max = $record->max_participants ?? '∞';
                        return "{$current}/{$max}";
                    })
                    ->sortable(query: function ($query, string $direction): void {
                        $query->withCount('participants')
                            ->orderBy('participants_count', $direction);
                    }),

                TextColumn::make('price_per_person')
                    ->label(__('sports::lessons.price'))
                    ->money('EUR')
                    ->sortable(),

                TextColumn::make('status')
                    ->label(__('sports::lessons.status'))
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => LessonStatus::from($state)->getLabel())
                    ->color(fn (string $state): string => match($state) {
                        LessonStatus::Scheduled->value => 'info',
                        LessonStatus::InProgress->value => 'warning',
                        LessonStatus::Completed->value => 'success',
                        LessonStatus::Cancelled->value => 'danger',
                        default => 'gray',
                    }),

                TextColumn::make('created_at')
                    ->label(__('sports::lessons.created_at'))
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('sports::lessons.filter_by_status'))
                    ->options(LessonStatus::class),

                SelectFilter::make('lesson_type')
                    ->label(__('sports::lessons.filter_by_lesson_type'))
                    ->options(LessonType::class),

                SelectFilter::make('instructor_id')
                    ->label(__('sports::lessons.filter_by_instructor'))
                    ->relationship('instructor.customer', 'name')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('scheduled_at', 'desc');
    }
}
