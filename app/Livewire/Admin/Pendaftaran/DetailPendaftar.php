<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\Santri;
use Livewire\Component;
use Livewire\Attributes\Title;

class DetailPendaftar extends Component
{
    //Integer
    public $kodeRegistrasi;
    //Collection
    public $dataPendaftar;

    #[Title('Detail Data Pendaftar')]

    public function mount($kodeRegistrasi)
    {
        $this->dataPendaftar = Santri::detailPendaftar($kodeRegistrasi);
    }

    public function render()
    {
        return view('livewire.admin.pendaftaran.detail-pendaftar')->layout('layouts.app');
    }
}
