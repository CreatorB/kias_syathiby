<div>
    <x-links.breadcrumb>
        <x-slot:judul_halaman>Data Santri</x-slot:judul_halaman>
        <x-slot:halaman_aktif>Data Induk Santri KIAS</x-slot:halaman_aktif>
    </x-links.breadcrumb>

    <div class="row">
        <div class="col-12">
            <p>Berikut ini adalah data santri yang telah <strong class="text-primary">"Melunasi Biaya
                    Pendaftaran"</strong></p>
        </div>
    </div>

    <!--Filter Data-->
    <div class="row">
        @if ($isReset)
            <div class="col-12">
                <a wire:navigate href="{{ route('admin::data_santri') }}" class="text-danger">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-x">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                    <span>Reset Filter</span>
                </a>
            </div>
        @endif
        <div class="col-lg-4 col-md-6 col-12 mb-1">
            <x-inputs.label>Cari Santri</x-inputs.label>
            <x-inputs.basic placeholder="Ketik nama santri disini..." wire:model.live='cariSantri' />
        </div>
        <div class="col-lg-4 col-md-6 col-7 mb-1">
            <x-inputs.label>Filter Program</x-inputs.label>
            <x-inputs.select wire:model.live='filterProgram'>
                <x-inputs.select-option value=null disabled selected>--Semua Program--</x-inputs.select-option>
                @foreach ($listProgram as $program)
                    <x-inputs.select-option value="{{ $program->id }}">{{ $program->nama_program }}</x-inputs.select-option>
                @endforeach
            </x-inputs.select>
        </div>
        <div class="col-lg-4 col-md-6 col-5 mb-1">
            <x-inputs.label>Filter Tahun</x-inputs.label>
            <x-inputs.select wire:model.live='filterTahun'>
                @foreach ($infoPsb as $psb)
                    <x-inputs.select-option>{{ $psb->tahun_ajaran }}</x-inputs.select-option>
                @endforeach
            </x-inputs.select>
        </div>
    </div>
    <!--#Filter Data-->

    <!--Counter Santri-->
    <div class="row mb-1">
        <div class="col-12">
            <x-badges.basic class="cursor-pointer" wire:click="setFilterJk(null)" color="primary">Total Santri :
                {{ $this->jumlahSantri }}</x-badges.basic>
            <x-badges.basic class="cursor-pointer" wire:click="setFilterJk('Laki-Laki')" color="success">Ikhwan :
                {{ $this->jumlahIkhwan }}</x-badges.basic>
            <x-badges.basic class="cursor-pointer" wire:click="setFilterJk('Perempuan')" color="danger">Akhwat :
                {{ $this->jumlahAkhwat }}</x-badges.basic>
        </div>
    </div>
    <!--#Counter Santri-->

    <!--Card Data Santri-->
    <div class="row @if($this->dataSantri->count() >= 6) scroller5 @endif">
        @forelse ($this->dataSantri as $santri)
                <div class="col-lg-4 col-md-6 col-12" wire:key='card-{{ $santri->id }}'>
                    <x-cards.apply-job>
                        <x-slot:avatar>
                            <img src="{{ asset('berkas/' . $santri?->tahun_psb . '/' . $santri?->photo . '') }}" width="42"
                                height="42" />
                        </x-slot:avatar>
                        <x-slot:title>
                            {{ Str::excerpt($santri->nama, '', [
                'radius' => $radius,
                'omission' => '...'
            ]) }}
                        </x-slot:title>
                        <x-slot:subTitle>{{ $santri->kode_registrasi }}</x-slot:subTitle>
                        <x-slot:content>
                            Jenis Kelamin : {{ $santri->jk ?? '-' }}
                            <br />
                            Email : {{ $santri->email ?? '-' }}
                            <br />
                            No. HP : @if ($santri->hp != null)+@endif{{ $santri->hp ?? '-' }}
                            <br />
                        </x-slot:content>
                        <x-slot:highlight>{{ $santri->program?->nama_program }}</x-slot:highlight>

                        <!--Action Button-->
                        <div class="d-grid col-12">
                            {{-- <a wire:navigate href="{{ route('admin::detail_pendaftar', [$santri->kode_registrasi]) }}">
                                --}}
                                <x-buttons.basic-primary
                                    onclick="location.href='{{ route('admin::detail_pendaftar', [$santri->kode_registrasi]) }}'">
                                    Detail
                                </x-buttons.basic-primary>
                                {{-- </a> --}}
                        </div>
                        <!--#Action Button-->
                    </x-cards.apply-job>
                </div>
        @empty
            <div class="col-12">
                <x-alerts.simple-alert class="alert-danger">
                    <x-slot:body>Mohon maaf, tidak ada data yang bisa ditampilkan</x-slot:body>
                </x-alerts.simple-alert>
            </div>
        @endforelse

        @if ($this->dataSantri->hasMorePages())
            <livewire:components.load-more-button :$tambahData />
        @endif
    </div>
    <!--#Card Data Santri-->
</div>