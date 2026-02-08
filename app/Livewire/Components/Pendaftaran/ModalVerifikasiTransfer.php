<?php

namespace App\Livewire\Components\Pendaftaran;

use App\Models\Santri;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class ModalVerifikasiTransfer extends Component
{
    #[Reactive]
    public $idPendaftar;
    //String
    public $statusTransfer, $idModal;
    //Collection
    public $dataPendaftar;

    public function boot() {
        $this->dataPendaftar = Santri::queryDataSantri($this->idPendaftar);
        $this->statusTransfer = $this->dataPendaftar?->status_transfer;
    }

    //Action simpan data
    public function simpanStatus() {
        Santri::where('id', $this->idPendaftar)
        ->update([
            'status_transfer' => $this->statusTransfer,
        ]);
        $this->dispatch('simpan-status');
    }

    public function render()
    {
        return view('livewire.components.pendaftaran.modal-verifikasi-transfer');
    }
}
