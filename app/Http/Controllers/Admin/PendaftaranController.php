<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InfoPsb;
use App\Models\Santri;
use App\Models\Notification;
use App\Models\User;
use App\Providers\StatusProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PendaftaranController extends Controller
{
    public function index(Request $request)
    {
        $tahunPsb = $request->get('tahun', InfoPsb::getActiveYear());
        $status = $request->get('status');
        $program = $request->get('program');
        $jk = $request->get('jk');
        $search = $request->get('search');

        $query = Santri::with(['program', 'user'])
            ->where('tahun_psb', $tahunPsb);

        if ($status) {
            $query->where('status_pendaftaran', $status);
        }

        if ($program) {
            $query->where('program_id', $program);
        }

        if ($jk) {
            $query->where('jk', $jk);
        }

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('kode_registrasi', 'like', '%' . $search . '%');
            });
        }

        $pendaftar = $query->orderBy('created_at', 'desc')->paginate(15);
        $tahunAjaran = InfoPsb::orderBy('tahun_ajaran', 'desc')->get();
        $programs = \App\Models\Program::where('status_psb', 'Buka')->get();

        $stats = [
            'total' => Santri::where('tahun_psb', $tahunPsb)->count(),
            'menunggu' => Santri::where('tahun_psb', $tahunPsb)->where('status_pendaftaran', 'Menunggu')->count(),
            'diterima' => Santri::where('tahun_psb', $tahunPsb)->where('status_pendaftaran', 'Diterima')->count(),
            'ditolak' => Santri::where('tahun_psb', $tahunPsb)->where('status_pendaftaran', 'Ditolak')->count(),
        ];

        return view('admin.pendaftaran.index', compact(
            'pendaftar', 'tahunAjaran', 'programs', 'stats',
            'tahunPsb', 'status', 'program', 'jk', 'search'
        ));
    }

    public function show($kode)
    {
        $santri = Santri::with(['program', 'user', 'pekerjaan'])
            ->where('kode_registrasi', $kode)
            ->firstOrFail();

        return view('admin.pendaftaran.show', compact('santri'));
    }

    public function approve(Request $request, $kode)
    {
        $santri = Santri::where('kode_registrasi', $kode)->firstOrFail();

        DB::transaction(function () use ($santri) {
            $santri->update([
                'status_pendaftaran' => Santri::STATUS_DITERIMA,
                'tgl_verifikasi' => now(),
                'status_transfer' => StatusProvider::TRANSFER_VALID,
            ]);

            $user = User::where('santri_id', $santri->id)->first();
            if ($user) {
                $user->update(['is_active' => true]);
            }

            Notification::create([
                'user_id' => $user?->id ?? $santri->user_id,
                'santri_id' => $santri->id,
                'type' => 'diterima',
                'title' => 'Pendaftaran Diterima',
                'message' => 'Selamat! Pendaftaran Anda telah diterima. Silakan tunggu informasi selanjutnya mengenai tes masuk.',
            ]);
        });

        Session::flash('success', 'Pendaftaran berhasil diterima!');
        return redirect()->back();
    }

    public function reject(Request $request, $kode)
    {
        $request->validate([
            'alasan' => 'required|string|max:500',
        ]);

        $santri = Santri::where('kode_registrasi', $kode)->firstOrFail();

        DB::transaction(function () use ($santri, $request) {
            $santri->update([
                'status_pendaftaran' => Santri::STATUS_DITOLAK,
                'alasan_penolakan' => $request->alasan,
            ]);

            $user = User::where('santri_id', $santri->id)->first();

            Notification::create([
                'user_id' => $user?->id ?? $santri->user_id,
                'santri_id' => $santri->id,
                'type' => 'ditolak',
                'title' => 'Pendaftaran Ditolak',
                'message' => 'Maaf, pendaftaran Anda ditolak. Alasan: ' . $request->alasan,
            ]);
        });

        Session::flash('success', 'Pendaftaran berhasil ditolak!');
        return redirect()->back();
    }

    public function destroy(Request $request, $kode)
    {
        $santri = Santri::where('kode_registrasi', $kode)->firstOrFail();

        DB::transaction(function () use ($santri) {
            $tahunPsb = $santri->tahun_psb;
            $files = [$santri->photo, $santri->ktp, $santri->transfer];

            foreach ($files as $file) {
                if ($file) {
                    $filePath = public_path("berkas/{$tahunPsb}/{$santri->kode_registrasi}/{$file}");
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            $dirPath = public_path("berkas/{$tahunPsb}/{$santri->kode_registrasi}");
            if (is_dir($dirPath)) {
                rmdir($dirPath);
            }

            User::where('santri_id', $santri->id)
                ->whereIn('role_id', [3, 4])
                ->delete();
            Notification::where('santri_id', $santri->id)->delete();
            $santri->delete();
        });

        Session::flash('success', 'Data pendaftar berhasil dihapus!');
        return redirect()->route('admin::pendaftaran.index');
    }

    public function create(Request $request)
    {
        $tahunPsb = $request->get('tahun', InfoPsb::getActiveYear());
        $psb = InfoPsb::orderBy('id', 'desc')->first();
        $programs = \App\Models\Program::orderBy('nama_program')->get();
        $pekerjaans = \App\Models\Pekerjaan::orderBy('nama_pekerjaan')->get();

        return view('admin.pendaftaran.create', compact(
            'psb', 'programs', 'pekerjaans', 'tahunPsb'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jk' => 'required|in:Laki-Laki,Perempuan',
            'program_id' => 'required|exists:program,id',
            'no_hp' => 'required|string|max:20',
            'nik' => 'nullable|string|max:20',
            'nisn' => 'nullable|string|max:20',
            'tmp_lahir' => 'nullable|string|max:100',
            'tgl_lahir' => 'nullable|date',
            'email' => 'nullable|email|max:255',
            'alamat' => 'nullable|string',
            'nama_ayah' => 'nullable|string|max:255',
            'no_hp_ayah' => 'nullable|string|max:20',
            'nama_ibu' => 'nullable|string|max:255',
            'no_hp_ibu' => 'nullable|string|max:20',
            'nama_wali' => 'nullable|string|max:255',
            'no_hp_wali' => 'nullable|string|max:20',
            'pendidikan' => 'nullable|string|max:100',
            'pekerjaan_id' => 'nullable|exists:pekerjaan,id',
        ]);

        $psb = InfoPsb::orderBy('id', 'desc')->first();
        $tahunAjaran = $psb ? $psb->tahun_ajaran : date('Y') . '/' . (date('Y') + 1);

        $lastNumeric = (int) Santri::where('tahun_psb', $tahunAjaran)
            ->where('kode_registrasi', 'like', '%-%')
            ->orderBy('id', 'desc')
            ->value(DB::raw("CAST(SUBSTRING_INDEX(kode_registrasi, '-', -1) AS UNSIGNED)")) ?? 0;
        $nextNumber = $lastNumeric + 1;
        $shortYear = substr(explode('/', $tahunAjaran)[0] ?? date('Y'), -2);
        $kodeRegistrasi = 'KIAS-' . $tahunAjaran . '-' . str_pad($nextNumber, 4, '0', STR_PAD_LEFT);

        $kodeNegara = $request->input('kode_negara', '62');
        $noHp = ltrim($request->no_hp, '0');
        $hp = $kodeNegara . $noHp;

        $santri = Santri::create([
            'kode_registrasi' => $kodeRegistrasi,
            'nama' => $request->nama,
            'jk' => $request->jk,
            'nik' => $request->nik,
            'nisn' => $request->nisn,
            'tmp_lahir' => $request->tmp_lahir,
            'tgl_lahir' => $request->tgl_lahir,
            'alamat' => $request->alamat,
            'nama_ayah' => $request->nama_ayah,
            'no_hp_ayah' => $request->no_hp_ayah,
            'nama_ibu' => $request->nama_ibu,
            'no_hp_ibu' => $request->no_hp_ibu,
            'nama_wali' => $request->nama_wali,
            'no_hp_wali' => $request->no_hp_wali,
            'email' => $request->email,
            'hp' => $hp,
            'kode_negara' => $kodeNegara,
            'no_hp' => $request->no_hp,
            'tahun_psb' => $tahunAjaran,
            'status_pendaftaran' => Santri::STATUS_DITERIMA,
            'status_transfer' => StatusProvider::TRANSFER_VALID,
            'tgl_verifikasi' => now(),
            'program_id' => $request->program_id,
            'pendidikan' => $request->pendidikan,
            'pekerjaan_id' => $request->pekerjaan_id,
        ]);

        User::create([
            'nama' => $request->nama,
            'email' => $request->email ?: ($kodeRegistrasi . '@kias.local'),
            'password' => Hash::make($kodeRegistrasi),
            'role_id' => 3,
            'phone' => $hp,
            'is_active' => true,
            'santri_id' => $santri->id,
        ]);

        Session::flash('success', "Pendaftaran susulan berhasil dibuat. Kode Registrasi: {$kodeRegistrasi}. Password pendaftar: {$kodeRegistrasi}");
        return redirect()->route('admin::pendaftaran.show', $kodeRegistrasi);
    }
}
