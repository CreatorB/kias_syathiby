<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'content',
        'image',
        'images',
        'start_date',
        'end_date',
        'registration_start',
        'registration_end',
        'is_paid',
        'price',
        'has_attendance',
        'has_certificate',
        'certificate_template',
        'certificate_font',
        'certificate_font_color',
        'certificate_font_size',
        'certificate_name_x',
        'certificate_name_y',
        'status',
        'group_ikhwan',
        'group_akhwat',
        'group_public',
        'quota_ikhwan',
        'quota_akhwat',
        'auto_accept',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'registration_start' => 'datetime',
        'registration_end' => 'datetime',
        'is_paid' => 'boolean',
        'has_attendance' => 'boolean',
        'has_certificate' => 'boolean',
        'auto_accept' => 'boolean',
        'price' => 'decimal:2',
        'images' => 'array',
    ];

    /**
     * Get all images (combines legacy single image with new multiple images).
     * Filters out invalid paths and ensures only filenames are returned.
     */
    public function getAllImages(): array
    {
        $images = $this->images ?? [];

        // Ensure images is an array
        if (!is_array($images)) {
            $images = [];
        }

        // Include legacy single image if exists and not already in images array
        if ($this->image && !in_array($this->image, $images)) {
            array_unshift($images, $this->image);
        }

        // Filter and clean image paths - only keep filenames that exist
        $cleanImages = [];
        foreach ($images as $img) {
            if (!$img) continue;

            // Extract just the filename if full path is stored
            $filename = basename($img);

            // Check if file exists in the expected location
            $fullPath = public_path('berkas' . DIRECTORY_SEPARATOR . 'events' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . $filename);
            if (file_exists($fullPath)) {
                $cleanImages[] = $filename;
            }
        }

        return $cleanImages;
    }

    /**
     * Generate unique slug from title.
     */
    public static function generateSlug(string $title): string
    {
        $slug = Str::slug($title);
        $count = static::where('slug', 'like', $slug . '%')->count();

        return $count > 0 ? "{$slug}-{$count}" : $slug;
    }

    /**
     * Get the registrations for the event.
     */
    public function registrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Scope a query to only include published events.
     */
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope a query to only include active events.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'published')
                     ->where('end_date', '>=', now());
    }

    /**
     * Scope a query to only include upcoming events.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('status', 'published')
                     ->where('start_date', '>=', now());
    }

    /**
     * Check if event is free.
     */
    public function isFree(): bool
    {
        return !$this->is_paid;
    }

    /**
     * Get confirmed participants count.
     */
    public function getConfirmedCountAttribute(): int
    {
        return $this->registrations()->where('payment_status', 'valid')->count();
    }

    /**
     * Get pending participants count.
     */
    public function getPendingCountAttribute(): int
    {
        return $this->registrations()->where('payment_status', 'pending')->count();
    }

    /**
     * Check if registration is open.
     */
    public function isRegistrationOpen(): bool
    {
        $now = now();

        // If registration dates not set, use event dates
        $regStart = $this->registration_start ?? $this->start_date->subDays(30);
        $regEnd = $this->registration_end ?? $this->start_date;

        return $now->between($regStart, $regEnd) && $this->status === 'published';
    }

    /**
     * Check if event is currently happening (for attendance).
     */
    public function isEventOngoing(): bool
    {
        $now = now();
        return $now->between($this->start_date, $this->end_date);
    }

    /**
     * Check if event has ended.
     */
    public function hasEnded(): bool
    {
        return now()->isAfter($this->end_date);
    }

    /**
     * Get group links based on user gender.
     * Supports both short format (L/P) and full format (Laki-Laki/Perempuan)
     */
    public function getGroupsForGender(?string $gender): array
    {
        $groups = [];

        // Normalize gender to handle both formats
        $isMale = in_array($gender, ['L', 'Laki-Laki']);
        $isFemale = in_array($gender, ['P', 'Perempuan']);

        if ($isMale && $this->group_ikhwan) {
            $groups['ikhwan'] = $this->group_ikhwan;
        }

        if ($isFemale && $this->group_akhwat) {
            $groups['akhwat'] = $this->group_akhwat;
        }

        if ($this->group_public) {
            $groups['public'] = $this->group_public;
        }

        return $groups;
    }

    /**
     * Get registered count for ikhwan (male).
     */
    public function getRegisteredIkhwanCountAttribute(): int
    {
        return $this->registrations()
            ->whereIn('gender', ['L', 'Laki-Laki'])
            ->whereIn('payment_status', ['pending', 'valid'])
            ->count();
    }

    /**
     * Get registered count for akhwat (female).
     */
    public function getRegisteredAkhwatCountAttribute(): int
    {
        return $this->registrations()
            ->whereIn('gender', ['P', 'Perempuan'])
            ->whereIn('payment_status', ['pending', 'valid'])
            ->count();
    }

    /**
     * Get remaining quota for ikhwan.
     */
    public function getRemainingQuotaIkhwanAttribute(): ?int
    {
        if ($this->quota_ikhwan === null) {
            return null; // Unlimited
        }
        return max(0, $this->quota_ikhwan - $this->registered_ikhwan_count);
    }

    /**
     * Get remaining quota for akhwat.
     */
    public function getRemainingQuotaAkhwatAttribute(): ?int
    {
        if ($this->quota_akhwat === null) {
            return null; // Unlimited
        }
        return max(0, $this->quota_akhwat - $this->registered_akhwat_count);
    }

    /**
     * Check if quota is available for given gender.
     */
    public function hasQuotaFor(string $gender): bool
    {
        if ($gender === 'L') {
            return $this->quota_ikhwan === null || $this->remaining_quota_ikhwan > 0;
        }

        if ($gender === 'P') {
            return $this->quota_akhwat === null || $this->remaining_quota_akhwat > 0;
        }

        return true;
    }

    /**
     * Check if user can register (considering registration period and quota).
     */
    public function canRegister(?string $gender = null): bool
    {
        // Check if registration is open
        if (!$this->isRegistrationOpen()) {
            return false;
        }

        // Check quota if gender is provided
        if ($gender && !$this->hasQuotaFor($gender)) {
            return false;
        }

        return true;
    }

    /**
     * Get quota status message for given gender.
     */
    public function getQuotaStatusFor(string $gender): array
    {
        if ($gender === 'L') {
            $quota = $this->quota_ikhwan;
            $registered = $this->registered_ikhwan_count;
            $remaining = $this->remaining_quota_ikhwan;
            $label = 'Ikhwan';
        } else {
            $quota = $this->quota_akhwat;
            $registered = $this->registered_akhwat_count;
            $remaining = $this->remaining_quota_akhwat;
            $label = 'Akhwat';
        }

        return [
            'label' => $label,
            'quota' => $quota,
            'registered' => $registered,
            'remaining' => $remaining,
            'is_full' => $quota !== null && $remaining === 0,
            'is_unlimited' => $quota === null,
        ];
    }
}
