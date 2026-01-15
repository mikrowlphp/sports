<?php

namespace Packages\Sports\SportClub\Filament\Resources\Instructors\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Html;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class InstructorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    // Header - Customer select only (main identifier)
                    Grid::make(12)->schema([
                        Select::make('customer_id')
                            ->hiddenLabel()
                            ->placeholder(__('sports::instructors.customer'))
                            ->relationship('customer', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                    ])->columnSpanFull(),

                    // Important info below name (before hr)
                    Grid::make(12)->schema([
                        TextInput::make('hourly_rate')
                            ->hiddenLabel()
                            ->placeholder(__('sports::instructors.hourly_rate'))
                            ->numeric()
                            ->prefix('€')
                            ->minValue(0)
                            ->step(0.01)
                            ->suffixIcon(Heroicon::CurrencyEuro)
                            ->columnSpan([
                                'default' => 12,
                                'xl' => 6,
                            ]),
                    ])->columnSpanFull(),

                    // Separator
                    Html::make("<hr class='my-6 text-gray-300 w-full' />")->columnSpanFull(),

                    // Body
                    TagsInput::make('specializations')
                        ->label(__('sports::instructors.specializations'))
                        ->placeholder(__('sports::instructors.specializations_placeholder'))
                        ->columnSpanFull(),

                    // Bio - Always last, fullspan (like notes)
                    Textarea::make('bio')
                        ->label(__('sports::instructors.bio'))
                        ->rows(4)
                        ->columnSpanFull(),

                ])->columns(12)->columnSpanFull(),
            ]);
    }
}
