<?php

use App\Http\Controllers\Admin\DashboardAdminController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\UserController;
use App\Livewire\Admin\DashboardAdmin;
use App\Livewire\Admin\Pendaftaran\DataSantri;
use App\Livewire\Admin\Pendaftaran\PengaturanPsb;
use App\Livewire\Admin\Pendaftaran\DetailPendaftar;
use App\Livewire\Admin\Pendaftaran\VerifikasiTransfer;
use App\Livewire\Admin\Events\EventList;
use App\Livewire\Admin\Events\EventForm;
use App\Livewire\Admin\Events\EventParticipants;
use App\Livewire\Admin\Events\EventAttendance;
use App\Livewire\Admin\Settings\PermissionManager;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::group(["middleware" => ["auth", "admin"], "as" => "admin::"], function () {
    Route::prefix("admin")->group(function () {
        Route::get("/dashboard", DashboardAdmin::class)->name("dashboard");
        Route::get("/pendaftaran", [PendaftaranController::class, "index"])->name("pendaftaran.index");
        Route::get("/pendaftaran/{kode}", [PendaftaranController::class, "show"])->name("pendaftaran.show");
        Route::post("/pendaftaran/{kode}/approve", [PendaftaranController::class, "approve"])->name("pendaftaran.approve");
        Route::post("/pendaftaran/{kode}/reject", [PendaftaranController::class, "reject"])->name("pendaftaran.reject");
        Route::delete("/pendaftaran/{kode}", [PendaftaranController::class, "destroy"])->name("pendaftaran.destroy");
        Route::get("/verifikasi-transfer", VerifikasiTransfer::class)->name("verifikasi_transfer");
        Route::get("/detail-pendaftar/{kodeRegistrasi}", DetailPendaftar::class)->name("detail_pendaftar");
        Route::get("/data-santri", DataSantri::class)->name("data_santri");
        Route::get("/pengaturan-psb", PengaturanPsb::class)->name("pengaturan_psb");

        // User Management
        Route::get("/users", \App\Livewire\Admin\User\UserManagement::class)->name("users.index");

        // User Ban/Unban
        Route::get("/users/{id}/toggle-ban", function ($id) {
            $user = User::findOrFail($id);
            $user->toggleBan();
            return redirect()->back()->with('success', $user->isBanned() ? 'User berhasil diblokir.' : 'User berhasil di-unblokir.');
        })->name("users.toggle_ban");

        // Events Management
        Route::prefix("events")->group(function () {
            Route::get("/", EventList::class)->name("events.index");
            Route::get("/create", EventForm::class)->name("events.create");
            Route::get("/{id}/edit", EventForm::class)->name("events.edit");
            Route::get("/{id}/participants", EventParticipants::class)->name("events.participants");
            Route::get("/{id}/attendance", EventAttendance::class)->name("events.attendance");
            Route::get("/{id}/attendance/export-csv", [\App\Http\Controllers\Admin\EventAttendanceController::class, "exportCsv"])->name("events.attendance.export_csv");
            Route::get("/{id}/attendance/export-excel", [\App\Http\Controllers\Admin\EventAttendanceController::class, "exportExcel"])->name("events.attendance.export_excel");
            Route::get("/{id}/attendance/print", [\App\Http\Controllers\Admin\EventAttendanceController::class, "print"])->name("events.attendance.print");
        });

        // Superadmin Only - Settings
        Route::middleware("superadmin")->prefix("settings")->group(function () {
            Route::get("/permissions", PermissionManager::class)->name("settings.permissions");
        });

        // Maintenance Routes (Password Protected via middleware)
        Route::middleware(["maintenance"])->prefix("maintenance")->name("maintenance.")->group(function () {
            Route::get("/migrate", [MaintenanceController::class, "migrate"])->name("migrate");
            Route::get("/migrate-refresh", [MaintenanceController::class, "migrateRefresh"])->name("migrateRefresh");
            Route::get("/optimize", [MaintenanceController::class, "optimize"])->name("optimize");
            Route::get("/queue-restart", [MaintenanceController::class, "queueRestart"])->name("queueRestart");
            Route::get("/db-backup", [MaintenanceController::class, "dbBackup"])->name("dbBackup");
        });

        // Maintenance Routes (No Password - Low Risk)
        Route::prefix("maintenance")->name("maintenance.")->group(function () {
            Route::get("/clear-all", [MaintenanceController::class, "clearAll"])->name("clearAll");
            Route::get("/clear-cache", [MaintenanceController::class, "clearCache"])->name("clearCache");
            Route::get("/clear-view", [MaintenanceController::class, "clearView"])->name("clearView");
            Route::get("/clear-route", [MaintenanceController::class, "clearRoute"])->name("clearRoute");
            Route::get("/clear-config", [MaintenanceController::class, "clearConfig"])->name("clearConfig");
            Route::get("/info", [MaintenanceController::class, "info"])->name("info");
        });
    });
});
