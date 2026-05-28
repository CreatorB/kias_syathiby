<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\InfoPsb;
use App\Models\Notification;
use App\Models\Santri;
use App\Providers\StatusProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $santri = $user->santri;

        if (!$santri) {
            $santri = Santri::where('email', $user->email)->first();
        }

        $notifications = $user->notifications()->paginate(10);
        $unreadCount = $user->notifications()->where('is_read', false)->count();

        $infoPsb = InfoPsb::where('tahun_ajaran', InfoPsb::getActiveYear())->first();
        $biayaPendaftaran = 150000;

        return view('santri.dashboard', [
            'santri' => $santri,
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'biayaPendaftaran' => $biayaPendaftaran
        ])->layout('layouts.app', ['title' => 'Dashboard Peserta']);
    }

    public function formulir($kode)
    {
        $user = Auth::user();
        $santri = Santri::with(['program', 'pekerjaan'])
            ->where('kode_registrasi', $kode)
            ->firstOrFail();

        if ($santri->status_pendaftaran !== Santri::STATUS_DITERIMA) {
            abort(403, 'Formulir F2 hanya tersedia untuk pendaftar yang telah diterima.');
        }

        $infoPsb = InfoPsb::where('tahun_ajaran', $santri->tahun_psb)->first();

        return view('santri.formulir_f2', compact('santri', 'infoPsb'));
    }

    public function markNotificationAsRead($id)
    {
        $user = Auth::user();
        $notification = Notification::where('id', $id)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $notification->markAsRead();

        return redirect()->back();
    }

    public function markAllNotificationsAsRead()
    {
        $user = Auth::user();
        $user->notifications()->where('is_read', false)->update(['is_read' => true]);

        return redirect()->back();
    }
}
