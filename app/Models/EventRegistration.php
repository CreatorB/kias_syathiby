<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EventRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'user_id',
        'name',
        'phone',
        'email',
        'address',
        'gender',
        'birth_place',
        'birth_date',
        'occupation',
        'payment_proof',
        'payment_status',
        'registered_at',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'registered_at' => 'datetime',
    ];

    /**
     * Get the event that owns the registration.
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the user that owns the registration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the attendances for the registration.
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(EventAttendance::class);
    }

    /**
     * Check if payment is confirmed.
     */
    public function isPaymentConfirmed(): bool
    {
        return $this->payment_status === 'valid';
    }

    /**
     * Check if payment is pending.
     */
    public function isPaymentPending(): bool
    {
        return $this->payment_status === 'pending';
    }

    /**
     * Check if participant has attended.
     */
    public function hasAttended(): bool
    {
        return $this->attendances()->exists();
    }

    /**
     * Get total attendance count.
     */
    public function getAttendanceCountAttribute(): int
    {
        return $this->attendances()->count();
    }
}
