<?php

namespace App\Livewire\Peserta;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Computed;
use App\Models\EventRegistration;
use App\Models\EventAttendance;
use Illuminate\Support\Facades\Auth;

#[Title('Riwayat Event')]
class EventHistory extends Component
{
    use WithPagination;

    public $limitData = 10;

    /**
     * Mark attendance for an event registration.
     */
    public function markAttendance($registrationId)
    {
        $registration = EventRegistration::with('event')
            ->where('user_id', Auth::id())
            ->where('id', $registrationId)
            ->first();

        if (!$registration) {
            session()->flash('error', 'Pendaftaran tidak ditemukan.');
            return;
        }

        // Check if event has attendance feature
        if (!$registration->event->has_attendance) {
            session()->flash('error', 'Event ini tidak memiliki fitur absensi.');
            return;
        }

        // Check if event is ongoing
        if (!$registration->event->isEventOngoing()) {
            session()->flash('error', 'Absensi hanya dapat dilakukan pada saat acara berlangsung.');
            return;
        }

        // Check if payment is confirmed (for paid events)
        if ($registration->event->is_paid && $registration->payment_status !== 'valid') {
            session()->flash('error', 'Pembayaran belum dikonfirmasi.');
            return;
        }

        // Check if already attended today
        $today = now()->toDateString();
        $alreadyAttended = EventAttendance::where('event_registration_id', $registrationId)
            ->whereDate('attended_at', $today)
            ->exists();

        if ($alreadyAttended) {
            session()->flash('error', 'Anda sudah absen hari ini.');
            return;
        }

        // Create attendance record
        EventAttendance::create([
            'event_registration_id' => $registrationId,
            'attended_at' => now(),
        ]);

        session()->flash('success', 'Absensi berhasil dicatat!');
    }

    /**
     * Get user's event registrations.
     */
    #[Computed]
    public function registrations()
    {
        return EventRegistration::with(['event', 'attendances'])
            ->where('user_id', Auth::id())
            ->orderBy('registered_at', 'desc')
            ->paginate($this->limitData);
    }

    /**
     * Get total events count.
     */
    #[Computed]
    public function totalEvents()
    {
        return EventRegistration::where('user_id', Auth::id())->count();
    }

    /**
     * Get confirmed events count.
     */
    #[Computed]
    public function confirmedCount()
    {
        return EventRegistration::where('user_id', Auth::id())
            ->where('payment_status', 'valid')
            ->count();
    }

    public function render()
    {
        return view('livewire.peserta.event-history')
            ->layout('layouts.app', ['title' => 'Riwayat Event']);
    }
}
