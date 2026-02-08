<?php

namespace App\Livewire\Santri;

use App\Models\Santri;
use Livewire\Component;
use App\Services\InfoPsbService;

class CariNamaPendaftar extends Component
{
    public $search;
    public $dataSantri;

    public function boot(InfoPsbService $info) {
        $this->InfoPsbService = $info;

        $dataSearch = $this->search;
        $tahunPsb = $this->InfoPsbService->tahunPsb();

        if ($dataSearch != NULL){
                $this->dataSantri = Santri::cariNama($tahunPsb, $dataSearch);
        } else {
                $this->dataSantri =  Santri::cariNamaSemua($tahunPsb);
        }
    }

    public function render()
    {
        return view('livewire.santri.cari-nama-pendaftar');
    }
}
