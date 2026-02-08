<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;

    protected $table = 'program';
    protected $guarded = [];

    public function santri(): HasMany
    {
        return $this->hasMany(Santri::class, 'program_id', 'id');
    }

    //Jumlah pendaftar TQ
    public static function daftarTajwid($tahunPsb) {
        return Program::with(['santri' => function($query) use($tahunPsb) {
            $query->where('tahun_psb', $tahunPsb)
            ->select('nama','program_id');
        }])
        ->where('jenis_program_id', 1)
        ->get();
    }

    //Jumlah Pendaftar BA
    public static function daftarBahasa($tahunPsb) {
        return Program::with(['santri' => function($query) use($tahunPsb) {
            $query->where('tahun_psb', $tahunPsb)
            ->select('nama','program_id');
        }])
        ->where('jenis_program_id', 2)
        ->where('status_psb', 'Buka')
        ->get();
    }

    //Jumlah Pendaftar Takmili
    public static function daftarTakmili($tahunPsb) {
        return Program::with(['santri' => function($query) use($tahunPsb) {
            $query->where('tahun_psb', $tahunPsb)
            ->select('nama','program_id');
        }])
        ->where('jenis_program_id', 4)
        ->get();
    }

    //Jumlah Pendaftar Syariah
    public static function daftarSyariah($tahunPsb) {
        return Program::with(['santri' => function($query) use($tahunPsb) {
            $query->where('tahun_psb', $tahunPsb)
            ->select('nama','program_id');
        }])
        ->where('jenis_program_id', 3)
        ->get();
    }

    public static function jumlahPendaftarPerCabang($tahunPsb) {
        return Program::with(['santri' => function($query) use($tahunPsb) {
            $query->where('tahun_psb', $tahunPsb)
            ->select('nama','program_id');
        }])
        ->where('status_psb', 'Buka')
        ->get();
    }
}
