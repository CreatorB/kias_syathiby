<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\Pendaftaran\DataSantri;
use App\Livewire\Admin\Pendaftaran\DetailPendaftar;
use App\Livewire\Admin\Pendaftaran\VerifikasiTransfer;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'admin'], 'as' => 'admin::'], function() {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', DashboardAdmin::class)->name('dashboard');
        Route::get('/verifikasi-transfer', VerifikasiTransfer::class)->name('verifikasi_transfer');
        Route::get('/detail-pendaftar/{kodeRegistrasi}', DetailPendaftar::class)->name('detail_pendaftar');
        Route::get('/data-santri', DataSantri::class)->name('data_santri');
    });
});
