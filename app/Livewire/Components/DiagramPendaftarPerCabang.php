<?php

namespace App\Livewire\Components;

use App\Models\Santri;
use App\Models\Program;
use Livewire\Component;
use App\Services\InfoPsbService;

class DiagramPendaftarPerCabang extends Component
{
    //Object
    public $santriPerProgram;
    //Integer
    public $jumlahPendaftar;
    //String
    public $tahunPsb;

    public function mount(InfoPsbService $infoPsbService) {
        $this->tahunPsb = $infoPsbService->tahunPsb();
        $this->santriPerProgram = Program::jumlahPendaftarPerCabang($this->tahunPsb);
        $this->jumlahPendaftar = Santri::where('tahun_psb', $this->tahunPsb)->count();
    }

    public function render()
    {
        return view('livewire.components.diagram-pendaftar-per-cabang');
    }
}
