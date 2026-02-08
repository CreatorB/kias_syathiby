<div>
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

    <div class="row">
        <div class="col-12">
            <x-cards.basic-card>
                <x-slot:cardHeader>Tabel Data Pendaftar</x-slot:cardHeader>
                <!--Filter Data-->
                <div class="row">
                    <div class="d-flex justify-content-between mb-1">
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="align-self-center">
                                <x-inputs.basic placeholder="Cari santri disini..." wire:model.live='cariSantri'/>
                            </div>
                        </div>
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

                <!--Badge Counter-->
                <div class="row mb-1">
                    <div class="col-12">
                        <x-badges.basic color="primary">Total : {{ $this->jmlPendaftar }}</x-badges.basic>
                        <x-badges.basic color="success">Valid : {{ $this->jmlValid }}</x-badges.basic>
                        <x-badges.basic color="warning">Proses : {{ $this->jmlCek }}</x-badges.basic>
                        <x-badges.basic color="danger">Tidak Valid : {{ $this->jmlInvalid }}</x-badges.basic>
                    </div>
                </div>
                <!--#Badge Counter-->

                <!--Tabel Data Pendaftar-->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-hover table-striped mb-1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Santri</th>
                                    <th>Jenis</th>
                                    <th>Program</th>
                                    <th>Tanggal Daftar</th>
                                    <th>Transfer</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($this->dataPendaftar as $pendaftar)
                                    <tr wire:key='table-{{ $pendaftar->id }}'>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pendaftar->nama }}</td>
                                        <td>{{ $pendaftar->jk }}</td>
                                        <td>{{ $pendaftar->program?->nama_program }}</td>
                                        <td>{{ TanggalHelper::konversiTanggalPenuh($pendaftar->created_at) }}</td>
                                        <td>
                                            @if ($pendaftar->status_transfer == \App\Providers\StatusProvider::TRANSFER_VALID)
                                                <x-items.light-badge color="success" content="Valid"/>
                                            @elseif ($pendaftar->status_transfer == \App\Providers\StatusProvider::TRANSFER_PROSES)
                                                <x-items.light-badge color="warning" content="Cek"/>
                                            @else
                                                <x-items.light-badge color="danger" content="Invalid"/>
                                            @endif
                                        </td>
                                        <td>
                                            <x-buttons.outline :color="$pendaftar->kirim_notifikasi == 1 ? 'success' : 'danger'" class="btn-icon btn-sm" wire:click='kirimNotifikasi({{ $pendaftar->id }})'>
                                                <svg xmlns="http://www.w3.org/2000/svg" height="14" width="12.25" viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path fill="#3ac200" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7 .9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z"/></svg>
                                            </x-buttons.outline>
                                            <x-buttons.outline :color="$pendaftar->status_transfer == \App\Providers\StatusProvider::TRANSFER_VALID ? 'success' : 'warning'" class="btn-icon btn-sm" data-bs-toggle="modal" data-bs-target="#modalVerifikasi" wire:click='setIdPendaftar({{ $pendaftar->id }})'>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-dollar-sign text-{{ $pendaftar->status_transfer == \App\Providers\StatusProvider::TRANSFER_VALID ? 'success' : 'warning' }}"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
                                            </x-buttons.outline>
                                            <a wire:navigate href="{{ route('admin::detail_pendaftar', [$pendaftar->kode_registrasi]) }}">
                                                <x-buttons.outline color="primary" class="btn-icon btn-sm">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text text-primary"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                                </x-buttons.outline>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-danger"><em>Tidak ada data yang bisa ditampilkan</em></td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $this->dataPendaftar->links(data: ['scrollTo' => false]) }}
                    </div>
                </div>
                <!--#Tabel Data Pendaftar-->
            </x-cards.basic-card>

            <!--Modal Verifikasi Transfer-->
            <livewire:components.pendaftaran.modal-verifikasi-transfer idModal="modalVerifikasi" :$idPendaftar />
            <!--#Modal Verifikasi Transfer-->
        </div>
    </div>

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
                '👋 Selamat!',
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
