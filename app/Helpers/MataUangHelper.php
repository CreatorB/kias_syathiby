<?php

namespace App\Helpers;

use Carbon\Carbon;

class MataUangHelper
{
    public static function rupiah($angka)
    {
        $rupiah = 'Rp '.number_format($angka, 0, ',', '.');
        return $rupiah;
    }
}
