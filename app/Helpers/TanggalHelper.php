<?php

namespace App\Helpers;

use Carbon\Carbon;

class TanggalHelper
{
    public static function konversiTanggal($tanggal)
    {
        return Carbon::parse($tanggal)
            ->isoFormat('D MMM Y');
    }

    public static function konversiJam($tanggal)
    {
        return Carbon::parse($tanggal)
        ->isoFormat('hh:mm');
    }

    public static function konversiTanggalPenuh($tanggal)
    {
        return Carbon::parse($tanggal)
            ->isoFormat('dddd, D MMMM Y');
    }

    public static function hariTanggalWaktu($tanggal)
    {
        return Carbon::parse($tanggal)->isoFormat('LLLL');
    }
}
