<?php

namespace App\Http\Controllers\Guest;

use App\Models\Event;
use App\Models\EventInternalLink;
use App\Services\EventRegistrationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Lembaga;

class InternalEventController extends Controller
{
    protected $registrationService;

    public function __construct(EventRegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }

    /**
     * Show registration form for internal link.
     */
    public function show($slug, $token)
    {
        $event = Event::where('slug', $slug)
            ->whereIn('status', ['published', 'internal'])
            ->firstOrFail();
        $link = EventInternalLink::where('token', $token)
            ->where('event_id', $event->id)
            ->firstOrFail();

        if (!$link->isAvailable()) {
            if ($event->status === 'internal') {
                abort(404);
            }
            return redirect()->route('events.show', $slug)
                ->with('error', 'Link pendaftaran internal ini sudah tidak berlaku atau kuota link penuh.');
        }

        $user = Auth::user();
        $isRegistered = false;
        $registration = null;

        if ($user) {
            $registration = $this->registrationService->getUserRegistration($event->id, $user->id);
            $isRegistered = $registration !== null;
        }

        $data = [
            'title' => $event->title . ' (Internal)',
            'lembaga' => Lembaga::find(1),
            'event' => $event,
            'user' => $user,
            'isRegistered' => $isRegistered,
            'registration' => $registration,
            'internalLink' => $link,
        ];

        // Reuse the guest event show view, but we might want to pass a flag or use a specific view
        // For now, let's reuse and handle the internal logic in the view or controller
        // Actually, we should use the same view but maybe add a hidden field or different submit URL
        return view('guest.events.show_internal', $data);
    }

    /**
     * Handle internal registration.
     */
    public function store(Request $request, $slug, $token)
    {
        $event = Event::where('slug', $slug)
            ->whereIn('status', ['published', 'internal'])
            ->firstOrFail();
        $link = EventInternalLink::where('token', $token)
            ->where('event_id', $event->id)
            ->firstOrFail();

        if (!$link->isAvailable()) {
            return back()->with('error', 'Link pendaftaran internal ini sudah tidak berlaku atau kuota link penuh.');
        }

        // Validate similar to regular registration
        $rules = [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'gender' => 'required|in:Laki-Laki,Perempuan',
            'address' => 'nullable|string',
            'birth_place' => 'nullable|string|max:100',
            'birth_date' => 'nullable|date',
            'occupation' => 'nullable|string|max:100',
        ];

        if (!Auth::check()) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        if ($event->is_paid) {
            $rules['payment_proof'] = 'required|image|max:1024';
        }

        $request->validate($rules);

        if (!$link->isAvailable($request->gender)) {
            return back()->with('error', "Mohon maaf, kuota pendaftaran jalur internal untuk {$request->gender} sudah penuh.");
        }

        // Process Registration
        $data = $request->only([
            'name',
            'phone',
            'email',
            'gender',
            'address',
            'birth_place',
            'birth_date',
            'occupation',
            'password'
        ]);

        if ($request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $uploadPath = public_path('berkas' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR . 'payments');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            $extension = $file->getClientOriginalExtension() ?: 'jpg';
            $filename = date('Y-m-d-H-i-s') . '-' . uniqid() . '.' . $extension;
            $destination = $uploadPath . DIRECTORY_SEPARATOR . $filename;

            if (copy($file->getRealPath(), $destination)) {
                $data['payment_proof'] = $filename;
            }
        }

        $userId = Auth::check() ? Auth::id() : null;
        $wasLoggedIn = Auth::check();

        $registration = $this->registrationService->registerParticipant(
            $event->id,
            $data,
            $userId
        );

        // Auto-login logic
        if (!$wasLoggedIn && $registration->user_id) {
            Auth::loginUsingId($registration->user_id);
        }

        // Increment Internal Link Usage based on gender
        if ($request->gender === 'Laki-Laki') {
            $link->increment('usage_ikhwan');
        } else {
            $link->increment('usage_akhwat');
        }

        // Increment Main Event Quota to reflect this new addition
        // We only increment the specific gender quota that was used
        $genderKey = ($request->gender === 'Laki-Laki') ? 'quota_ikhwan' : 'quota_akhwat';
        if ($event->$genderKey !== null) {
            $event->increment($genderKey);
        }

        return redirect()->route('events.success', ['slug' => $slug])
            ->with('success', 'Pendaftaran jalur internal berhasil!');
    }
}
