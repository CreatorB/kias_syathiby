<div>
    @use('\App\Providers\StatusProvider', 'StatusProvider')
    @use('\App\Helpers\TanggalHelper', 'TanggalHelper')

    @push('vendorCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/vendors/css/extensions/toastr.min.css') }}">
    @endpush

    @push('pageCss')
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/plugins/extensions/ext-component-toastr.css') }}">
    @endpush

    <x-links.breadcrumb>
        <x-slot:judul_halaman>Verifikasi Transfer</x-slot:judul_halaman>
        <x-slot:halaman_aktif>Bukti Transfer Biaya Pendaftaran</x-slot:halaman_aktif>
    </x-links.breadcrumb>

    <!--Filter Data-->
    <div class="row mb-1">
        <div class="col-12 mb-1">
            <x-inputs.label>Cari Santri</x-inputs.label>
            <x-inputs.basic placeholder="Ketik nama santri disini..." wire:model.live='cariSantri'/>
        </div>
        <div class="row mb-1">
            <div class="col-12">
                <x-badges.basic color="primary">Total : {{ $this->jmlPendaftar }}</x-badges.basic>
                <x-badges.basic color="success">Valid : {{ $this->jmlValid }}</x-badges.basic>
                <x-badges.basic color="warning">Proses : {{ $this->jmlCek }}</x-badges.basic>
                <x-badges.basic color="danger">Tidak Valid : {{ $this->jmlInvalid }}</x-badges.basic>
            </div>
        </div>
        <div class="col-12">
            <x-buttons.dropdown-outline color='primary'>
                <x-slot name="buttonName">
                    <strong class="text-primary">{{ $tahunPsb }}</strong>
                </x-slot>
                <x-buttons.dropdown-menu>
                    @foreach ($infoPsb as $psb)
                        <x-buttons.dropdown-item wire:click='pilihPsb({{ $psb->id }})'>{{ $psb->tahun_ajaran }}</x-buttons.dropdown-item>
                    @endforeach
                </x-buttons.dropdown-menu>
            </x-buttons.dropdown-outline>
        </div>
    </div>
    <!--#Filter Data-->

    <!--Card List Santri-->
    <div class="row @if($this->dataPendaftar->count() >=4) scroller5 @endif">
        @forelse ($this->dataPendaftar as $pendaftar)
            <div class="col-12" wire:key='card-{{ $pendaftar->id }}'>
                <x-cards.apply-job>
                    <x-slot:avatar>
                        <img src="{{ asset('berkas/'.$pendaftar?->tahun_psb.'/'.$pendaftar?->photo.'') }}" width="42" height="42"/>
                    </x-slot:avatar>
                    <x-slot:title>
                        {{ Str::excerpt($pendaftar->nama,'',[
                            'radius' => 25,
                            'omission' => '...'
                        ]) }}
                    </x-slot:title>
                    <x-slot:subTitle>{{ $pendaftar->kode_registrasi }}</x-slot:subTitle>
                    <x-slot:badge>
                        <x-badges.basic :color="
                        ($pendaftar->status_transfer == StatusProvider::TRANSFER_VALID ? 'success' : (
                        $pendaftar->status_transfer == StatusProvider::TRANSFER_PROSES ? 'warning' :
                        'danger'))
                        ">
                            {{ $pendaftar->status_transfer }}
                        </x-badges.basic>
                    </x-slot:badge>
                    <x-slot:content>
                        Waktu Daftar : {{ TanggalHelper::konversiTanggalPenuh($pendaftar->created_at) }}
                        <br/>
                        Notifikasi :
                        @if ($pendaftar->kirim_notifikasi == 1)
                            <strong class="text-success">Sudah</strong>
                        @else
                            <strong class="text-danger">Belum</strong>
                        @endif
                    </x-slot:content>
                    <x-slot:highlight>{{ $pendaftar->program?->nama_program }}</x-slot:highlight>

                    <!--Action Button-->
                    <div class="d-grid d-flex justify-content-between">
                        <x-buttons.basic-primary class="w-100 me-25" data-bs-toggle="modal" data-bs-target="#modalVerifikasi" wire:click='setIdPendaftar({{ $pendaftar->id }})'>
                            Verifikasi
                        </x-buttons.basic-primary>
                        <div class="dropup">
                            <x-buttons.outline-primary class="w-10" data-bs-toggle="dropdown">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical">
                                    <circle cx="12" cy="12" r="1"></circle>
                                    <circle cx="12" cy="5" r="1"></circle>
                                    <circle cx="12" cy="19" r="1"></circle>
                                </svg>
                            </x-buttons.outline-primary>
                            <ul class="dropdown-menu">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" wire:navigate href="{{ route('admin::detail_pendaftar', [$pendaftar->kode_registrasi]) }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text me-50"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                        <span>Detail</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center" wire:click='kirimNotifikasi({{ $pendaftar->id }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle me-50"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg>
                                        <span>Notifikasi</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!--#Action Button-->
                </x-cards.apply-job>
            </div>
        @empty
            <div class="col-12">
                <x-alerts.simple-alert class="alert-danger">
                    <x-slot:body>Belum ada santri yang mendaftar</x-slot:body>
                </x-alerts.simple-alert>
            </div>
        @endforelse

        @if ($this->dataPendaftar->hasMorePages())
            <livewire:components.load-more-button :$tambahData/>
        @endif
    </div>

    <!--Modal Verifikasi Transfer-->
    <livewire:components.pendaftaran.modal-verifikasi-transfer idModal="modalVerifikasi" :$idPendaftar />
    <!--#Modal Verifikasi Transfer-->
    <!--#Card List Santri-->

    @push('vendorJS')
    <script src="{{ asset('style/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    @endpush

    @push('pageJS')
    <script src="{{ asset('style/app-assets/js/scripts/extensions/ext-component-toastr.js') }}"></script>

    <!--Tutup Modal-->
    <script data-navigate-once>
        window.addEventListener('simpan-status', event => {
            $('#modalVerifikasi').modal('hide');
        });
    </script>

    <!--Toast Sukses Simpan-->
    <script data-navigate-once>
        document.addEventListener('simpan-status', function() {
            'use strict';
            var isRtl = $('html').attr('data-textdirection') === 'rtl';

            // On load Toast
            setTimeout(function() {
                toastr['success'](
                    '👋Status transfer berhasil diupdate',
                    'OK!', {
                        closeButton: true,
                        tapToDismiss: true,
                        rtl: isRtl
                    }
                );
            }, 500);
        });
    </script>
    @endpush

    @script
    <script data-navigate-once>
        document.addEventListener('kirim-notifikasi', function(event) {
            'use strict';
            var isRtl = $('html').attr('data-textdirection') === 'rtl';
            var url = event.detail.url;

            // On load Toast
            setTimeout(function () {
            toastr['success'](
                'Notifikasi Berhasil Dikirim',
                '👋 OK!',
                {
                closeButton: true,
                tapToDismiss: true,
                rtl: isRtl
                }
            );
            }, 500);

            setTimeout( () => {
                window.open(url,"_blank");
            }, 2000);
        });
    </script>
    @endscript
</div>
