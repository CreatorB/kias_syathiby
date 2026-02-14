<?php

namespace App\Http\Controllers\Guest;

use App\Models\Event;
use App\Models\Lembaga;
use App\Models\EventRegistration;
use App\Http\Controllers\Controller;
use App\Services\EventService;
use App\Services\EventRegistrationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    protected $eventService;
    protected $registrationService;

    public function __construct(EventService $eventService, EventRegistrationService $registrationService)
    {
        $this->eventService = $eventService;
        $this->registrationService = $registrationService;
    }

    /**
     * Display list of events.
     */
    public function index()
    {
        $data = [
            'title' => 'Daftar Event',
            'lembaga' => Lembaga::find(1),
            'events' => $this->eventService->getPublishedEvents(12),
        ];

        return view('guest.events.index', $data);
    }

    /**
     * Display event detail.
     */
    public function show($slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $user = Auth::user();
        $isRegistered = false;
        $registration = null;

        if ($user) {
            $registration = $this->registrationService->getUserRegistration($event->id, $user->id);
            $isRegistered = $registration !== null;
        }

        $data = [
            'title' => $event->title,
            'lembaga' => Lembaga::find(1),
            'event' => $event,
            'user' => $user,
            'isRegistered' => $isRegistered,
            'registration' => $registration,
        ];

        return view('guest.events.show', $data);
    }

    /**
     * Handle event registration.
     */
    public function register(Request $request, $slug)
    {
        $event = Event::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Check if registration is open
        if (!$event->isRegistrationOpen()) {
            return back()->with('error', 'Pendaftaran sudah ditutup atau belum dibuka.');
        }

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

        // Require password for non-logged in users
        if (!Auth::check()) {
            $rules['password'] = 'required|string|min:6|confirmed';
        }

        if ($event->is_paid) {
            $rules['payment_proof'] = 'required|image|max:1024';
        }

        $request->validate($rules);

        // Map gender value to code for quota checking
        $genderCode = $request->gender === 'Laki-Laki' ? 'L' : 'P';

        // Check if quota is available for this gender
        if (!$event->hasQuotaFor($genderCode)) {
            $genderLabel = $genderCode === 'L' ? 'Ikhwan' : 'Akhwat';
            return back()->with('error', "Kuota untuk {$genderLabel} sudah penuh.")->withInput();
        }

        $data = $request->only([
            'name', 'phone', 'email', 'gender',
            'address', 'birth_place', 'birth_date', 'occupation', 'password'
        ]);

        // Handle payment proof upload (Windows compatible)
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

        // Auto-login the user if they weren't logged in before
        if (!$wasLoggedIn && $registration->user_id) {
            Auth::loginUsingId($registration->user_id);
        }

        return redirect()->route('events.success', [
            'slug' => $slug,
        ])->with('success', 'Pendaftaran berhasil!');
    }

    /**
     * Registration success page.
     */
    public function success($slug)
    {
        $event = Event::where('slug', $slug)->firstOrFail();

        $data = [
            'title' => 'Pendaftaran Berhasil',
            'lembaga' => Lembaga::find(1),
            'event' => $event,
        ];

        return view('guest.events.success', $data);
    }
}
