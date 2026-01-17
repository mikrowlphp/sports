<?php

namespace Packages\Sports\SportClub\Filament\Resources\Tournaments\Widgets;

use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Packages\Core\Shared\Filament\Widgets\FormToolbarWidget;
use Packages\Sports\SportClub\Enums\TournamentStatus;

/**
 * TournamentToolbar
 *
 * Odoo-style toolbar for tournament edit page.
 * Actions on the left, status stepper on the right.
 */
class TournamentToolbar extends FormToolbarWidget
{
    protected static string $statusEnum = TournamentStatus::class;

    protected static string $statusField = 'status';

    protected static bool $stepperClickable = true;

    protected int|string|array $columnSpan = 'full';

    /**
     * Flow statuses: the main linear progression.
     * Bozza → Iscrizioni Aperte → In Corso → Completato
     */
    public function getFlowStatuses(): array
    {
        return [
            TournamentStatus::Draft,
            TournamentStatus::RegistrationOpen,
            TournamentStatus::InProgress,
            TournamentStatus::Completed,
        ];
    }

    /**
     * Terminal label: shown when status is Cancelled.
     */
    public function getTerminalLabel(): ?string
    {
        return match ($this->record?->status) {
            TournamentStatus::Cancelled => __('Annullato'),
            default => null,
        };
    }

    /**
     * List of toolbar action names (without 'Action' suffix).
     */
    public function getToolbarActionNames(): array
    {
        return ['openRegistrations', 'closeRegistrations', 'startTournament', 'completeTournament', 'cancel', 'reopen'];
    }

    public function openRegistrationsAction(): Action
    {
        return Action::make('openRegistrations')
            ->label(__('Apri Iscrizioni'))
            ->icon('heroicon-o-user-plus')
            ->color('success')
            ->size('sm')
            ->visible(fn () => $this->record?->status === TournamentStatus::Draft)
            ->action(function () {
                $this->record->status = TournamentStatus::RegistrationOpen;
                $this->record->save();

                Notification::make()
                    ->title(__('Iscrizioni aperte'))
                    ->success()
                    ->send();
            });
    }

    public function closeRegistrationsAction(): Action
    {
        return Action::make('closeRegistrations')
            ->label(__('Chiudi Iscrizioni'))
            ->icon('heroicon-o-lock-closed')
            ->color('warning')
            ->size('sm')
            ->visible(fn () => $this->record?->status === TournamentStatus::RegistrationOpen)
            ->requiresConfirmation()
            ->modalHeading(__('Chiudi Iscrizioni'))
            ->modalDescription(__('Vuoi chiudere le iscrizioni a questo torneo?'))
            ->action(function () {
                $this->record->status = TournamentStatus::Draft;
                $this->record->save();

                Notification::make()
                    ->title(__('Iscrizioni chiuse'))
                    ->warning()
                    ->send();
            });
    }

    public function startTournamentAction(): Action
    {
        return Action::make('startTournament')
            ->label(__('Avvia Torneo'))
            ->icon('heroicon-o-play')
            ->color('primary')
            ->size('sm')
            ->visible(fn () => in_array($this->record?->status, [TournamentStatus::Draft, TournamentStatus::RegistrationOpen]))
            ->requiresConfirmation()
            ->modalHeading(__('Avvia Torneo'))
            ->modalDescription(__('Vuoi avviare questo torneo?'))
            ->action(function () {
                $this->record->status = TournamentStatus::InProgress;
                $this->record->save();

                Notification::make()
                    ->title(__('Torneo avviato'))
                    ->success()
                    ->send();
            });
    }

    public function completeTournamentAction(): Action
    {
        return Action::make('completeTournament')
            ->label(__('Completa Torneo'))
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->size('sm')
            ->visible(fn () => $this->record?->status === TournamentStatus::InProgress)
            ->requiresConfirmation()
            ->modalHeading(__('Completa Torneo'))
            ->modalDescription(__('Vuoi segnare questo torneo come completato?'))
            ->action(function () {
                $this->record->status = TournamentStatus::Completed;
                $this->record->save();

                Notification::make()
                    ->title(__('Torneo completato'))
                    ->success()
                    ->send();
            });
    }

    public function cancelAction(): Action
    {
        return Action::make('cancel')
            ->label(__('Annulla'))
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->size('sm')
            ->visible(fn () => in_array($this->record?->status, [TournamentStatus::Draft, TournamentStatus::RegistrationOpen, TournamentStatus::InProgress]))
            ->requiresConfirmation()
            ->modalHeading(__('Annulla Torneo'))
            ->modalDescription(__('Sei sicuro di voler annullare questo torneo?'))
            ->action(function () {
                $this->record->status = TournamentStatus::Cancelled;
                $this->record->save();

                Notification::make()
                    ->title(__('Torneo annullato'))
                    ->warning()
                    ->send();
            });
    }

    public function reopenAction(): Action
    {
        return Action::make('reopen')
            ->label(__('Riapri'))
            ->icon('heroicon-o-arrow-path')
            ->color('gray')
            ->size('sm')
            ->visible(fn () => $this->record?->status === TournamentStatus::Cancelled)
            ->requiresConfirmation()
            ->modalHeading(__('Riapri Torneo'))
            ->modalDescription(__('Vuoi riaprire questo torneo?'))
            ->action(function () {
                $this->record->status = TournamentStatus::Draft;
                $this->record->save();

                Notification::make()
                    ->title(__('Torneo riaperto'))
                    ->info()
                    ->send();
            });
    }
}
