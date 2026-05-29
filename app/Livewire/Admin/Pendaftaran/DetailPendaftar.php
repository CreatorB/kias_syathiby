<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\Santri;
use App\Models\User;
use App\Providers\StatusProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\Attributes\Title;

class DetailPendaftar extends Component
{
    public $kodeRegistrasi;
    public $dataPendaftar;
    public $alasan = "";

    #[Title("Detail Data Pendaftaran")]

    public function mount($kodeRegistrasi)
    {
        $this->kodeRegistrasi = $kodeRegistrasi;
        $this->loadPendaftar();
    }

    private function loadPendaftar()
    {
        $this->dataPendaftar = Santri::detailPendaftar($this->kodeRegistrasi);
    }

    public function approve()
    {
        $santri = Santri::where("kode_registrasi", $this->kodeRegistrasi)->firstOrFail();

        DB::transaction(function () use ($santri) {
            $santri->update([
                "status_pendaftaran" => Santri::STATUS_DITERIMA,
                "tgl_verifikasi" => now(),
                "status_transfer" => StatusProvider::TRANSFER_VALID,
            ]);

            $user = User::where("santri_id", $santri->id)->first();
            if ($user) {
                $user->update(["is_active" => true]);
            }

            Notification::create([
                "user_id" => $user?->id ?? $santri->user_id,
                "santri_id" => $santri->id,
                "type" => "diterima",
                "title" => "Pendaftaran Diterima",
                "message" => "Selamat! Pendaftaran Anda telah diterima. Silakan tunggu informasi selanjutnya mengenai tes masuk.",
            ]);
        });

        $this->loadPendaftar();
        Session::flash("success", "Pendaftaran berhasil diterima!");
    }

    public function reject()
    {
        $this->validate([
            "alasan" => "required|max:500",
        ], [], ["alasan" => "Alasan Penolakan"]);

        $santri = Santri::where("kode_registrasi", $this->kodeRegistrasi)->firstOrFail();

        DB::transaction(function () use ($santri) {
            $santri->update([
                "status_pendaftaran" => Santri::STATUS_DITOLAK,
                "alasan_penolakan" => $this->alasan,
            ]);

            $user = User::where("santri_id", $santri->id)->first();

            Notification::create([
                "user_id" => $user?->id ?? $santri->user_id,
                "santri_id" => $santri->id,
                "type" => "ditolak",
                "title" => "Pendaftaran Ditolak",
                "message" => "Maaf, pendaftaran Anda ditolak. Alasan: " . $this->alasan,
            ]);
        });

        $this->alasan = "";
        $this->loadPendaftar();
        Session::flash("success", "Pendaftaran berhasil ditolak!");
    }

    public function render()
    {
        return view("livewire.admin.pendaftaran.detail-pendaftar")->layout("layouts.app");
    }
}
