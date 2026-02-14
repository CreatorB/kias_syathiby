<?php

namespace App\Services;

use App\Models\User;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventAttendance;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EventRegistrationService
{
    /**
     * Register a participant for an event.
     */
    public function registerParticipant(int $eventId, array $data, ?int $userId = null): EventRegistration
    {
        // If not logged in, check if user exists or create new
        if (!$userId) {
            $email = strtolower(trim($data['email'])); // Normalize email
            $user = User::whereRaw('LOWER(email) = ?', [$email])->first();

            if (!$user) {
                // Use password from registration form or generate random if not provided
                $password = $data['password'] ?? Str::random(8);
                $user = User::create([
                    'nama' => $data['name'],
                    'email' => $email,
                    'password' => Hash::make($password),
                    'role_id' => 4, // peserta
                    'phone' => $data['phone'] ?? null,
                    'address' => $data['address'] ?? null,
                    'gender' => $data['gender'] ?? null,
                    'birth_place' => $data['birth_place'] ?? null,
                    'birth_date' => $data['birth_date'] ?? null,
                    'occupation' => $data['occupation'] ?? null,
                ]);
                \Log::info('EventRegistration: Created new user', ['email' => $email, 'user_id' => $user->id]);
            } else {
                // User exists - update password if provided in registration form
                if (!empty($data['password'])) {
                    $user->password = Hash::make($data['password']);
                    $user->save();
                    \Log::info('EventRegistration: Updated password for existing user', ['email' => $user->email, 'user_id' => $user->id]);
                }
            }
            $userId = $user->id;
        }

        // Check if already registered
        $existingRegistration = EventRegistration::where('event_id', $eventId)
            ->where('user_id', $userId)
            ->first();

        if ($existingRegistration) {
            return $existingRegistration;
        }

        // Get event to check auto_accept setting
        $event = Event::find($eventId);

        // Determine payment status based on auto_accept setting
        // If auto_accept is enabled, set status to 'valid', otherwise 'pending'
        $paymentStatus = ($event && $event->auto_accept) ? 'valid' : 'pending';

        // Create registration
        return EventRegistration::create([
            'event_id' => $eventId,
            'user_id' => $userId,
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'address' => $data['address'] ?? null,
            'gender' => $data['gender'],
            'birth_place' => $data['birth_place'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'occupation' => $data['occupation'] ?? null,
            'payment_proof' => $data['payment_proof'] ?? null,
            'payment_status' => $paymentStatus,
            'registered_at' => now(),
        ]);
    }

    /**
     * Confirm payment for a registration.
     */
    public function confirmPayment(int $registrationId): bool
    {
        return EventRegistration::where('id', $registrationId)
            ->update(['payment_status' => 'valid']);
    }

    /**
     * Reject payment for a registration.
     */
    public function rejectPayment(int $registrationId): bool
    {
        return EventRegistration::where('id', $registrationId)
            ->update(['payment_status' => 'invalid']);
    }

    /**
     * Mark attendance for a participant.
     */
    public function markAttendance(int $registrationId): EventAttendance
    {
        // Check if already marked today
        $existing = EventAttendance::where('event_registration_id', $registrationId)
            ->whereDate('attended_at', today())
            ->first();

        if ($existing) {
            return $existing;
        }

        return EventAttendance::create([
            'event_registration_id' => $registrationId,
            'attended_at' => now(),
        ]);
    }

    /**
     * Remove attendance for a participant (today only).
     */
    public function removeAttendance(int $registrationId): bool
    {
        return EventAttendance::where('event_registration_id', $registrationId)
            ->whereDate('attended_at', today())
            ->delete();
    }

    /**
     * Get user's event history.
     */
    public function getUserEventHistory(int $userId, int $limit = 10)
    {
        return EventRegistration::with(['event', 'attendances'])
            ->where('user_id', $userId)
            ->orderBy('registered_at', 'desc')
            ->paginate($limit);
    }

    /**
     * Check if user is registered for an event.
     */
    public function isUserRegistered(int $eventId, int $userId): bool
    {
        return EventRegistration::where('event_id', $eventId)
            ->where('user_id', $userId)
            ->exists();
    }

    /**
     * Get user's registration for an event.
     */
    public function getUserRegistration(int $eventId, int $userId): ?EventRegistration
    {
        return EventRegistration::where('event_id', $eventId)
            ->where('user_id', $userId)
            ->first();
    }
}
