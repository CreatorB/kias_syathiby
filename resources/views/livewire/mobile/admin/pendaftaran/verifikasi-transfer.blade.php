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
                <x-badges.basic class="cursor-pointer" wire:click="resetFilter" :color="$filterJk || $filterStatus ? 'secondary' : 'primary'">Total : {{ $this->jmlPendaftar }}</x-badges.basic>
                <x-badges.basic class="cursor-pointer" wire:click="setFilterStatus('{{ \App\Providers\StatusProvider::TRANSFER_VALID }}')" color="success">Valid : {{ $this->jmlValid }}</x-badges.basic>
                <x-badges.basic class="cursor-pointer" wire:click="setFilterStatus('{{ \App\Providers\StatusProvider::TRANSFER_PROSES }}')" color="warning">Proses : {{ $this->jmlCek }}</x-badges.basic>
                <x-badges.basic class="cursor-pointer" wire:click="setFilterStatus('{{ \App\Providers\StatusProvider::TRANSFER_INVALID }}')" color="danger">Tidak Valid : {{ $this->jmlInvalid }}</x-badges.basic>
            </div>
        </div>
        <div class="row mb-1">
            <div class="col-12">
                <x-badges.basic class="cursor-pointer" wire:click="setFilterJk('Laki-Laki')" color="success">Ikhwan : {{ $this->jmlIkhwan }}</x-badges.basic>
                <x-badges.basic class="cursor-pointer" wire:click="setFilterJk('Perempuan')" color="danger">Akhwat : {{ $this->jmlAkhwat }}</x-badges.basic>
            </div>
        </div>
        @if ($filterJk || $filterStatus)
        <div class="row mb-1">
            <div class="col-12">
                <a wire:click="resetFilter" class="text-danger cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    Reset Filter
                </a>
            </div>
        </div>
        @endif
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
    <div class="row @if($this->dataPaginator->count() >=4) scroller5 @endif">
        @forelse ($this->dataPaginator as $pendaftar)
            <div class="col-12" wire:key='card-{{ $pendaftar->id }}'>
                <x-cards.apply-job>
                    <x-slot:avatar>
                        <img src="{{ \App\Helpers\FotoHelper::getPathFoto($pendaftar?->tahun_psb, $pendaftar?->kode_registrasi, $pendaftar?->photo) }}" width="42" height="42"/>
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
                        <x-buttons.basic-primary class="w-100 me-25" data-bs-toggle="modal" data-bs-target="#modalVerifikasi" wire:click='setIdPendanfar({{ $pendaftar->id }})'>
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
                                <li>
                                    <a class="dropdown-item d-flex align-items-center text-danger" wire:click='setIdPendanfarHapus({{ $pendaftar->id }})'>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 me-50"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg>
                                        <span>Hapus</span>
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

        @if ($this->dataPaginator->hasMorePages())
            <livewire:components.load-more-button :$tambahData/>
        @endif
    </div>

<!--Modal Verifikasi Transfer-->
    <livewire:components.pendaftaran.modal-verifikasi-transfer idModal="modalVerifikasi" :pid="$idPendanfar" />
    <!--#Modal Verifikasi Transfer-->

    <!--Modal Hapus Pendaftar-->
    @if ($showDeleteModal)
    <x-modals.project-modal id="modalHapus" wire:ignore.self>
        <x-slot:title>Konfirmasi Hapus Pendaftar</x-slot:title>
        <p>Yakin ingin menghapus pendaftar <strong>{{ $dataPendanfarHapus?->nama }}</strong>?</p>
        <p class="text-danger">Tindakan ini tidak dapat dibatalkan.</p>
        <div class="d-flex gap-2">
            <x-buttons.basic color="danger" wire:click='hapusPendanfar'>Hapus</x-buttons.basic>
            <x-buttons.outline color="dark" data-bs-dismiss="modal" wire:click='closeDeleteModal'>Batal</x-buttons.outline>
        </div>
    </x-modals.project-modal>
    @endif
    <!--#Modal Hapus Pendaftar-->
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
        window.addEventListener('hapus-success', event => {
            $('#modalHapus').modal('hide');
        });
        window.addEventListener('buka-modal-hapus', event => {
            $('#modalHapus').modal('show');
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
