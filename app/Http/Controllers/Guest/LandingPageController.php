<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\InfoPsb;
use App\Models\Lembaga;
use App\Models\Pengajar;
use App\Models\TeknisDaftar;
use App\Models\TesMasuk;
use App\Services\InfoPsbService;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index(InfoPsbService $infoPsbService) {
        $data = [
            'title' => 'Home',
            'lembaga' => Lembaga::find(1),
            'psb' => $infoPsbService->psbAktif(),
            'pengajar' => Pengajar::orderBy('id', 'asc')->limit(5)->get(),
            'teknisDaftar' => TeknisDaftar::find(1),
            'tesMasuk' => TesMasuk::where('cabang_id', 1)->first(),
        ];

        return view('guest.landing_page', $data);
    }

    public function profilKias() {
        $data = [
            'title' => 'Profil KIAS',
            'lembaga' => Lembaga::find(1),
        ];

        return view('guest.profil_takhassus', $data);
    }

    public function panduanSantri() {
        $data = [
            'title' => 'Panduan Santri',
            'lembaga' => Lembaga::find(1),
        ];

        return view('guest.panduan_santri', $data);
    }

    public function pengajar() {
        $data = [
            'title' => 'Pengajar',
            'lembaga' => Lembaga::find(1),
            'pengajar_tajwid' => Pengajar::where('jenis_program_id', 1)->get(),
            'pengajar_bahasa' => Pengajar::where('jenis_program_id', 2)->get(),
            'pengajar_takmili' => Pengajar::where('jenis_program_id', 4)->get(),
            'pengajar_syariah' => Pengajar::where('jenis_program_id', 3)->get(),
        ];

        return view('guest.pengajar', $data);
    }
}
