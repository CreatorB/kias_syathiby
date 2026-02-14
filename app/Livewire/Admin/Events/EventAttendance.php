<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventAttendance as Attendance;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

#[Title('Absensi Event')]
class EventAttendance extends Component
{
    use WithPagination;

    public $eventId;
    public $event;

    #[Url]
    public $search = '';

    #[Url]
    public $filterDate = '';

    public $limitData = 20;

    public function mount($id)
    {
        $this->eventId = $id;
        $this->event = Event::findOrFail($id);
        $this->filterDate = now()->format('Y-m-d');
    }

    /**
     * Get confirmed participants.
     */
    #[Computed]
    public function participants()
    {
        return EventRegistration::with(['attendances' => function ($q) {
                if ($this->filterDate) {
                    $q->whereDate('attended_at', $this->filterDate);
                }
            }])
            ->where('event_id', $this->eventId)
            ->where('payment_status', 'valid')
            ->when($this->search, function ($q) {
                return $q->where('name', 'like', '%' . $this->search . '%');
            })
            ->orderBy('name', 'asc')
            ->paginate($this->limitData);
    }

    /**
     * Get total confirmed participants.
     */
    #[Computed]
    public function totalParticipants()
    {
        return EventRegistration::where('event_id', $this->eventId)
            ->where('payment_status', 'valid')
            ->count();
    }

    /**
     * Get attended count for selected date.
     */
    #[Computed]
    public function attendedCount()
    {
        return Attendance::whereHas('registration', function ($q) {
                $q->where('event_id', $this->eventId);
            })
            ->when($this->filterDate, function ($q) {
                return $q->whereDate('attended_at', $this->filterDate);
            })
            ->count();
    }

    /**
     * Mark attendance.
     */
    public function markAttendance($registrationId)
    {
        $existing = Attendance::where('event_registration_id', $registrationId)
            ->whereDate('attended_at', $this->filterDate ?: today())
            ->first();

        if (!$existing) {
            Attendance::create([
                'event_registration_id' => $registrationId,
                'attended_at' => $this->filterDate ? $this->filterDate . ' ' . now()->format('H:i:s') : now(),
            ]);
        }

        $this->dispatch('attendance-marked');
    }

    /**
     * Remove attendance.
     */
    public function removeAttendance($registrationId)
    {
        Attendance::where('event_registration_id', $registrationId)
            ->whereDate('attended_at', $this->filterDate ?: today())
            ->delete();

        $this->dispatch('attendance-removed');
    }

    /**
     * Check if participant attended on selected date.
     */
    public function hasAttendedOnDate($registration): bool
    {
        return $registration->attendances->isNotEmpty();
    }

    /**
     * Reset filters.
     */
    public function resetFilters()
    {
        $this->reset(['search']);
        $this->filterDate = now()->format('Y-m-d');
    }

    public function render()
    {
        return view('livewire.admin.events.event-attendance')
            ->layout('layouts.app', ['title' => 'Absensi: ' . $this->event->title]);
    }
}
