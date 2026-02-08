<?php

namespace App\Services;

use App\Models\InfoPsb;
use Illuminate\Support\Facades\DB;

class InfoPsbService {

    public function tahunPsb() {
        //Cek apakah ada PSB yang buka
        $cekBuka = InfoPsb::where('status_psb', 'Buka')->count();
        if ($cekBuka == 0) {
            $query = InfoPsb::orderBy('id', 'desc')->limit(1)->first();
        } else {
            $query = InfoPsb::where('status_psb', 'Buka')->first();
        }

        $tahunPsb = $query->tahun_ajaran;

        return $tahunPsb;
    }

    public function psbAktif() {
        $cekBuka = InfoPsb::where('status_psb', 'Buka')->count();
        if ($cekBuka == 0) {
            $query = InfoPsb::orderBy('id', 'desc')->limit(1)->first();
        } else {
            $query = InfoPsb::where('status_psb', 'Buka')->first();
        }

        return $query;
    }
}
