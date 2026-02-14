<?php

namespace App\Livewire\Admin\Events;

use App\Models\Event;
use App\Models\EventRegistration;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;

#[Title('Peserta Event')]
class EventParticipants extends Component
{
    use WithPagination;

    public $eventId;
    public $event;

    #[Url]
    public $search = '';

    #[Url]
    public $filterStatus = '';

    #[Url]
    public $filterGender = '';

    public $limitData = 15;

    public function mount($id)
    {
        $this->eventId = $id;
        $this->event = Event::findOrFail($id);
    }

    /**
     * Get filtered registrations.
     */
    #[Computed]
    public function registrations()
    {
        return EventRegistration::with('user')
            ->where('event_id', $this->eventId)
            ->when($this->search, function ($q) {
                return $q->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%')
                        ->orWhere('phone', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->filterStatus, function ($q) {
                return $q->where('payment_status', $this->filterStatus);
            })
            ->when($this->filterGender, function ($q) {
                if ($this->filterGender === 'L') {
                    return $q->whereIn('gender', ['L', 'Laki-Laki']);
                } elseif ($this->filterGender === 'P') {
                    return $q->whereIn('gender', ['P', 'Perempuan']);
                }
            })
            ->orderBy('registered_at', 'desc')
            ->paginate($this->limitData);
    }

    /**
     * Get total registrations count.
     */
    #[Computed]
    public function totalRegistrations()
    {
        return EventRegistration::where('event_id', $this->eventId)->count();
    }

    /**
     * Get confirmed registrations count.
     */
    #[Computed]
    public function confirmedCount()
    {
        return EventRegistration::where('event_id', $this->eventId)
            ->where('payment_status', 'valid')
            ->count();
    }

    /**
     * Get pending registrations count.
     */
    #[Computed]
    public function pendingCount()
    {
        return EventRegistration::where('event_id', $this->eventId)
            ->where('payment_status', 'pending')
            ->count();
    }

    /**
     * Get rejected registrations count.
     */
    #[Computed]
    public function rejectedCount()
    {
        return EventRegistration::where('event_id', $this->eventId)
            ->where('payment_status', 'invalid')
            ->count();
    }

    /**
     * Get ikhwan (male) registrations count.
     */
    #[Computed]
    public function ikhwanCount()
    {
        return EventRegistration::where('event_id', $this->eventId)
            ->whereIn('gender', ['L', 'Laki-Laki'])
            ->count();
    }

    /**
     * Get akhwat (female) registrations count.
     */
    #[Computed]
    public function akhwatCount()
    {
        return EventRegistration::where('event_id', $this->eventId)
            ->whereIn('gender', ['P', 'Perempuan'])
            ->count();
    }

    /**
     * Confirm payment.
     */
    public function confirmPayment($id)
    {
        EventRegistration::where('id', $id)->update(['payment_status' => 'valid']);
        $this->dispatch('payment-confirmed');
    }

    /**
     * Reject payment.
     */
    public function rejectPayment($id)
    {
        EventRegistration::where('id', $id)->update(['payment_status' => 'invalid']);
        $this->dispatch('payment-rejected');
    }

    /**
     * Delete registration.
     */
    public function deleteRegistration($id)
    {
        EventRegistration::destroy($id);
        $this->dispatch('registration-deleted');
    }

    /**
     * Reset filters.
     */
    public function resetFilters()
    {
        $this->reset(['search', 'filterStatus', 'filterGender']);
    }

    public function render()
    {
        return view('livewire.admin.events.event-participants')
            ->layout('layouts.app', ['title' => 'Peserta: ' . $this->event->title]);
    }
}
