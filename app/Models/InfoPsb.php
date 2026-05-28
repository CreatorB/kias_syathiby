<?php

namespace App\Models;

use App\Providers\StatusProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class InfoPsb extends Model
{
    use HasFactory;

    protected $table = 'info_psb';
    protected $guarded = [];

protected $fillable = [
        'biaya_sarana_prasarana',
        'biaya_kuliah_perdana',
        'biaya_spp_bulanan',
        'link_group',
    ];

    protected $casts = [
        'datetime_open' => 'datetime',
        'datetime_closed' => 'datetime',
        'poster_images' => 'array',
        'biaya_pendaftaran' => 'integer',
        'biaya_sarana_prasana' => 'integer',
        'biaya_kuliah_perdana' => 'integer',
        'biaya_spp_bulanan' => 'integer',
    ];

    public function santris(): HasMany
    {
        return $this->hasMany(Santri::class, 'tahun_psb', 'tahun_ajaran');
    }

    public function isOpen(): bool
    {
        $now = now();

        if ($this->datetime_open && $this->datetime_closed) {
            return $now->between($this->datetime_open, $this->datetime_closed);
        }

        return $this->status_psb === 'Buka';
    }

    public function getStatusTextAttribute(): string
    {
        if (!$this->isOpen()) {
            return 'TUTUP';
        }

        if ($this->datetime_open && $this->datetime_closed) {
            $now = now();
            if ($now->lt($this->datetime_open)) {
                return 'BELUM BUKA';
            }
            if ($now->gt($this->datetime_closed)) {
                return 'SUDAH TUTUP';
            }
        }

        return 'BUKA';
    }

    public function getRegisteredIkhwanCountAttribute(): int
    {
        return $this->santris()
            ->where('jk', 'Laki-Laki')
            ->where('status_transfer', StatusProvider::TRANSFER_VALID)
            ->count();
    }

    public function getRegisteredAkhwatCountAttribute(): int
    {
        return $this->santris()
            ->where('jk', 'Perempuan')
            ->where('status_transfer', StatusProvider::TRANSFER_VALID)
            ->count();
    }

    public function getRemainingQuotaIkhwanAttribute(): ?int
    {
        if ($this->quota_ikhwan === null) {
            return null;
        }
        return max(0, $this->quota_ikhwan - $this->registered_ikhwan_count);
    }

    public function getRemainingQuotaAkhwatAttribute(): ?int
    {
        if ($this->quota_akhwat === null) {
            return null;
        }
        return max(0, $this->quota_akhwat - $this->registered_akhwat_count);
    }

    public function hasQuotaFor(string $gender): bool
    {
        if ($gender === 'Laki-Laki') {
            return $this->quota_ikhwan === null || $this->remaining_quota_ikhwan > 0;
        }

        if ($gender === 'Perempuan') {
            return $this->quota_akhwat === null || $this->remaining_quota_akhwat > 0;
        }

        return true;
    }

    public function canRegister(?string $gender = null): bool
    {
        if (!$this->isOpen()) {
            return false;
        }

        if ($gender && !$this->hasQuotaFor($gender)) {
            return false;
        }

        return true;
    }

    public static function getActiveYear(): ?string
    {
        $psb = static::where('status_psb', 'Buka')
            ->orWhere(function($q) {
                $q->where('datetime_open', '<=', now())
                  ->where('datetime_closed', '>=', now());
            })
            ->orderBy('id', 'desc')
            ->first();

        return $psb?->tahun_ajaran;
    }
}
