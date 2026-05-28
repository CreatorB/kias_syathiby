<div>
    <x-links.breadcrumb>
        <x-slot:judul_halaman>Data Pendaftar</x-slot:judul_halaman>
        <x-slot:halaman1 href="{{ route('admin::data_santri') }}">Data Santri</x-slot:halaman1>
        <x-slot:halaman_aktif>Detail Data Pendaftar</x-slot:halaman_aktif>
    </x-links.breadcrumb>

    <div class="row">
        <!--Info Ringkas-->
        <div class="col-lg-4 col-12">
<x-cards.user-detail>
                <x-slot:photo>
                    @php
                        $photoPath = 'berkas/'.$dataPendanfar->tahun_psb.'/'.$dataPendanfar->photo;
                        $photoExists = file_exists(public_path($photoPath)) && !empty($dataPendanfar->photo);
                    @endphp
                    @if($photoExists)
                        <img class="img-fluid rounded mt-3 mb-2" src="{{ asset($photoPath) }}" height="210" width="210" />
                    @else
                        <div class="bg-light rounded mt-3 mb-2 d-flex align-items-center justify-content-center" style="height: 210px; width: 210px;">
                            <i class="ti ti-user" style="font-size: 4rem; color: #ccc;"></i>
                        </div>
                    @endif
                </x-slot:photo>
                <x-slot:nama>{{ $dataPendaftar->nama }}</x-slot:nama>
                <x-slot:subtitle>{{ $dataPendaftar->kode_registrasi }}</x-slot:subtitle>
                <x-slot:judul_fitur>Program</x-slot:judul_fitur>
                <x-slot:keterangan_fitur>{{ $dataPendaftar->program?->nama_program }}</x-slot:keterangan_fitur>
                <x-slot:judul_informasi>Informasi Penting</x-slot:judul_informasi>
                <x-slot:informasi>
                    <li class="mb-1">Jenis Kelamin : {{ $dataPendaftar->jk }}</li>
                    <li class="mb-1">Email : {{ $dataPendaftar->email }}</li>
                    <li class="mb-1">No. HP : +{{ $dataPendaftar->hp }}</li>
                    <li class="mb-1">Tahun Ajaran : {{ $dataPendaftar->tahun_psb }}</li>
                </x-slot:informasi>
            </x-cards.user-detail>
        </div>
        <!--Info Ringkas-->

        <!--Detail Profil-->
        <div class="col-lg-8 col-12">
            <x-cards.basic-card>
                <x-slot:cardHeader>Detail Profil</x-slot:cardHeader>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Tempat Lahir</h5>
                        <span>{{ $dataPendaftar->tmp_lahir }}</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Tanggal Lahir</h5>
                        <span>{{ \App\Helpers\TanggalHelper::konversiTanggal($dataPendaftar->tgl_lahir) }}</span>
                    </div>
                    <div class="col-12 mb-1">
                        <h5>Alamat</h5>
                        <span>{{ $dataPendaftar->alamat }}</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Pendidikan Terkahir</h5>
                        <span>{{ $dataPendaftar->pendidikan }}</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Pekerjaan</h5>
                        <span>{{ $dataPendaftar->pekerjaan?->nama_pekerjaan }}</span>
                    </div>
<div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Lampiran Photo</h5>
                        @php
                            $photoPath = 'berkas/'.$dataPendanfar->tahun_psb.'/'.$dataPendanfar->photo;
                            $photoExists = file_exists(public_path($photoPath)) && !empty($dataPendanfar->photo);
                        @endphp
                        @if($photoExists)
                            <img class="img-fluid rounded" src="{{ asset($photoPath) }}" height="auto" width="300" />
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px; width: 300px;">
                                <span class="text-muted"><i class="ti ti-photo-off me-1"></i> File tidak ditemukan</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Lampiran KTP</h5>
                        @php
                            $ktpPath = 'berkas/'.$dataPendanfar->tahun_psb.'/'.$dataPendanfar->ktp;
                            $ktpExists = file_exists(public_path($ktpPath)) && !empty($dataPendanfar->ktp);
                        @endphp
                        @if($ktpExists)
                            <img class="img-fluid rounded" src="{{ asset($ktpPath) }}" height="auto" width="300" />
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px; width: 300px;">
                                <span class="text-muted"><i class="ti ti-photo-off me-1"></i> File tidak ditemukan</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Lampiran Transfer</h5>
                        @php
                            $transferPath = 'berkas/'.$dataPendanfar->tahun_psb.'/'.$dataPendanfar->transfer;
                            $transferExists = file_exists(public_path($transferPath)) && !empty($dataPendanfar->transfer);
                        @endphp
                        @if($transferExists)
                            <img class="img-fluid rounded" src="{{ asset($transferPath) }}" height="auto" width="300" />
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px; width: 300px;">
                                <span class="text-muted"><i class="ti ti-photo-off me-1"></i> File tidak ditemukan</span>
                            </div>
                        @endif
                    </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Lampiran KTP</h5>
                        @php
                            $ktpPath = 'berkas/'.$dataPendaftar->tahun_psb.'/'.$dataPendaftar->kode_registrasi.'/'.$dataPendaftar->ktp;
                            $ktpExists = file_exists(public_path($ktpPath)) && !empty($dataPendaftar->ktp);
                        @endphp
                        @if($ktpExists)
                            <img class="img-fluid rounded" src="{{ asset($ktpPath) }}" height="auto" width="300" />
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px; width: 300px;">
                                <span class="text-muted"><i class="ti ti-photo-off me-1"></i> File tidak ditemukan</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-1">
                        <h5>Lampiran Transfer</h5>
                        @php
                            $transferPath = 'berkas/'.$dataPendaftar->tahun_psb.'/'.$dataPendaftar->kode_registrasi.'/'.$dataPendaftar->transfer;
                            $transferExists = file_exists(public_path($transferPath)) && !empty($dataPendaftar->transfer);
                        @endphp
                        @if($transferExists)
                            <img class="img-fluid rounded" src="{{ asset($transferPath) }}" height="auto" width="300" />
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px; width: 300px;">
                                <span class="text-muted"><i class="ti ti-photo-off me-1"></i> File tidak ditemukan</span>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <x-buttons.outline color="dark" onclick="window.history.back()">
                            <x-slot:icon><i data-feather='arrow-left'></i></x-slot:icon>
                            Kembali
                        </x-buttons.outline>
                    </div>
                </div>
            </x-cards.basic-card>
        </div>
        <!--#Detail Profil-->
    </div>
</div>