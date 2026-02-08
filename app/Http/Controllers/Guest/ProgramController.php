<?php

namespace App\Http\Controllers\Guest;

use App\Models\Kitab;
use App\Models\Lembaga;
use App\Models\Program;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function tajwidQuran() {
        $data = [
            'title' => 'Program Tajwid Al-Qur\'an',
            'lembaga' => Lembaga::find(1),
            'program' => Program::where('jenis_program_id', 1)->orderBy('id', 'asc')->get(),
            'kitab' => Kitab::where('jenis_program_id', 1)->orderBy('id', 'asc')->get(),
        ];

        return view('guest.program_tajwid_quran', $data);
    }

    public function bahasaArab() {
        $data = [
            'title' => 'Program Bahasa Arab',
            'lembaga' => Lembaga::find(1),
            'program' => Program::where('jenis_program_id', 2)->orderBy('id', 'asc')->get(),
            'kitab' => Kitab::where('jenis_program_id', 2)
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('kelas'),
        ];

        return view('guest.program_bahasa_arab', $data);
    }

    public function takmili() {
        $data = [
            'title' => 'Program Takmili',
            'lembaga' => Lembaga::find(1),
            'program' => Program::where('jenis_program_id', 4)->orderBy('id', 'asc')->get(),
            'kitab' => Kitab::where('jenis_program_id', 4)->orderBy('id', 'asc')->get(),
        ];

        return view('guest.program_takmili', $data);
    }

    public function ulumSyariah() {
        $data = [
            'title' => 'Program Ulum Asy-Syari\'ah',
            'lembaga' => Lembaga::find(1),
            'program' => Program::where('jenis_program_id', 3)->orderBy('id', 'asc')->get(),
            'kitab' => Kitab::where('jenis_program_id', 3)
            ->orderBy('id', 'asc')
            ->get()
            ->groupBy('kelas'),
        ];

        return view('guest.program_ulum_syariah', $data);
    }
}
