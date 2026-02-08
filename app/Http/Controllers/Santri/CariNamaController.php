<?php

namespace App\Http\Controllers\Santri;

use Carbon\Carbon;
use App\Models\Santri;
use App\Models\Lembaga;
use App\Models\Pekerjaan;
use App\Models\KodeNegara;
use Illuminate\Http\Request;
use App\Services\InfoPsbService;
use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Services\CariNamaService;

class CariNamaController extends Controller
{
    public function __construct(InfoPsbService $info, CariNamaService $cariNama)
    {
        $this->InfoPsbService = $info;
        $this->CariNamaService = $cariNama;
    }

    public function search() {
        $data = [
            'title' => 'Cari Nama Santri',
            'lembaga' => Lembaga::find(1),
        ];

        return view('santri.cari_nama', $data);
    }

    public function detail(Request $request) {
        $kodeRegistrasi = $request->kodeRegistrasi;

        $santri = Santri::join('program', 'santri.program_id', 'program.id')
        ->join('pekerjaan', 'santri.pekerjaan_id', 'pekerjaan.id')
        ->where('kode_registrasi', $kodeRegistrasi)
        ->select('santri.*', 'program.nama_program', 'pekerjaan.nama_pekerjaan')
        ->first();
        $tanggal = $santri->created_at;
        $tgl_parse = Carbon::parse($tanggal);
        $tanggalIndo = $tgl_parse->isoFormat('D MMMM Y');

        $data = [
            'title' => 'Detail Data Santri',
            'lembaga' => Lembaga::find(1),
            'cekSantri' => Santri::where('kode_registrasi', $kodeRegistrasi)->count(),
            'santri' => $santri,
            'tanggalIndo' => $tanggalIndo,
            'tahunPsb' => $this->InfoPsbService->tahunPsb(),
            'pekerjaan' => Pekerjaan::all(),
            'kodeNegara' => KodeNegara::all(),
        ];

        return view('santri.detail_santri', $data);
    }

    public function edit($kode) {
        $data = [
            'title' => 'Edit Biodata Santri',
            'lembaga' => Lembaga::find(1),
            'santri' => Santri::join('program', 'santri.program_id', 'program.id')
            ->join('pekerjaan', 'santri.pekerjaan_id', 'pekerjaan.id')
            ->where('kode_registrasi', $kode)
            ->select('santri.*', 'program.nama_program', 'pekerjaan.nama_pekerjaan')
            ->first(),
            'pekerjaan' => Pekerjaan::all(),
            'kodeNegara' => KodeNegara::all(),
            'program' => Program::all(),
        ];

        return view('santri.edit_biodata', $data);
    }

    public function update(Request $request) {
        $id = $request->id;
        $kodeRegistrasi = $request->kodeRegistrasi;
        $dataUpdate = $this->CariNamaService->dataUpdate($request);

        Santri::where('id', $id)->update($dataUpdate);

        return redirect()->route('detailNamaSantri',[
            'kodeRegistrasi' => $kodeRegistrasi
        ])->with('BerhasilEditBiodata', 'Sukses');
    }
}
