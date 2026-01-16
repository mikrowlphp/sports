<?php

namespace Packages\Sports\SportClub\Filament\Resources\Fields\Pages;

use App\Library\Extensions\Pages\EditRecord;
use Packages\Sports\SportClub\Filament\Resources\Fields\FieldResource;
use Filament\Actions;

class EditField extends EditRecord
{
    protected static string $resource = FieldResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('toggle_status')
                ->label(fn () => $this->record->is_active
                    ? __('sports::fields.actions.deactivate')
                    : __('sports::fields.actions.activate'))
                ->icon(fn () => $this->record->is_active
                    ? 'heroicon-o-x-circle'
                    : 'heroicon-o-check-circle')
                ->color(fn () => $this->record->is_active ? 'danger' : 'success')
                ->action(function () {
                    $this->record->update([
                        'is_active' => !$this->record->is_active,
                    ]);

                    \Filament\Notifications\Notification::make()
                        ->title(__('sports::fields.notifications.status_updated'))
                        ->success()
                        ->send();
                }),
            Actions\DeleteAction::make(),
        ];
    }
}
