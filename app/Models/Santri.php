<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Santri extends Model
{
    use HasFactory;

    const STATUS_MENUNGGU = 'Menunggu';
    const STATUS_DITERIMA = 'Diterima';
    const STATUS_DITOLAK = 'Ditolak';

    protected $table = 'santri';
    protected $fillable = [
        'kode_registrasi',
        'nama',
        'jk',
        'nik',
        'nisn',
        'tmp_lahir',
        'tgl_lahir',
        'alamat',
        'nama_ayah',
        'no_hp_ayah',
        'nama_ibu',
        'no_hp_ibu',
        'nama_wali',
        'no_hp_wali',
        'email',
        'hp',
        'kode_negara',
        'no_hp',
        'tahun_psb',
        'status_pendaftaran',
        'status_transfer',
        'program_id',
        'pekerjaan_id',
        'pendidikan',
        'pekerjaan',
        'photo',
        'ktp',
        'transfer',
        'nominal_transfer',
        'alasan_penolakan',
        'tgl_verifikasi',
        'user_id',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class, 'program_id', 'id');
    }

public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class, 'pekerjaan_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'santri_id');
    }

    public static function cariNama($tahunPsb, $dataSearch)
    {
        return Santri::join('program', 'santri.program_id', 'program.id')
            ->where('tahun_psb', $tahunPsb)
            ->where('nama', 'like', '%' . $dataSearch . '%')
            ->select('nama', 'jk', 'hp', 'santri.created_at', 'kode_registrasi', 'nama_program')
            ->get();
    }

    public static function cariNamaSemua($tahunPsb)
    {
        return Santri::join('program', 'santri.program_id', 'program.id')
            ->where('tahun_psb', $tahunPsb)
            ->select('nama', 'jk', 'hp', 'santri.created_at', 'kode_registrasi', 'nama_program')
            ->get();
    }

    public static function queryPendaftaran($tahunPsb, $filterData = null)
    {
        return Santri::with([
            'program'
        ])
            ->when($filterData != null && isset($filterData['namaSantri']), function ($q) use ($filterData) {
                return $q->where('nama', 'like', '%' . $filterData['namaSantri'] . '%');
            })
            ->when($filterData != null && isset($filterData['tahunPsb']), function ($q) use ($filterData) {
                return $q->where('tahun_psb', $filterData['tahunPsb']);
            })
            ->when($filterData != null && isset($filterData['program']), function ($q) use ($filterData) {
                return $q->where('program_id', $filterData['program']);
            })
            ->when($filterData != null && isset($filterData['jk']), function ($q) use ($filterData) {
                return $q->where('jk', $filterData['jk']);
            })
            ->when($filterData != null && isset($filterData['status']), function ($q) use ($filterData) {
                return $q->where('status_transfer', $filterData['status']);
            })
            ->where('tahun_psb', $tahunPsb);
    }

    public static function queryDataSantri($id)
    {
        return Santri::with([
            'program'
        ])
            ->where('id', $id)
            ->first();
    }

    //Ambil data lengkap pendaftar
    public static function detailPendaftar($kodeRegistrasi)
    {
        return Santri::with([
            'program',
            'pekerjaan'
        ])
            ->where('kode_registrasi', $kodeRegistrasi)
            ->firstOrFail();
    }

}
