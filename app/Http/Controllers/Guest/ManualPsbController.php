<?php

namespace App\Http\Controllers\Guest;

use App\Models\InfoPsb;
use App\Models\Lembaga;
use App\Models\Notification;
use App\Models\Pekerjaan;
use App\Models\Program;
use App\Models\Santri;
use App\Models\User;
use App\Providers\StatusProvider;
use App\Services\DaftarService;
use App\Services\InfoPsbService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TeknisDaftar;
use App\Models\TesMasuk;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ManualPsbController extends Controller
{
    public function index(InfoPsbService $infoPsbService)
    {
        $psb = $infoPsbService->psbAktif();

        if (!$psb) {
            return redirect()->route('home')->with('error', 'Pendaftaran PSB belum tersedia.');
        }

        if (empty($psb->manual_password)) {
            return redirect()->route('home')->with('error', 'Pendaftaran manual sedang tidak aktif.');
        }

        $passwordVerified = Session::get('psb_manual_verified', false);
        $verifiedAt = Session::get('psb_manual_verified_at', 0);
        $timeout = 10 * 60; // 10 minutes in seconds

        if (!$passwordVerified || (now()->timestamp - $verifiedAt) >= $timeout) {
            return redirect()->route('psb_manual.password');
        }

        $programs = Program::whereIn('jenis_program_id', [1, 2, 4])
            ->where('status_psb', 'Buka')
            ->get();

        $data = [
            'title' => 'Pendaftaran Manual',
            'lembaga' => Lembaga::find(1),
            'psb' => $psb,
            'requires_password' => false,
            'programs' => $programs,
            'tajwid' => Program::where('jenis_program_id', 1)->where('status_psb', 'Buka')->get(),
            'bahasaArab' => Program::where('jenis_program_id', 2)->where('status_psb', 'Buka')->get(),
            'takmili' => Program::where('jenis_program_id', 4)->where('status_psb', 'Buka')->get(),
            'teknisDaftar' => TeknisDaftar::find(1),
            'tesMasuk' => TesMasuk::with('cabang')->get()->groupBy('cabang_id'),
            'pekerjaan' => Pekerjaan::orderBy('nama_pekerjaan')->get(),
            'quota_ikhwan' => $psb?->registered_ikhwan_count,
            'quota_akhwat' => $psb?->registered_akhwat_count,
            'quota_ikhwan_remaining' => $psb?->remaining_quota_ikhwan,
            'quota_akhwat_remaining' => $psb?->remaining_quota_akhwat,
            'quota_max_ikhwan' => $psb?->quota_ikhwan,
            'quota_max_akhwat' => $psb?->quota_akhwat,
            'psb_is_open' => true,
            'psb_datetime_open' => $psb?->datetime_open,
            'psb_datetime_closed' => $psb?->datetime_closed,
        ];

        return view('guest.info_psb_manual', $data);
    }

    public function verifyPassword(Request $request)
    {
        $psb = (new InfoPsbService())->psbAktif();

        if (!$psb || empty($psb->manual_password)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Pendaftaran manual tidak aktif.'], 403);
            }
            return redirect()->route('psb_manual.password')->with('error', 'Pendaftaran manual tidak aktif.');
        }

        $password = $request->input('password', '');

        if (!Hash::check($password, $psb->manual_password)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Password salah.'], 401);
            }
            return redirect()->route('psb_manual.password')->with('error', 'Password salah.');
        }

        Session::put('psb_manual_verified', true);
        Session::put('psb_manual_verified_at', now()->timestamp);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true, 'message' => 'Password benar.']);
        }

        return redirect()->route('psb_manual.index');
    }

    public function showPasswordForm()
    {
        $psb = (new InfoPsbService())->psbAktif();
        return view('guest.psb_manual_password', [
            'title' => 'Password - Pendaftaran Manual',
            'lembaga' => Lembaga::find(1),
        ]);
    }

    public function register(Request $request, DaftarService $daftarService)
    {
        $psb = (new InfoPsbService())->psbAktif();

        if (!$psb) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Pendaftaran sedang ditutup.'], 400);
            }
            return redirect()->back()->with('error', 'Pendaftaran sedang ditutup.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|min:3',
            'jenis_kelamin' => 'required|in:L,P',
            'nik' => 'required|string|size:16',
            'nisn' => 'required|string|size:10',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date|before:today',
            'alamat' => 'required|string|min:10',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable|string',
            'nama_ayah' => 'nullable',
            'nama_ibu' => 'nullable',
            'nama_wali' => 'nullable',
            'no_hp_ayah' => 'nullable',
            'no_hp_ibu' => 'nullable',
            'no_hp_wali' => 'nullable',
            'program_id' => 'required|exists:program,id',
            'ktp' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'foto' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'bukti_pembayaran' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'agreement' => 'required|accepted',
        ], [
            'nama.required' => 'Nama lengkap harus diisi',
            'nik.size' => 'NIK harus 16 digit',
            'nisn.size' => 'NISN harus 10 digit',
            'tanggal_lahir.before' => 'Tanggal lahir harus sebelum hari ini',
            'alamat.min' => 'Alamat minimal 10 karakter',
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain',
            'agreement.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        $errors = [];
        if (!$request->nama_ayah && !$request->nama_ibu && !$request->nama_wali) {
            $errors['nama_ayah'] = 'Minimal salah satu data orang tua/wali harus diisi.';
        }
        if ($request->nama_wali && !$request->no_hp_wali) {
            $errors['no_hp_wali'] = 'No. HP Wali harus diisi karena Nama Wali sudah terisi.';
        }
        if ($request->nama_ayah && !$request->no_hp_ayah) {
            $errors['no_hp_ayah'] = 'No. HP Ayah harus diisi karena Nama Ayah sudah terisi.';
        }
        if ($request->nama_ibu && !$request->no_hp_ibu) {
            $errors['no_hp_ibu'] = 'No. HP Ibu harus diisi karena Nama Ibu sudah terisi.';
        }
        if (!empty($errors)) {
            return redirect()->back()->withErrors($errors)->withInput();
        }

        $jk = $request->jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan';

        $kodeRegistrasi = $daftarService->kodeRegistrasi($psb->tahun_ajaran);

        try {
            DB::beginTransaction();

            $tahunPsb = $psb->tahun_ajaran;
            $registrasiDir = public_path("berkas/{$tahunPsb}/{$kodeRegistrasi}");
            if (!file_exists($registrasiDir)) {
                mkdir($registrasiDir, 0755, true);
            }

            $ktpFile = $request->file('ktp');
            $fotoFile = $request->file('foto');
            $buktiFile = $request->file('bukti_pembayaran');

            $ktpName = 'ktp.' . $ktpFile->getClientOriginalExtension();
            $fotoName = 'foto.' . $fotoFile->getClientOriginalExtension();
            $buktiName = 'bukti_bayar.' . $buktiFile->getClientOriginalExtension();

            $ktpFile->move($registrasiDir, $ktpName);
            $fotoFile->move($registrasiDir, $fotoName);
            $buktiFile->move($registrasiDir, $buktiName);

            $santri = Santri::create([
                'kode_registrasi' => $kodeRegistrasi,
                'nama' => $request->nama,
                'jk' => $jk,
                'nik' => $request->nik,
                'nisn' => $request->nisn,
                'tmp_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tanggal_lahir,
                'alamat' => $request->alamat,
                'nama_ayah' => $request->nama_ayah,
                'no_hp_ayah' => $request->no_hp_ayah,
                'nama_ibu' => $request->nama_ibu,
                'no_hp_ibu' => $request->no_hp_ibu,
                'nama_wali' => $request->nama_wali,
                'no_hp_wali' => $request->no_hp_wali,
                'email' => $request->email,
                'kode_negara' => $request->kode_negara ?? '62',
                'no_hp' => $request->no_hp ?? '',
                'hp' => ($request->kode_negara ?? '62') . ltrim($request->no_hp ?? '', '0'),
                'tahun_psb' => $tahunPsb,
                'program_id' => $request->program_id,
                'photo' => $fotoName,
                'ktp' => $ktpName,
                'transfer' => $buktiName,
                'nominal_transfer' => $psb->biaya_pendaftaran,
                'status_transfer' => StatusProvider::TRANSFER_PROSES,
                'status_pendaftaran' => Santri::STATUS_MENUNGGU,
            ]);

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($kodeRegistrasi),
                'role_id' => 3,
                'phone' => $santri->hp,
                'is_active' => false,
                'santri_id' => $santri->id,
            ]);

            Notification::create([
                'user_id' => $user->id,
                'santri_id' => $santri->id,
                'type' => 'pendaftaran',
                'title' => 'Pendaftaran Berhasil',
                'message' => 'Pendaftaran Anda telah berhasil disimpan. Nomor Peserta Anda: ' . $kodeRegistrasi . '. Silakan tunggu verifikasi dari admin.',
            ]);

            DB::commit();

            auth()->login($user);

            Session::forget(['psb_manual_verified', 'psb_manual_verified_at']);

            $successMessage = 'Pendaftaran berhasil! Nomor Peserta Anda: ' . $kodeRegistrasi . '. Silakan tunggu verifikasi pembayaran.';

            if ($request->ajax()) {
                return response()->json([
                    'success'  => true,
                    'message'  => $successMessage,
                    'kode'     => $kodeRegistrasi,
                    'redirect' => route('peserta::index'),
                ]);
            }

            return redirect()->route('peserta::index')->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollBack();

            if (isset($registrasiDir) && file_exists($registrasiDir)) {
                array_map('unlink', glob("$registrasiDir/*"));
                rmdir($registrasiDir);
            }

            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()], 500);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
}
