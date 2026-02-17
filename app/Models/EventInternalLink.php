<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventInternalLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'token',
        'name',
        'quota_ikhwan',
        'quota_akhwat',
        'usage_ikhwan',
        'usage_akhwat',
        'active_from',
        'active_until',
    ];

    protected $casts = [
        'active_from' => 'datetime',
        'active_until' => 'datetime',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Check if the link is available for registration.
     */
    public function isAvailable(?string $gender = null): bool
    {
        // Check date range if set
        $now = now();

        if ($this->active_from && $now->isBefore($this->active_from)) {
            return false;
        }

        if ($this->active_until && $now->isAfter($this->active_until)) {
            return false;
        }

        // Check quota based on gender if provided
        if ($gender === 'Laki-Laki' || $gender === 'L') {
            return $this->usage_ikhwan < $this->quota_ikhwan;
        } elseif ($gender === 'Perempuan' || $gender === 'P') {
            return $this->usage_akhwat < $this->quota_akhwat;
        }

        // If no gender specified (e.g. general check), return true if EITHER has quota
        return ($this->usage_ikhwan < $this->quota_ikhwan) || ($this->usage_akhwat < $this->quota_akhwat);
    }
}
