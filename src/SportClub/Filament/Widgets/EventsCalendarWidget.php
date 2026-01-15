<?php

namespace Packages\Sports\SportClub\Filament\Widgets;

use Guava\Calendar\Enums\CalendarViewType;
use Guava\Calendar\Filament\CalendarWidget;
use Guava\Calendar\ValueObjects\Event;
use Guava\Calendar\ValueObjects\FetchInfo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Packages\Sports\SportClub\Models\Lesson;
use Packages\Sports\SportClub\Models\SportMatch;

/**
 * Events Calendar Widget
 *
 * Displays matches and lessons in a visual calendar interface
 */
class EventsCalendarWidget extends CalendarWidget
{
    protected CalendarViewType $calendarView = CalendarViewType::TimeGridWeek;

    protected ?string $locale = 'it';

    /**
     * Get events for the calendar
     *
     * @param FetchInfo $info Contains start/end dates and other calendar view parameters
     * @return Collection|array|Builder
     */
    protected function getEvents(FetchInfo $info): Collection | array | Builder
    {
        $events = collect();

        // Fetch matches within the date range
        $matches = SportMatch::query()
            ->whereBetween('scheduled_at', [$info->start, $info->end])
            ->with(['homeTeam', 'awayTeam', 'homePlayer', 'awayPlayer', 'tournament'])
            ->get();

        foreach ($matches as $match) {
            // Determine match title based on match type
            $title = $this->getMatchTitle($match);

            $events->push(
                Event::make()
                    ->id('match-' . $match->id)
                    ->title($title)
                    ->start($match->scheduled_at)
                    ->end($match->scheduled_at->copy()->addHours(2)) // Default 2 hour duration
                    ->color($this->getMatchColor($match))
                    ->url($this->getMatchUrl($match))
            );
        }

        // Fetch lessons within the date range
        $lessons = Lesson::query()
            ->whereBetween('scheduled_at', [$info->start, $info->end])
            ->with(['instructor.contact', 'sport'])
            ->get();

        foreach ($lessons as $lesson) {
            $events->push(
                Event::make()
                    ->id('lesson-' . $lesson->id)
                    ->title($lesson->title)
                    ->start($lesson->scheduled_at)
                    ->end($lesson->scheduled_at->copy()->addMinutes($lesson->duration_minutes))
                    ->color($this->getLessonColor($lesson))
                    ->url($this->getLessonUrl($lesson))
            );
        }

        return $events;
    }

    /**
     * Get match title based on participants
     */
    protected function getMatchTitle(SportMatch $match): string
    {
        if ($match->homeTeam && $match->awayTeam) {
            // Team match
            return $match->homeTeam->name . ' vs ' . $match->awayTeam->name;
        } elseif ($match->homePlayer && $match->awayPlayer) {
            // Individual match
            return $match->homePlayer->name . ' vs ' . $match->awayPlayer->name;
        } elseif ($match->tournament) {
            // Tournament match
            return __('Tournament Match') . ' - ' . $match->tournament->name;
        }

        return __('Match') . ' #' . $match->id;
    }

    /**
     * Get match color - using a default blue color for matches
     */
    protected function getMatchColor(SportMatch $match): string
    {
        // Could be enhanced to use Field color if relationship is added
        // For now using status-based colors
        return match ($match->status->value ?? null) {
            'scheduled' => '#3b82f6', // blue
            'in_progress' => '#10b981', // green
            'completed' => '#6366f1', // indigo
            'cancelled' => '#ef4444', // red
            default => '#3b82f6', // blue
        };
    }

    /**
     * Get lesson color - using green for lessons
     */
    protected function getLessonColor(Lesson $lesson): string
    {
        // Could be enhanced to use Field color if relationship is added
        // For now using status-based colors
        return match ($lesson->status->value ?? null) {
            'scheduled' => '#10b981', // green
            'in_progress' => '#f59e0b', // amber
            'completed' => '#8b5cf6', // purple
            'cancelled' => '#ef4444', // red
            default => '#10b981', // green
        };
    }

    /**
     * Get match URL for navigation
     */
    protected function getMatchUrl(SportMatch $match): string
    {
        return route('filament.sport-club.resources.matches.edit', ['record' => $match->id]);
    }

    /**
     * Get lesson URL for navigation
     */
    protected function getLessonUrl(Lesson $lesson): string
    {
        return route('filament.sport-club.resources.lessons.edit', ['record' => $lesson->id]);
    }

    /**
     * Widget configuration
     */
    public function getOptions(): array
    {
        return [
            'headerToolbar' => [
                'start' => 'prev,next today',
                'center' => 'title',
                'end' => 'dayGridMonth,timeGridWeek,timeGridDay',
            ],
            'buttonText' => [
                'today' => __('sports::calendar.today'),
                'dayGridMonth' => __('sports::calendar.month'),
                'timeGridWeek' => __('sports::calendar.week'),
                'timeGridDay' => __('sports::calendar.day'),
            ],
            'editable' => false,
            'selectable' => false,
            'dayMaxEvents' => true,
            'navLinks' => true,
            'height' => 'auto',
            'slotMinTime' => '06:00:00',
            'slotMaxTime' => '23:00:00',
            'allDaySlot' => false,
            'nowIndicator' => true,
        ];
    }
}
