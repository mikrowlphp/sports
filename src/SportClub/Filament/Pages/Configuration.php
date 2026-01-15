<?php

namespace Packages\Sports\SportClub\Filament\Pages;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Text;
use Filament\Schemas\Components\Wizard;
use Filament\Schemas\Schema;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Panel;
use App\Models\Tenant\Setting;
use Filament\Support\Enums\Size;
use Illuminate\Support\Facades\DB;
use Packages\Core\Contacts\Models\Contact;
use Packages\Sports\SportClub\Models\Field;
use Packages\Sports\SportClub\Models\Instructor;
use Packages\Sports\SportClub\Models\Sport;

class Configuration extends Page
{
    protected static string|null|\BackedEnum $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $routePath = '/configuration';

    protected string $view = 'sports::filament.pages.configuration';

    public static function getRoutePath(Panel $panel): string
    {
        return static::$routePath;
    }

    protected static ?string $navigationLabel = null;

    protected static ?string $title = null;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'sports' => [],
            'fields' => [],
            'instructors' => [],
        ]);
    }

    public static function getNavigationLabel(): string
    {
        return __('sports::configuration.navigation.label');
    }

    public function getTitle(): string
    {
        return __('sports::configuration.title');
    }

    public function getHeading(): string
    {
        return __('sports::configuration.heading');
    }

    public function getSubheading(): ?string
    {
        return __('sports::configuration.subheading');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Wizard::make([
                    Wizard\Step::make(__('sports::configuration.wizard.sports.label'))
                        ->description(__('sports::configuration.wizard.sports.description'))
                        ->icon('heroicon-o-trophy')
                        ->schema([
                            CheckboxList::make('sports')
                                ->label(__('sports::configuration.wizard.sports.sports_practiced'))
                                ->options(Sport::query()->active()->ordered()->pluck('name', 'id'))
                                ->descriptions(Sport::query()->active()->ordered()->pluck('description', 'id'))
                                ->columns(2),
                            Text::make(__('sports::configuration.wizard.sports.helper_text'))
                                ->color('info')
                                ->badge()
                                ->size(Size::ExtraLarge)
                        ]),

                    Wizard\Step::make(__('sports::configuration.wizard.fields.label'))
                        ->description(__('sports::configuration.wizard.fields.description'))
                        ->icon('heroicon-o-map')
                        ->schema([
                            Repeater::make('fields')
                                ->label(__('sports::configuration.wizard.fields.fields_and_facilities'))
                                ->schema([
                                    TextInput::make('name')
                                        ->label(__('sports::configuration.wizard.fields.field_name'))
                                        ->placeholder(__('sports::configuration.wizard.fields.field_name_placeholder'))
                                        ->required()
                                        ->maxLength(100)
                                        ->columnSpan(2),

                                    Select::make('sport_id')
                                        ->label(__('sports::configuration.wizard.fields.sport'))
                                        ->options(fn ($get) => Sport::query()
                                            ->whereIn('id', $get('../../sports') ?? [])
                                            ->pluck('name', 'id'))
                                        ->required()
                                        ->searchable()
                                        ->columnSpan(1),

                                    Textarea::make('description')
                                        ->label(__('sports::configuration.wizard.fields.description_label'))
                                        ->rows(2)
                                        ->maxLength(1000)
                                        ->columnSpan(3),

                                    TextInput::make('capacity')
                                        ->label(__('sports::configuration.wizard.fields.capacity'))
                                        ->numeric()
                                        ->minValue(1)
                                        ->suffix(__('sports::configuration.wizard.fields.people'))
                                        ->columnSpan(1),

                                    TextInput::make('hourly_rate')
                                        ->label(__('sports::configuration.wizard.fields.hourly_rate'))
                                        ->numeric()
                                        ->prefix('€')
                                        ->minValue(0)
                                        ->step(0.01)
                                        ->columnSpan(1),

                                    ColorPicker::make('color')
                                        ->label(__('sports::configuration.wizard.fields.color'))
                                        ->columnSpan(1),

                                    Toggle::make('is_indoor')
                                        ->label(__('sports::configuration.wizard.fields.indoor'))
                                        ->inline(false)
                                        ->columnSpan(1),

                                    Toggle::make('is_active')
                                        ->label(__('sports::configuration.wizard.fields.active'))
                                        ->default(true)
                                        ->inline(false)
                                        ->columnSpan(1),
                                ])
                                ->columns(3)
                                ->defaultItems(0)
                                ->addActionLabel(__('sports::configuration.wizard.fields.add_field'))
                                ->reorderable()
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string => $state['name'] ?? null)
                                ->helperText(__('sports::configuration.wizard.fields.helper_text')),
                        ]),

                    Wizard\Step::make(__('sports::configuration.wizard.instructors.label'))
                        ->description(__('sports::configuration.wizard.instructors.description'))
                        ->icon('heroicon-o-user-group')
                        ->schema([
                            Repeater::make('instructors')
                                ->label(__('sports::configuration.wizard.instructors.instructors_and_coaches'))
                                ->schema([
                                    Select::make('customer_id')
                                        ->label(__('sports::configuration.wizard.instructors.contact'))
                                        ->options(Contact::query()
                                            ->orderBy('name')
                                            ->pluck('name', 'id'))
                                        ->required()
                                        ->searchable()
                                        ->columnSpan(2),

                                    TextInput::make('hourly_rate')
                                        ->label(__('sports::configuration.wizard.instructors.hourly_rate'))
                                        ->numeric()
                                        ->prefix('€')
                                        ->minValue(0)
                                        ->step(0.01)
                                        ->columnSpan(1),

                                    TagsInput::make('specializations')
                                        ->label(__('sports::configuration.wizard.instructors.specializations'))
                                        ->placeholder(__('sports::configuration.wizard.instructors.specializations_placeholder'))
                                        ->columnSpan(3),

                                    Textarea::make('bio')
                                        ->label(__('sports::configuration.wizard.instructors.biography'))
                                        ->rows(3)
                                        ->columnSpan(3),

                                    Toggle::make('is_active')
                                        ->label(__('sports::configuration.wizard.instructors.active'))
                                        ->default(true)
                                        ->inline(false)
                                        ->columnSpan(1),
                                ])
                                ->columns(3)
                                ->defaultItems(0)
                                ->addActionLabel(__('sports::configuration.wizard.instructors.add_instructor'))
                                ->reorderable()
                                ->collapsible()
                                ->itemLabel(fn (array $state): ?string =>
                                    isset($state['customer_id'])
                                        ? Contact::find($state['customer_id'])?->name
                                        : null
                                )
                                ->helperText(__('sports::configuration.wizard.instructors.helper_text')),
                        ]),
                ])
                    ->submitAction(view('sports::filament.pages.configuration-submit-action')),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();

        try {
            DB::beginTransaction();

            // Create fields
            if (!empty($data['fields'])) {
                foreach ($data['fields'] as $fieldData) {
                    Field::create([
                        'sport_id' => $fieldData['sport_id'],
                        'name' => $fieldData['name'],
                        'description' => $fieldData['description'] ?? null,
                        'capacity' => $fieldData['capacity'] ?? null,
                        'hourly_rate' => $fieldData['hourly_rate'] ?? null,
                        'color' => $fieldData['color'] ?? null,
                        'is_indoor' => $fieldData['is_indoor'] ?? false,
                        'is_active' => $fieldData['is_active'] ?? true,
                        'sort_order' => 0,
                    ]);
                }
            }

            // Create instructors
            if (!empty($data['instructors'])) {
                foreach ($data['instructors'] as $instructorData) {
                    Instructor::create([
                        'customer_id' => $instructorData['customer_id'],
                        'specializations' => $instructorData['specializations'] ?? [],
                        'bio' => $instructorData['bio'] ?? null,
                        'hourly_rate' => $instructorData['hourly_rate'] ?? null,
                        'is_active' => $instructorData['is_active'] ?? true,
                    ]);
                }
            }

            // Mark configuration as complete
            Setting::edit('configured', true, 'sport-club', 'boolean');

            DB::commit();

            Notification::make()
                ->title(__('sports::configuration.notifications.success'))
                ->success()
                ->send();

            // Redirect to sport club dashboard
            $this->redirect(Dashboard::getUrl());

        } catch (\Exception $e) {
            DB::rollBack();

            Notification::make()
                ->title(__('sports::configuration.notifications.error'))
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }

    public static function shouldRegisterNavigation(): bool
    {
        // Hide from navigation once configured
        return !Setting::get('configured', 'sport-club', false);
    }
}
