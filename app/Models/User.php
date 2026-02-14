<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role_id',
        'phone',
        'address',
        'gender',
        'birth_place',
        'birth_date',
        'occupation',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birth_date' => 'date',
    ];

    /**
     * Get the role that owns the user.
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the event registrations for the user.
     */
    public function eventRegistrations(): HasMany
    {
        return $this->hasMany(EventRegistration::class);
    }

    /**
     * Check if user is root.
     */
    public function isRoot(): bool
    {
        return $this->role_id === 1;
    }

    /**
     * Check if user is superadmin.
     */
    public function isSuperadmin(): bool
    {
        return $this->role_id === 1;
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return in_array($this->role_id, [1, 2]);
    }

    /**
     * Check if user is santri.
     */
    public function isSantri(): bool
    {
        return $this->role_id === 3;
    }

    /**
     * Check if user is peserta.
     */
    public function isPeserta(): bool
    {
        return $this->role_id === 4;
    }

    /**
     * Check if user has complete profile data.
     */
    public function hasCompleteProfile(): bool
    {
        return !empty($this->nama) &&
               !empty($this->phone) &&
               !empty($this->address) &&
               !empty($this->gender) &&
               !empty($this->birth_place) &&
               !empty($this->birth_date) &&
               !empty($this->occupation);
    }

    /**
     * Check if user has a specific permission.
     * Superadmin always has all permissions.
     */
    public function hasPermission(string $permissionName): bool
    {
        // Superadmin has all permissions
        if ($this->isSuperadmin()) {
            return true;
        }

        return $this->role?->hasPermission($permissionName) ?? false;
    }

    /**
     * Check if user can view user photos.
     */
    public function canViewUserPhotos(): bool
    {
        return $this->hasPermission('view_user_photos');
    }
}
