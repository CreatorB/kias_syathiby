<?php

namespace App\Http\Controllers\Santri;

use App\Models\Lembaga;
use App\Models\Santri;
use App\Providers\StatusProvider;
use App\Services\InfoPsbService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RevisiBerkasController extends Controller
{
    public function __construct(private InfoPsbService $infoPsbService)
    {}

    public function show($kode)
    {
        $tahunPsb = $this->infoPsbService->tahunPsb();

        $santri = Santri::where('kode_registrasi', $kode)
            ->where('tahun_psb', $tahunPsb)
            ->first();

        if (!$santri) {
            return redirect('/cari-nama')->with('error', 'Data tidak ditemukan.');
        }

        $data = [
            'title' => 'Revisi Berkas',
            'lembaga' => Lembaga::find(1),
            'santri' => $santri,
            'tahunPsb' => $tahunPsb,
            'linkGroup' => $this->infoPsbService->psbAktif()?->link_group,
        ];

        return view('santri.revisi_berkas', $data);
    }

    public function update(Request $request, $kode)
    {
        $tahunPsb = $this->infoPsbService->tahunPsb();

        $santri = Santri::where('kode_registrasi', $kode)
            ->where('tahun_psb', $tahunPsb)
            ->first();

        if (!$santri) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Data tidak ditemukan.'], 404);
            }
            return redirect('/cari-nama')->with('error', 'Data tidak ditemukan.');
        }

        $validated = $request->validate([
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            'ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'ijazah' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'bukti_pembayaran' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ], [
            'foto.mimes' => 'Foto harus format JPG, JPEG, atau PNG',
            'ktp.mimes' => 'KTP harus format JPG, JPEG, PNG, atau PDF',
            'ijazah.mimes' => 'Ijazah harus format JPG, JPEG, PNG, atau PDF',
            'bukti_pembayaran.mimes' => 'Bukti pembayaran harus format JPG, JPEG, atau PNG',
        ]);

        $registrasiDir = public_path("berkas/{$tahunPsb}/{$kode}");
        if (!file_exists($registrasiDir)) {
            mkdir($registrasiDir, 0755, true);
        }

        $updateData = [];

        if ($request->hasFile('foto')) {
            $fotoFile = $request->file('foto');
            $fotoName = 'foto.' . $fotoFile->getClientOriginalExtension();
            $fotoFile->move($registrasiDir, $fotoName);
            $updateData['photo'] = $fotoName;
        }

        if ($request->hasFile('ktp')) {
            $ktpFile = $request->file('ktp');
            $ktpName = 'ktp.' . $ktpFile->getClientOriginalExtension();
            $ktpFile->move($registrasiDir, $ktpName);
            $updateData['ktp'] = $ktpName;
        }

        if ($request->hasFile('ijazah')) {
            $ijazahFile = $request->file('ijazah');
            $ijazahName = 'ijazah.' . $ijazahFile->getClientOriginalExtension();
            $ijazahFile->move($registrasiDir, $ijazahName);
            $updateData['ijazah'] = $ijazahName;
        }

        if ($request->hasFile('bukti_pembayaran')) {
            $buktiFile = $request->file('bukti_pembayaran');
            $buktiName = 'bukti_bayar.' . $buktiFile->getClientOriginalExtension();
            $buktiFile->move($registrasiDir, $buktiName);
            $updateData['transfer'] = $buktiName;
            $updateData['status_transfer'] = StatusProvider::TRANSFER_PROSES;
        }

        if (!empty($updateData)) {
            $santri->update($updateData);
        }

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Berkas berhasil diperbarui! Silakan tunggu verifikasi dari admin.',
            ]);
        }

        return redirect()->back()->with('success', 'Berkas berhasil diperbarui! Silakan tunggu verifikasi dari admin.');
    }
}