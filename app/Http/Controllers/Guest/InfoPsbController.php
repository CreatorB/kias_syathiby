<?php

namespace App\Http\Controllers\Guest;

use App\Models\InfoPsb;
use App\Models\Lembaga;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TeknisDaftar;
use App\Models\TesMasuk;
use App\Services\InfoPsbService;

class InfoPsbController extends Controller
{
    public function index(InfoPsbService $infoPsbService) {
        $data = [
            'title' => 'Informasi Penerimaan Santri Baru',
            'lembaga' => Lembaga::find(1),
            'psb' => $infoPsbService->psbAktif(),
            'tajwid' => Program::where('jenis_program_id', 1)->where('status_psb','Buka')->get(),
            'bahasaArab' => Program::where('jenis_program_id', 2)->where('status_psb','Buka')->get(),
            'syariah' => Program::where('jenis_program_id', 3)->where('status_psb','Buka')->get(),
            'takmili' => Program::where('jenis_program_id', 4)->where('status_psb','Buka')->get(),
            'teknisDaftar' => TeknisDaftar::find(1),
            'tesMasuk' => TesMasuk::with('cabang')
            ->get()
            ->groupBy('cabang_id'),
        ];

        // dd($data);

        return view('guest.info_psb', $data);
    }

    public function download(){
        $file = public_path('files/PSB-Reguler-Tahun-2025-2026.pdf');

        return response()->download($file);
    }
}
