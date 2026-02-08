<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\Santri;
use App\Models\InfoPsb;
use Livewire\Component;
use Detection\MobileDetect;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Services\SantriService;
use App\Services\InfoPsbService;
use App\Providers\StatusProvider;
use Livewire\Attributes\Computed;
use Livewire\WithoutUrlPagination;

class VerifikasiTransfer extends Component
{
    use WithPagination;
    use WithoutUrlPagination;
    //String
    public $tahunPsb, $cariSantri = null, $wa, $nama, $program, $url = null;
    //Integer
    public $limitData = 10, $idPendaftar, $tambahData = 10;
    //Collection
    public $filterData = null, $infoPsb, $psb;
    //Boolean
    public $isMobile;

    protected SantriService $santriService;

    #[Title('Verifikasi Transfer Pendaftaran')]

    #[Computed]
    public function dataPendaftar() {
        return $this->santriService->paginateVerifikasiTransfer($this->tahunPsb, $this->limitData, $this->filterData);
    }

    #[Computed]
    public function jmlPendaftar() {
        return Santri::queryPendaftaran($this->tahunPsb)->count();
    }

    #[Computed]
    public function jmlValid() {
        return $this->santriService->totalTransferValid($this->tahunPsb);
    }

    #[Computed]
    public function jmlCek() {
        return $this->santriService->verifikasiTransfer($this->tahunPsb);
    }

    #[Computed]
    public function jmlInvalid() {
        return $this->santriService->totalTransferInvalid($this->tahunPsb);
    }

    #[On('simpan-status')]
    public function fetchDataPendaftar() {
        $this->dataPendaftar();
    }

    #[On('load-data')]
    public function loadMore($addData) {
        $this->limitData += $addData;
    }

    public function boot(SantriService $santriService, MobileDetect $mobileDetect) {
        $this->santriService = $santriService;
        if ($mobileDetect->isMobile()) {
            $this->isMobile = true;
        } else {
            $this->isMobile = false;
        }
    }

    public function mount(InfoPsbService $infoPsbService) {
        $this->tahunPsb = $infoPsbService->tahunPsb();
        $this->infoPsb = InfoPsb::orderBy('id', 'desc')->limit(3)->get();
    }

    //Set value untuk filter
    public function ambilFilterData() {
        $this->filterData = collect([
            'namaSantri' => $this->cariSantri,
            'tahunPsb' => $this->tahunPsb
        ]);
    }

    public function updated($property) {
        if ($property == 'cariSantri') {
            $this->resetPage();
            $this->ambilFilterData();
        }
    }

    //Ubah filter tahun ajaran PSB
    public function pilihPsb($id) {
        $this->psb = InfoPsb::find($id);
        $this->tahunPsb = $this->psb->tahun_ajaran;
        $this->ambilFilterData();
    }

    //Set id untuk modal detail verifikasi transfer
    public function setIdPendaftar($id)
    {
        $this->idPendaftar = $id;
    }

    //Action kirim notifikasi
    public function kirimNotifikasi($id)
    {
        //Update status notifikasi
        Santri::where('id', $id)
        ->update([
            'kirim_notifikasi' => 1
        ]);

        $santri = Santri::queryDataSantri($id);
        $wa = $santri->hp;
        $nama = $santri->nama;
        $program = $santri->program->nama_program;
        $statusTransfer = $santri->status_transfer;

        if ($statusTransfer == StatusProvider::TRANSFER_VALID) {
            $this->url = "https://api.whatsapp.com/send?phone=".$wa."&text=*_KONFIRMASI PENDAFTARAN_*%0A%0ASelamat! Pendaftaran dengan data berikut:%0A%0ANama Lengkap: *".$nama."*%0AProgram: *".$program."*%0AStatus Transfer: *".$statusTransfer."*%0A%0Atelah berhasil. Selanjutnya silahkan tunggu proses pelaksanaan tes masuk, kami akan menghubungi anda kembali.%0ATerima kasih, jazakumullahu khoiron.%0A%0A_Panitia PSB_%0A_Lembaga Pendidikan Takhassus Al Barkah_";
        } else {
            $this->url = "https://api.whatsapp.com/send?phone=".$wa."&text=*_KONFIRMASI PENDAFTARAN_*%0A%0AMohon maaf! Pendaftaran dengan data berikut:%0A%0ANama Lengkap: *".$nama."*%0AProgram: *".$program."*%0A%0Abelum dapat kami terima dengan alasan *Bukti Transfer Tidak Valid*. Mohon untuk mengirimkan ulang lampiran bukti transfer melalui WhatsApp ini.%0ATerima kasih, jazakumullahu khoiron.%0A%0A_Panitia PSB_%0A_Lembaga Pendidikan Takhassus Al Barkah_";
        }

        $this->dispatch('kirim-notifikasi', url: $this->url);
    }

    public function render()
    {
        if ($this->isMobile) {
            return view('livewire.mobile.admin.pendaftaran.verifikasi-transfer', [
                'url' => $this->url
            ])->layout('layouts.app');
        } else {
            return view('livewire.admin.pendaftaran.verifikasi-transfer', [
                'url' => $this->url
            ])->layout('layouts.app');
        }
    }
}
