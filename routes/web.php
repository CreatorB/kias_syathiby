<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Guest\InfoPsbController;
use App\Http\Controllers\Guest\ProgramController;
use App\Http\Controllers\Santri\DaftarController;
use App\Http\Controllers\Santri\CariNamaController;
use App\Http\Controllers\Santri\DashboardController;
use App\Http\Controllers\Guest\LandingPageController;
use App\Http\Controllers\Guest\EventController;
use App\Livewire\Peserta\EventHistory;
use App\Livewire\Peserta\Dashboard;
use App\Livewire\User\Pengaturan;

Auth::routes();
Route::get('/logout', [LogoutController::class, 'logout'])->name('custom.logout');

// Cache management routes (production helper)
Route::get('/optimize', function () {
    Artisan::call('optimize:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:cache');
    return 'Optimized! Cache cleared and recached.';
});
Route::get('/clear', function () {
    Artisan::call('optimize:clear');
    return 'Cache cleared!';
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [LandingPageController::class, 'index']);
Route::get('/profil-kias', [LandingPageController::class, 'profilKias']);
Route::get('/panduan-santri', [LandingPageController::class, 'panduanSantri']);
Route::get('/pengajar', [LandingPageController::class, 'pengajar']);
Route::get('/program-tajwid-quran', [ProgramController::class, 'tajwidQuran']);
Route::get('/program-bahasa-arab', [ProgramController::class, 'bahasaArab']);
Route::get('/program-takmili', [ProgramController::class, 'takmili']);
Route::get('/program-ulum-syariah', [ProgramController::class, 'ulumSyariah']);
Route::get('/psb', [InfoPsbController::class, 'index']);
Route::post('/psb/register', [InfoPsbController::class, 'register'])->name('psb.register');
Route::get('/download-brosur', [InfoPsbController::class, 'download']);

Route::get('/pilih-program', [DaftarController::class, 'pilihProgram']);
Route::get('/isi-form/{id}', [DaftarController::class, 'create'])->name('isiForm.create');
Route::get('isi-form-error', [DaftarController::class, 'errorDaftar'])->name('isiFormError');
Route::post('/isi-form/store', [DaftarController::class, 'store']);
Route::get('/sukses-daftar', [DaftarController::class, 'suksesDaftar'])->name('suksesDaftarSantri');

Route::get('/cari-nama', [CariNamaController::class, 'search']);
Route::get('/detail-nama', [CariNamaController::class, 'detail'])->name('detailNamaSantri');
Route::get('/edit-biodata/{kode}', [CariNamaController::class, 'edit']);
Route::post('/edit-biodata/update', [CariNamaController::class, 'update']);

// Event Routes (Public)
Route::redirect('/event', '/events'); // Redirect typo
Route::get('/events', [EventController::class, 'index'])->name('events.index');
Route::get('/events/{slug}', [EventController::class, 'show'])->name('events.show');
Route::post('/events/{slug}/register', [EventController::class, 'register'])->name('events.register');
Route::get('/events/{slug}/success', [EventController::class, 'success'])->name('events.success');

// Internal Event Routes
Route::get('/events/internal/{slug}/{token}', [\App\Http\Controllers\Guest\InternalEventController::class, 'show'])->name('events.internal.show');
Route::post('/events/internal/{slug}/{token}/register', [\App\Http\Controllers\Guest\InternalEventController::class, 'store'])->name('events.internal.store');

// User Routes (All Authenticated Users)
Route::group(['middleware' => ['auth']], function () {
    Route::get('/pengaturan', Pengaturan::class)->name('pengaturan');
});

// User Dashboard Routes (Peserta/Santri)
Route::group(['middleware' => ['auth'], 'prefix' => 'peserta/dashboard', 'as' => 'peserta::'], function () {
    Route::get('/', \App\Livewire\Peserta\Dashboard::class)->name('index');
    Route::get('/events', \App\Livewire\Peserta\EventHistory::class)->name('events');
    Route::get('/formulir/{kode}', [DashboardController::class, 'formulir'])->name('formulir');
    Route::get('/notification/{id}/read', [DashboardController::class, 'markNotificationAsRead'])->name('notification.read');
    Route::get('/notification/read-all', [DashboardController::class, 'markAllNotificationsAsRead'])->name('notification.readAll');
});




require __DIR__ . '/admin.php';

