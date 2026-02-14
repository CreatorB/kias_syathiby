<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\Pendaftaran\DataSantri;
use App\Livewire\Admin\Pendaftaran\DetailPendaftar;
use App\Livewire\Admin\Pendaftaran\VerifikasiTransfer;
use App\Livewire\Admin\Events\EventList;
use App\Livewire\Admin\Events\EventForm;
use App\Livewire\Admin\Events\EventParticipants;
use App\Livewire\Admin\Events\EventAttendance;
use App\Livewire\Admin\Settings\PermissionManager;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['auth', 'admin'], 'as' => 'admin::'], function() {
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', DashboardAdmin::class)->name('dashboard');
        Route::get('/verifikasi-transfer', VerifikasiTransfer::class)->name('verifikasi_transfer');
        Route::get('/detail-pendaftar/{kodeRegistrasi}', DetailPendaftar::class)->name('detail_pendaftar');
        Route::get('/data-santri', DataSantri::class)->name('data_santri');

        // Events Management
        Route::prefix('events')->group(function () {
            Route::get('/', EventList::class)->name('events.index');
            Route::get('/create', EventForm::class)->name('events.create');
            Route::get('/{id}/edit', EventForm::class)->name('events.edit');
            Route::get('/{id}/participants', EventParticipants::class)->name('events.participants');
            Route::get('/{id}/attendance', EventAttendance::class)->name('events.attendance');
        });

        // Superadmin Only - Settings
        Route::middleware('superadmin')->prefix('settings')->group(function () {
            Route::get('/permissions', PermissionManager::class)->name('settings.permissions');
        });
    });
});
