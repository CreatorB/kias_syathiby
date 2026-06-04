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

        $santri = Santri::with('program')->where('kode_registrasi', $kodeRegistrasi)->first();
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
            'kodeNegara' => KodeNegara::all(),
        ];

        return view('santri.detail_santri', $data);
    }

    public function edit($kode) {
        $santri = Santri::with('program')->where('kode_registrasi', $kode)->first();

        $data = [
            'title' => 'Edit Biodata Santri',
            'lembaga' => Lembaga::find(1),
            'santri' => $santri,
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
