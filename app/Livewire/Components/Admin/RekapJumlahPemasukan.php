<?php

namespace App\Livewire\Components\Admin;

use App\Services\InfoPsbService;
use App\Services\SantriService;
use Livewire\Component;

class RekapJumlahPemasukan extends Component
{
    //String
    public $tahunPsb;
    //Integer
    public $totalPemasukan, $verifikasiTransfer;

    public function mount(InfoPsbService $infoPsbService, SantriService $santriService) {
        $this->tahunPsb = $infoPsbService->tahunPsb();
        $this->totalPemasukan = $santriService->nominalTransferValid($this->tahunPsb);
        $this->verifikasiTransfer = $santriService->verifikasiTransfer($this->tahunPsb);
    }

    public function render()
    {
        return view('livewire.components.admin.rekap-jumlah-pemasukan');
    }
}
