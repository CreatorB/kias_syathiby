<?php

namespace App\Livewire\Peserta;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use App\Models\Santri;
use App\Models\InfoPsb;
use App\Providers\StatusProvider;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    use WithPagination;

    #[Title('Dashboard')]
    public $santri;
    public $unreadCount;
    public $biayaPendaftaran;
    public $infoPsb;
    public $linkGroup;

    public function mount()
    {
        $user = Auth::user();
        $this->santri = $user->santri;

        if (!$this->santri) {
            $this->santri = Santri::where('email', $user->email)->first();
        }

        $this->unreadCount = $user->notifications()->where('is_read', false)->count();

        $tahunPsb = $this->santri?->tahun_psb ?? InfoPsb::getActiveYear();
        $this->infoPsb = InfoPsb::where('tahun_ajaran', $tahunPsb)->first();
        $this->biayaPendaftaran = $this->infoPsb?->biaya_pendaftaran ?? 150000;
        $this->linkGroup = $this->infoPsb?->link_group;
    }

    public function render()
    {
        $user = Auth::user();
        $notifications = $user->notifications()->paginate(10);

        return view('livewire.peserta.dashboard', [
            'notifications' => $notifications
        ])->layout('layouts.peserta.sidebar-layout', ['title' => 'Dashboard Peserta']);
    }
}
