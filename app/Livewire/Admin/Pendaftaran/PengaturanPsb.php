<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\InfoPsb;
use Livewire\Component;
use Livewire\Attributes\Title;

#[Title('Pengaturan PSB')]
class PengaturanPsb extends Component
{
    public ?InfoPsb $psb = null;
    public $psbId = null;

    public $tahun_ajaran = '';
    public $biaya_pendaftaran = 0;
    public $biaya_sarana_prasana = 0;
    public $biaya_kuliah_perdana = 0;
    public $biaya_spp_bulanan = 0;
    public $status_psb = 'Tutup';
    public $datetime_open = '';
    public $datetime_closed = '';
    public $quota_ikhwan = null;
    public $quota_akhwat = null;
    public $konten_psb = '';
    public $poster_images = [];

    protected function rules()
    {
        return [
            'tahun_ajaran' => 'required|string|max:20',
            'biaya_pendaftaran' => 'required|numeric|min:0',
            'biaya_sarana_prasana' => 'required|numeric|min:0',
            'biaya_kuliah_perdana' => 'required|numeric|min:0',
            'biaya_spp_bulanan' => 'required|numeric|min:0',
            'status_psb' => 'required|in:Buka,Tutup',
            'datetime_open' => 'nullable|date',
            'datetime_closed' => 'nullable|date|after_or_equal:datetime_open',
            'quota_ikhwan' => 'nullable|integer|min:0',
            'quota_akhwat' => 'nullable|integer|min:0',
            'konten_psb' => 'nullable|string',
        ];
    }

    public function mount($id = null)
    {
        if ($id) {
            $this->psb = InfoPsb::findOrFail($id);
            $this->psbId = $id;
            $this->tahun_ajaran = $this->psb->tahun_ajaran;
            $this->biaya_pendaftaran = $this->psb->biaya_pendaftaran;
            $this->biaya_sarana_prasana = $this->psb->biaya_sarana_prasana ?? 300000;
            $this->biaya_kuliah_perdana = $this->psb->biaya_kuliah_perdana ?? 250000;
            $this->biaya_spp_bulanan = $this->psb->biaya_spp_bulanan ?? 250000;
            $this->status_psb = $this->psb->status_psb;
            $this->datetime_open = $this->psb->datetime_open?->format('Y-m-d\TH:i') ?? '';
            $this->datetime_closed = $this->psb->datetime_closed?->format('Y-m-d\TH:i') ?? '';
            $this->quota_ikhwan = $this->psb->quota_ikhwan;
            $this->quota_akhwat = $this->psb->quota_akhwat;
            $this->konten_psb = $this->psb->konten_psb ?? '';
            $this->poster_images = $this->psb->poster_images ?? [];
        } else {
            $this->psb = InfoPsb::orderBy('id', 'desc')->first();
            if ($this->psb) {
                $this->psbId = $this->psb->id;
                $this->tahun_ajaran = $this->psb->tahun_ajaran;
                $this->biaya_pendaftaran = $this->psb->biaya_pendaftaran;
                $this->biaya_sarana_prasana = $this->psb->biaya_sarana_prasana ?? 300000;
                $this->biaya_kuliah_perdana = $this->psb->biaya_kuliah_perdana ?? 250000;
                $this->biaya_spp_bulanan = $this->psb->biaya_spp_bulanan ?? 250000;
                $this->status_psb = $this->psb->status_psb;
                $this->datetime_open = $this->psb->datetime_open?->format('Y-m-d\TH:i') ?? '';
                $this->datetime_closed = $this->psb->datetime_closed?->format('Y-m-d\TH:i') ?? '';
                $this->quota_ikhwan = $this->psb->quota_ikhwan;
                $this->quota_akhwat = $this->psb->quota_akhwat;
                $this->konten_psb = $this->psb->konten_psb ?? '';
                $this->poster_images = $this->psb->poster_images ?? [];
            }
        }
    }

    public function save()
    {
        $this->validate();

        $data = [
            'tahun_ajaran' => $this->tahun_ajaran,
            'biaya_pendaftaran' => $this->biaya_pendaftaran,
            'biaya_sarana_prasana' => $this->biaya_sarana_prasana,
            'biaya_kuliah_perdana' => $this->biaya_kuliah_perdana,
            'biaya_spp_bulanan' => $this->biaya_spp_bulanan,
            'status_psb' => $this->status_psb,
            'datetime_open' => $this->datetime_open ?: null,
            'datetime_closed' => $this->datetime_closed ?: null,
            'quota_ikhwan' => $this->quota_ikhwan ?: null,
            'quota_akhwat' => $this->quota_akhwat ?: null,
            'konten_psb' => $this->konten_psb,
            'poster_images' => $this->poster_images,
        ];

        if ($this->psbId) {
            InfoPsb::find($this->psbId)->update($data);
            session()->flash('success', 'Pengaturan PSB berhasil diperbarui!');
        } else {
            InfoPsb::create($data);
            session()->flash('success', 'Pengaturan PSB berhasil dibuat!');
        }

        return redirect()->back();
    }

    public function clearDatetimeOpen()
    {
        $this->datetime_open = '';
    }

    public function clearDatetimeClosed()
    {
        $this->datetime_closed = '';
    }

    public function clearQuotaIkhwan()
    {
        $this->quota_ikhwan = null;
    }

    public function clearQuotaAkhwat()
    {
        $this->quota_akhwat = null;
    }

    public function render()
    {
        $title = $this->psbId ? 'Edit Pengaturan PSB' : 'Pengaturan PSB';
        return view('livewire.admin.pendaftaran.pengaturan-psb')
            ->layout('layouts.app', ['title' => $title]);
    }
}