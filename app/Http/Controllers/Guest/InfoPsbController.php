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

class InfoPsbController extends Controller
{
    public function index(InfoPsbService $infoPsbService) {
        $psb = $infoPsbService->psbAktif();

        // Only 3 programs as per TASKS.md: Tajwidul Quran, BA Reguler, BA Takmili
        $programs = Program::whereIn('jenis_program_id', [1, 2, 4])
            ->where('status_psb', 'Buka')
            ->get();

        $data = [
            'title' => 'Informasi Penerimaan Santri Baru',
            'lembaga' => Lembaga::find(1),
            'psb' => $psb,
            'programs' => $programs,
            'tajwid' => Program::where('jenis_program_id', 1)->where('status_psb','Buka')->get(),
            'bahasaArab' => Program::where('jenis_program_id', 2)->where('status_psb','Buka')->get(),
            'takmili' => Program::where('jenis_program_id', 4)->where('status_psb','Buka')->get(),
            'teknisDaftar' => TeknisDaftar::find(1),
            'tesMasuk' => TesMasuk::with('cabang')->get()->groupBy('cabang_id'),
            'pekerjaan' => Pekerjaan::orderBy('nama_pekerjaan')->get(),
            'quota_ikhwan' => $psb?->registered_ikhwan_count,
            'quota_akhwat' => $psb?->registered_akhwat_count,
            'quota_ikhwan_remaining' => $psb?->remaining_quota_ikhwan,
            'quota_akhwat_remaining' => $psb?->remaining_quota_akhwat,
            'quota_max_ikhwan' => $psb?->quota_ikhwan,
            'quota_max_akhwat' => $psb?->quota_akhwat,
            'psb_is_open' => $psb?->isOpen(),
            'psb_datetime_open' => $psb?->datetime_open,
            'psb_datetime_closed' => $psb?->datetime_closed,
        ];

        return view('guest.info_psb', $data);
    }

    public function register(Request $request, DaftarService $daftarService) {
        $psb = (new InfoPsbService())->psbAktif();

        if (!$psb) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Pendaftaran sedang ditutup.'], 400);
            }
            return redirect()->back()->with('error', 'Pendaftaran sedang ditutup.');
        }

        $validated = $request->validate([
            'nama' => 'required|string|min:3',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'nik' => 'required|string|size:16',
            'nisn' => 'nullable|string|size:10',
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
            'pendidikan' => 'nullable|string|max:50',
            'pekerjaan' => 'nullable|string|max:100',
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

        $jk = $request->jenis_kelamin;

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
                'pendidikan' => $request->pendidikan,
                'pekerjaan' => $request->pekerjaan,
            ]);

            $user = User::create([
                'nama' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($kodeRegistrasi),
                'role_id' => 3, // Santri
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

    public function download(){
        $file = public_path('files/PSB-Reguler-Tahun-2025-2026.pdf');

        return response()->download($file);
    }
}
