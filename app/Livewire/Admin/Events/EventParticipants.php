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

    public $linkName;
    public $linkQuotaIkhwan;
    public $linkQuotaAkhwat;
    public $linkActiveFrom;
    public $linkActiveUntil;
    public $selectedLinkId;
    public $isEditingLink = false;

    public $manualName;
    public $manualEmail;
    public $manualPhone;
    public $manualGender = 'Laki-Laki';
    public $manualAddress;

    public $selectedParticipantId;
    public $editName;
    public $editEmail;
    public $editPhone;
    public $editGender;
    public $editAddress;

    public function mount($id)
    {
        $this->eventId = $id;
        $this->event = Event::findOrFail($id);
    }

    /**
     * Get internal links.
     */
    #[Computed]
    public function internalLinks()
    {
        return \App\Models\EventInternalLink::where('event_id', $this->eventId)
            ->latest()
            ->get();
    }

    /**
     * Save internal link (create/update).
     */
    public function saveLink()
    {
        $this->validate([
            'linkName' => 'required|string|max:255',
            'linkQuotaIkhwan' => 'required|integer|min:0',
            'linkQuotaAkhwat' => 'required|integer|min:0',
            'linkActiveFrom' => 'nullable|date',
            'linkActiveUntil' => 'nullable|date|after_or_equal:linkActiveFrom',
        ]);

        if ($this->isEditingLink) {
            $link = \App\Models\EventInternalLink::find($this->selectedLinkId);
            $link->update([
                'name' => $this->linkName,
                'quota_ikhwan' => $this->linkQuotaIkhwan,
                'quota_akhwat' => $this->linkQuotaAkhwat,
                'active_from' => $this->linkActiveFrom,
                'active_until' => $this->linkActiveUntil,
            ]);
            $this->dispatch('link-saved', 'Link berhasil diperbarui!');
        } else {
            \App\Models\EventInternalLink::create([
                'event_id' => $this->eventId,
                'token' => \Illuminate\Support\Str::random(10),
                'name' => $this->linkName,
                'quota_ikhwan' => $this->linkQuotaIkhwan,
                'quota_akhwat' => $this->linkQuotaAkhwat,
                'active_from' => $this->linkActiveFrom,
                'active_until' => $this->linkActiveUntil,
            ]);
            $this->dispatch('link-saved', 'Link internal berhasil dibuat!');
        }

        $this->resetLinkInput();
    }

    public function editLink($id)
    {
        $link = \App\Models\EventInternalLink::find($id);
        $this->selectedLinkId = $id;
        $this->linkName = $link->name;
        $this->linkQuotaIkhwan = $link->quota_ikhwan;
        $this->linkQuotaAkhwat = $link->quota_akhwat;
        $this->linkActiveFrom = $link->active_from ? $link->active_from->format('Y-m-d\TH:i') : null;
        $this->linkActiveUntil = $link->active_until ? $link->active_until->format('Y-m-d\TH:i') : null;
        $this->isEditingLink = true;
        $this->dispatch('open-link-modal');
    }

    public function deleteLink($id)
    {
        \App\Models\EventInternalLink::destroy($id);
        $this->dispatch('link-deleted', 'Link berhasil dihapus!');
    }

    public function resetLinkInput()
    {
        $this->reset(['linkName', 'linkQuotaIkhwan', 'linkQuotaAkhwat', 'linkActiveFrom', 'linkActiveUntil', 'selectedLinkId', 'isEditingLink']);
    }

    /**
     * Manual Add Participant
     */
    public function addParticipant()
    {
        $this->validate([
            'manualName' => 'required|string',
            'manualEmail' => 'required|email',
            'manualPhone' => 'required|string',
            'manualGender' => 'required|in:Laki-Laki,Perempuan',
        ]);

        // Use Service
        $data = [
            'name' => $this->manualName,
            'email' => $this->manualEmail,
            'phone' => $this->manualPhone,
            'gender' => $this->manualGender,
            'address' => $this->manualAddress,
            'password' => \Illuminate\Support\Str::random(8), // Random password
        ];

        $service = app(\App\Services\EventRegistrationService::class);
        $service->registerParticipant($this->eventId, $data);

        // Increment Quota
        $genderKey = ($this->manualGender === 'Laki-Laki') ? 'quota_ikhwan' : 'quota_akhwat';
        if ($this->event->$genderKey !== null) {
            $this->event->increment($genderKey);
        }

        $this->reset(['manualName', 'manualEmail', 'manualPhone', 'manualGender', 'manualAddress']);
        $this->dispatch('participant-added', 'Peserta berhasil ditambahkan manual!');
        $this->dispatch('close-manual-modal');
    }

    /**
     * Edit Participant
     */
    public function editParticipant($id)
    {
        $participant = EventRegistration::findOrFail($id);
        $this->selectedParticipantId = $id;
        $this->editName = $participant->name;
        $this->editEmail = $participant->email;
        $this->editPhone = $participant->phone;
        $this->editGender = $participant->gender;
        $this->editAddress = $participant->address; // Assuming address field exists in EventRegistration/User

        $this->dispatch('open-edit-participant-modal');
    }

    /**
     * Update Participant
     */
    public function updateParticipant()
    {
        $this->validate([
            'editName' => 'required|string',
            'editEmail' => 'required|email',
            'editPhone' => 'required|string',
            'editGender' => 'required|in:Laki-Laki,Perempuan,L,P',
        ]);

        $participant = EventRegistration::findOrFail($this->selectedParticipantId);
        $participant->update([
            'name' => $this->editName,
            'email' => $this->editEmail,
            'phone' => $this->editPhone,
            'gender' => $this->editGender,
            // 'address' => $this->editAddress, // Update if address exists
        ]);

        // Also update User model if exists
        if ($participant->user_id) {
            $user = \App\Models\User::find($participant->user_id);
            if ($user) {
                $user->update([
                    'name' => $this->editName,
                    'email' => $this->editEmail,
                    // 'phone' => $this->editPhone, // Update if phone exists in User
                ]);
            }
        }

        $this->dispatch('participant-updated', 'Data peserta berhasil diperbarui!');
        $this->dispatch('close-edit-participant-modal');
        $this->reset(['selectedParticipantId', 'editName', 'editEmail', 'editPhone', 'editGender', 'editAddress']);
    }

    /**
     * Reset Password
     */
    public function resetPassword($id)
    {
        $participant = EventRegistration::findOrFail($id);
        if ($participant->user_id) {
            $user = \App\Models\User::find($participant->user_id);
            if ($user) {
                $user->update([
                    'password' => bcrypt('bismillah'),
                ]);
                $this->dispatch('password-reset', 'Password berhasil direset ke "bismillah"!');
            } else {
                $this->dispatch('error', 'User tidak ditemukan.');
            }
        } else {
            $this->dispatch('error', 'Peserta tidak memiliki akun user.');
        }
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
