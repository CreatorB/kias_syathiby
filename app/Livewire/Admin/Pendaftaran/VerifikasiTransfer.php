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
    public $tahunPsb, $cariSantri = null, $wa, $nama, $program, $url = null, $idPendanfarHapus = null, $showDeleteModal = false, $filterJk = null, $filterStatus = null;
    //Integer
    public $limitData = 10, $idPendanfar, $tambahData = 10;
    //Collection
    public $filterData = null, $infoPsb, $psb, $dataPendanfarHapus = null;
    //Boolean
    public $isMobile;

    protected SantriService $santriService;

    #[Title('Verifikasi Transfer Pendaftaran')]

    #[Computed]
    public function dataPaginator() {
        $this->ambilFilterData();
        return $this->santriService->paginateVerifikasiTransfer($this->tahunPsb, $this->limitData, $this->filterData);
    }

    #[Computed]
    public function jmlPendaftar() {
        $this->ambilFilterData();
        return Santri::queryPendaftaran($this->tahunPsb, $this->filterData)->count();
    }

    #[Computed]
    public function jmlValid() {
        return $this->santriService->totalTransferByStatus($this->tahunPsb, StatusProvider::TRANSFER_VALID);
    }

    #[Computed]
    public function jmlCek() {
        return $this->santriService->totalTransferByStatus($this->tahunPsb, StatusProvider::TRANSFER_PROSES);
    }

    #[Computed]
    public function jmlInvalid() {
        return $this->santriService->totalTransferByStatus($this->tahunPsb, StatusProvider::TRANSFER_INVALID);
    }

    #[Computed]
    public function jmlIkhwan() {
        return $this->santriService->totalTransferByJk($this->tahunPsb, 'Laki-Laki');
    }

    #[Computed]
    public function jmlAkhwat() {
        return $this->santriService->totalTransferByJk($this->tahunPsb, 'Perempuan');
    }

    public function setFilterJk($jk) {
        $this->filterJk = $jk;
        $this->filterStatus = null;
        $this->resetPage();
        $this->ambilFilterData();
    }

    public function setFilterStatus($status) {
        $this->filterStatus = $status;
        $this->filterJk = null;
        $this->resetPage();
        $this->ambilFilterData();
    }

    public function resetFilter() {
        $this->filterJk = null;
        $this->filterStatus = null;
        $this->resetPage();
        $this->ambilFilterData();
    }

    #[On('simpan-status')]
    public function fetchDataPendaftar() {
        $this->dataPendaftar();
    }

    #[On('hapus-success')]
    public function onHapusSuccess() {
        $this->dataPendaftar();
        $this->idPendanfarHapus = null;
        $this->showDeleteModal = false;
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
            'tahunPsb' => $this->tahunPsb,
            'jk' => $this->filterJk,
            'status' => $this->filterStatus
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
    public function setIdPendanfar($id)
    {
        $this->idPendanfar = $id;
    }

    public function setIdPendanfarHapus($id)
    {
        $this->idPendanfarHapus = $id;
        $this->dataPendanfarHapus = Santri::queryDataSantri($id);
        $this->showDeleteModal = true;
        $this->dispatch('buka-modal-hapus');
    }

    public function closeDeleteModal()
    {
        $this->idPendanfarHapus = null;
        $this->dataPendanfarHapus = null;
        $this->showDeleteModal = false;
    }

    public function hapusPendanfar()
    {
        $santri = Santri::find($this->idPendanfarHapus);

        \App\Models\User::where('santri_id', $this->idPendanfarHapus)->delete();

        if ($santri) {
            $tahunPsb = $santri->tahun_psb;
            $files = [$santri->photo, $santri->ktp, $santri->transfer];

            foreach ($files as $file) {
                if ($file) {
                    $filePath = public_path("berkas/{$tahunPsb}/{$file}");

                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }
                }
            }

            $santri->delete();
        }

        $this->closeDeleteModal();
        $this->dispatch('hapus-success');
    }

    // ========== METHOD BARU WHATSAPP ==========

    /**
     * Generate WhatsApp link berdasarkan deteksi perangkat
     *
     * @param string $wa Nomor WhatsApp
     * @param string $text Pesan yang sudah di-encode
     * @return string URL WhatsApp yang sesuai
     */
    private function generateWhatsAppLink($wa, $text)
    {
        if ($this->isMobile) {
            // Untuk HP: pakai deep link whatsapp:// (bisa pilih WA Business)
            return "whatsapp://send?phone=" . $wa . "&text=" . $text;
        } else {
            // Untuk Desktop: pakai wa.me (WhatsApp Web)
            return "https://wa.me/" . $wa . "?text=" . $text;
        }
    }

    /**
     * Encode teks untuk URL
     */
    private function encodeText($text)
    {
        // Gunakan urlencode bawaan PHP
        return urlencode($text);
    }

    //Action kirim notifikasi (VERSI TERBARU)
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

        // Template pesan (tanpa encode dulu)
        if ($statusTransfer == StatusProvider::TRANSFER_VALID) {
            $rawText = "*_KONFIRMASI PENDAFTARAN_*%0A%0ASelamat! Pendaftaran dengan data berikut:%0A%0ANama Lengkap: *" . $nama . "*%0AProgram: *" . $program . "*%0AStatus Transfer: *" . $statusTransfer . "*%0A%0Atelah berhasil. Selanjutnya silahkan tunggu proses pelaksanaan tes masuk, kami akan menghubungi anda kembali, silahkan masuk group sesuai program yang dipilih : https://docs.google.com/spreadsheets/d/1a1zlNNU29bOoWy3ntPgXNOtl5RfpiQXaPGcesc8uu1w %0A,Terima kasih, jazakumullahu khoiron.%0A%0A_Panitia PSB_%0A_https://kias.syathiby.id_";
        } else {
            $rawText = "*_KONFIRMASI PENDAFTARAN_*%0A%0AMohon maaf! Pendaftaran dengan data berikut:%0A%0ANama Lengkap: *" . $nama . "*%0AProgram: *" . $program . "*%0A%0Abelum dapat kami terima dengan alasan *Bukti Transfer Tidak Valid*. Mohon untuk mengirimkan ulang lampiran bukti transfer melalui WhatsApp ini.%0ATerima kasih, jazakumullahu khoiron.%0A%0A_Panitia PSB_%0A_https://kias.syathiby.id_";
        }

        // Generate link berdasarkan deteksi perangkat
        $this->url = $this->generateWhatsAppLink($wa, $rawText);

        $this->dispatch('kirim-notifikasi', url: $this->url);
    }

    public function render()
    {
        if ($this->isMobile) {
            return view('livewire.mobile.admin.pendaftaran.verifikasi-transfer', [
                'url' => $this->url,
                'isMobile' => $this->isMobile
            ])->layout('layouts.app');
        } else {
            return view('livewire.admin.pendaftaran.verifikasi-transfer', [
                'url' => $this->url,
                'isMobile' => $this->isMobile
            ])->layout('layouts.app');
        }
    }
}
