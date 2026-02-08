<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\Guest\InfoPsbController;
use App\Http\Controllers\Guest\ProgramController;
use App\Http\Controllers\Santri\DaftarController;
use App\Http\Controllers\Santri\CariNamaController;
use App\Http\Controllers\Guest\LandingPageController;

Auth::routes();
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', [LandingPageController::class, 'index']);
Route::get('/profil-takhassus-al-barkah', [LandingPageController::class, 'profilTakhassus']);
Route::get('/panduan-santri', [LandingPageController::class, 'panduanSantri']);
Route::get('/pengajar', [LandingPageController::class, 'pengajar']);
Route::get('/program-tajwid-quran', [ProgramController::class, 'tajwidQuran']);
Route::get('/program-bahasa-arab', [ProgramController::class, 'bahasaArab']);
Route::get('/program-takmili', [ProgramController::class, 'takmili']);
Route::get('/program-ulum-syariah', [ProgramController::class, 'ulumSyariah']);
Route::get('/psb', [InfoPsbController::class, 'index']);
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

require __DIR__ . '/admin.php';

