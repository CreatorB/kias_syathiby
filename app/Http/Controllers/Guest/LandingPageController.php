<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\InfoPsb;
use App\Models\Lembaga;
use App\Models\Pengajar;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Pusat Belajar Tajwid, Bahasa Arab dan Ilmu Syari',
            'lembaga' => Lembaga::find(1),
            'psb' => InfoPsb::find(1),
            'pengajar' => Pengajar::orderBy('id', 'asc')->limit(5)->get(),
        ];

        return view('guest.landing_page', $data);
    }

    public function profilTakhassus() {
        $data = [
            'title' => 'Profil Takhassus Al Barkah',
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
