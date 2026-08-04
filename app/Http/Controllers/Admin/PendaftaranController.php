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
}
