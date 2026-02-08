<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class StatusProvider extends ServiceProvider {

    public const TRANSFER_VALID = 'Valid';
    public const TRANSFER_INVALID = 'Invalid';
    public const TRANSFER_PROSES = 'Cek';
}
