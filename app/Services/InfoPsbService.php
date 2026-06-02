<?php

namespace App\Services;

use App\Models\InfoPsb;
use Illuminate\Support\Facades\DB;

class InfoPsbService {

    public function tahunPsb() {
        $psb = $this->psbAktif();
        return $psb ? $psb->tahun_ajaran : null;
    }

    public function psbAktif() {
        $now = now();

        $psb = InfoPsb::where(function($query) use ($now) {
            $query->whereNotNull('datetime_open')
                  ->whereNotNull('datetime_closed')
                  ->where('datetime_open', '<=', $now)
                  ->where('datetime_closed', '>=', $now);
        })->first();

        if (!$psb) {
            $psb = InfoPsb::where('status_psb', 'Buka')->first();
        }

        if (!$psb) {
            $psb = InfoPsb::orderBy('id', 'desc')->first();
        }

        return $psb;
    }
}
