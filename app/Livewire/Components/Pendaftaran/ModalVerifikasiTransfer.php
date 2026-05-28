<?php

namespace App\Livewire\Components\Pendaftaran;

use App\Models\Santri;
use Livewire\Component;
use Livewire\Attributes\Reactive;

class ModalVerifikasiTransfer extends Component
{
    #[Reactive]
    public $pid;
    //String
    public $statusTransfer, $idModal;
    //Collection
    public $data;

    public function boot() {
        $this->load();
    }

    public function updatedPid($value) {
        $this->load();
    }

    private function load() {
        if ($this->pid) {
            $this->data = Santri::queryDataSantri($this->pid);
            $this->statusTransfer = $this->data ?->status_transfer;
        }
    }

    //Action simpan data
    public function simpanStatus() {
        $santri = Santri::find($this->pid);
        $santri->update([
            'status_transfer' => $this->statusTransfer,
        ]);

        if ($this->statusTransfer === 'Valid') {
            \App\Models\User::where('santri_id', $santri->id)
                ->update(['is_active' => true]);
        }

        $this->dispatch('simpan-status');
    }

    public function render()
    {
        return view('livewire.components.pendaftaran.modal-verifikasi-transfer');
    }
}
