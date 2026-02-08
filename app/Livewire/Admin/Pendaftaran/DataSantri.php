<?php

namespace App\Livewire\Admin\Pendaftaran;

use App\Models\InfoPsb;
use App\Models\Program;
use Livewire\Component;
use Detection\MobileDetect;
use Livewire\Attributes\On;
use Livewire\Attributes\Title;
use App\Services\SantriService;
use App\Services\InfoPsbService;
use Livewire\Attributes\Computed;

class DataSantri extends Component
{
    //Object
    public $listProgram, $infoPsb, $filterData = null;
    //String
    public $filterTahun, $cariSantri = '', $filterJk = null;
    //Integer
    public $filterProgram = null, $limitData = 9, $radius = 30, $tambahData = 18;
    //Boolean
    public $isMobile, $isReset = false;

    protected InfoPsbService $infoPsbService;
    protected SantriService $santriService;

    #[Title('Data Induk Santri')]

    #[Computed]
    public function dataSantri()
    {
        return $this->santriService->paginateSantriInduk($this->filterTahun, $this->limitData, $this->filterData);
    }

    #[Computed]
    public function jumlahSantri()
    {
        return $this->santriService->totalSantriInduk($this->filterTahun, $this->filterData);
    }

    #[Computed]
    public function jumlahIkhwan()
    {
        return $this->santriService->totalSantriIkhwan($this->filterTahun, $this->filterData);
    }

    #[Computed]
    public function jumlahAkhwat()
    {
        return $this->santriService->totalSantriAkhwat($this->filterTahun, $this->filterData);
    }

    #[On('load-data')]
    public function loadMore($addData)
    {
        $this->limitData += $addData;
    }

    public function boot()
    {
        $this->santriService = new SantriService();
        $this->infoPsbService = new InfoPsbService();
    }

    public function mount(MobileDetect $mobileDetect)
    {
        $this->listProgram = Program::select('id', 'nama_program')->get();
        $this->filterTahun = $this->infoPsbService->tahunPsb();
        $this->infoPsb = InfoPsb::orderBy('id', 'desc')->limit(3)->get();
        if ($mobileDetect->isMobile()) {
            $this->isMobile = true;
            $this->radius = 25;
        } else {
            $this->isMobile = false;
        }
    }

    public function updated($property)
    {
        $this->filterData = collect([
            'namaSantri' => $this->cariSantri,
            'program' => $this->filterProgram,
            'jk' => $this->filterJk
        ]);

        if ($property == 'filterTahun' || $property == 'filterProgram') {
            $this->isReset = true;
        }
    }

    public function setFilterJk($jk)
    {
        $this->filterJk = $jk;
        $this->filterData = collect([
            'namaSantri' => $this->cariSantri,
            'tahunPsb' => $this->filterTahun,
            'program' => $this->filterProgram,
            'jk' => $this->filterJk
        ]);
    }

    public function render()
    {
        return view('livewire.admin.pendaftaran.data-santri')->layout('layouts.app');
    }
}
