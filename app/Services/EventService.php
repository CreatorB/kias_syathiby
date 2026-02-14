<?php

namespace App\Services;

use App\Models\Event;
use App\Models\EventRegistration;

class EventService
{
    /**
     * Get all published events with pagination.
     */
    public function getPublishedEvents(int $limit = 12)
    {
        return Event::published()
            ->orderBy('start_date', 'asc')
            ->paginate($limit);
    }

    /**
     * Get active events (published and not ended).
     */
    public function getActiveEvents(int $limit = 12)
    {
        return Event::active()
            ->orderBy('start_date', 'asc')
            ->paginate($limit);
    }

    /**
     * Get upcoming events.
     */
    public function getUpcomingEvents(int $limit = 6)
    {
        return Event::upcoming()
            ->orderBy('start_date', 'asc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get event by slug.
     */
    public function getEventBySlug(string $slug)
    {
        return Event::where('slug', $slug)->firstOrFail();
    }

    /**
     * Get total registrations for an event.
     */
    public function getTotalRegistrations(int $eventId): int
    {
        return EventRegistration::where('event_id', $eventId)->count();
    }

    /**
     * Get confirmed registrations count.
     */
    public function getConfirmedRegistrations(int $eventId): int
    {
        return EventRegistration::where('event_id', $eventId)
            ->where('payment_status', 'valid')
            ->count();
    }

    /**
     * Get pending payments count.
     */
    public function getPendingPayments(int $eventId): int
    {
        return EventRegistration::where('event_id', $eventId)
            ->where('payment_status', 'pending')
            ->count();
    }

    /**
     * Get total attendance count.
     */
    public function getTotalAttendance(int $eventId): int
    {
        return EventRegistration::where('event_id', $eventId)
            ->whereHas('attendances')
            ->count();
    }

    /**
     * Get event statistics.
     */
    public function getEventStatistics(int $eventId): array
    {
        return [
            'total' => $this->getTotalRegistrations($eventId),
            'confirmed' => $this->getConfirmedRegistrations($eventId),
            'pending' => $this->getPendingPayments($eventId),
            'attended' => $this->getTotalAttendance($eventId),
        ];
    }
}
