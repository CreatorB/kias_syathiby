@extends('layouts.registrasi.main')

@push('pageCss')
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/pages/page-help-center.css') }}" />
@endpush

@section('content')
<!--Search Box-->
<livewire:santri.cari-nama-pendaftar />

<!--Daftar Program-->
<div class="row">
    @if ($psb->status_psb == 'Tutup')
    <div class="col-12 mb-2">
        <div class="alert alert-danger" role="alert">
            Mohon maaf, pendaftaran program Takhassus Al Barkah sudah TUTUP! Silahkan tunggu tahun depan, <em>Baarakallahu fiikum</em>
        </div>
    </div>
    @else
        <!--Instruksi Khusus-->
        <div class="col-12 mt-2">
            <div class="card mt-1">
                <div class="card-body">
                    <p>
                        <b>PERHATIAN!</b><br>
                        Sebelum anda mendaftar, harap memperhatikan beberapa poin berikut:<br>
                        <ol>
                            <li>Pastikan anda sudah melunasi biaya pendaftaran sebesar <b class="text-primary">Rp {{ number_format($psb->biaya_pendaftaran,0,',','.') }}.</b>
                            Pembayaran dapat dilakukan melalui transfer ke rekening: <br>
                            <b class="text-primary">BSI<br>
                            756 2929 007<br>
                            a/n Yayasan Cahaya Sunnah</b></li>
                            <li>Siapkan file berkas yang dibutuhkan yaitu : <b class="text-primary">Pas photo & KTP/SIM/KTS/KK</b> </li>
                            <li>Isi formulir dengan lengkap dan benar, lalu upload semua berkas yang diminta.
                                Pastikan koneksi yang anda gunakan <b class="text-primary">cepat dan stabil</b></li>
                        </ol>
                        Selanjutnya silahkan pilih program yang tersedia di bawah ini:
                    </p>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h4 class="fw-semibold mb-3 mt-3">Pilih Program</h4>
        </div>
        <!--Tajwid-->
        <div class="col-lg-4 col-md-6 col-12 mb-2">
            <button
                class="btn btn-primary btn-sm me-1"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#collapseExample"
                aria-expanded="false"
                aria-controls="collapseExample"
            >
                Tajwid Al Qur'an
            </button>

            <div class="collapse" id="collapseExample">
                @foreach ($tajwid as $item)
                <div class="card mt-2">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-normal mb-2">Pendaftar :
                                @if ($item->santri->count() == 0)
                                    Tidak Ada
                                @else
                                    {{ $item->santri->count() }} Orang
                                @endif
                            </h6>
                        </div>
                        <div class="d-flex justify-content-between align-items-end mt-1">
                            <div class="role-heading">
                            <h4 class="mb-1">{{ $item->nama_program }}</h4>
                            Hari : {{ $item->hari_belajar }}<br>
                            Waktu : {{ $item->waktu_belajar }}<br>
                            Tempat : {{ $item->tempat_belajar }}
                            </div>
                            <a href="/isi-form/{{ $item->id }}" class="text-muted">
                                <button class="btn btn-success btn-sm">Daftar</button>
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!--Bahasa Arab-->
        <div class="col-lg-4 col-md-6 col-12 mb-2">
            <button
                class="btn btn-primary btn-sm me-1"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#bahasa"
                aria-expanded="false"
                aria-controls="bahasa"
            >
                Bahasa Arab
            </button>

            <div class="collapse" id="bahasa">
                @foreach ($bahasaArab as $item)
                <div class="card mt-2">
                    <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-normal mb-2">Pendaftar :
                            @if ($item->santri->count() == 0)
                                Tidak Ada
                            @else
                                {{ $item->santri->count() }} Orang
                            @endif
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-1">
                        <div class="role-heading">
                        <h4 class="mb-1">{{ $item->nama_program }}</h4>
                        Hari : {{ $item->hari_belajar }}<br>
                        Waktu : {{ $item->waktu_belajar }}<br>
                        Tempat : {{ $item->tempat_belajar }}
                        </div>
                        <a href="/isi-form/{{ $item->id }}" class="text-muted">
                            <button class="btn btn-success btn-sm">Daftar</button>
                        </a>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!--Takmili-->
        <div class="col-lg-4 col-md-6 col-12 mb-2">
            <button
                class="btn btn-primary btn-sm me-1"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#programTakmili"
                aria-expanded="false"
                aria-controls="programTakmili"
            >
                Takmili
            </button>

            <div class="collapse" id="programTakmili">
                @foreach ($takmili as $item)
                <div class="card mt-2">
                    <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-normal mb-2">Pendaftar :
                            @if ($item->santri->count() == 0)
                                Tidak Ada
                            @else
                                {{ $item->santri->count() }} Orang
                            @endif
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-1">
                        <div class="role-heading">
                        <h4 class="mb-1">{{ $item->nama_program }}</h4>
                        Hari : {{ $item->hari_belajar }}<br>
                        Waktu : {{ $item->waktu_belajar }}<br>
                        Tempat : {{ $item->tempat_belajar }}
                        </div>
                        <a href="/isi-form/{{ $item->id }}" class="text-muted">
                            <button class="btn btn-success btn-sm">Daftar</button>
                        </a>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <!--Syariah-->
        <div class="col-lg-4 col-md-6 col-12 mb-2">
            <button
                class="btn btn-primary btn-sm me-1"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#programSyariah"
                aria-expanded="false"
                aria-controls="programSyariah"
            >
                Ulum Asy-Syariah
            </button>

            <div class="collapse" id="programSyariah">
                @foreach ($syariah as $item)
                <div class="card mt-2">
                    <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <h6 class="fw-normal mb-2">Pendaftar :
                            @if ($item->santri->count() == 0)
                                Tidak Ada
                            @else
                                {{ $item->santri->count() }} Orang
                            @endif
                        </h6>
                    </div>
                    <div class="d-flex justify-content-between align-items-end mt-1">
                        <div class="role-heading">
                        <h4 class="mb-1">{{ $item->nama_program }}</h4>
                        Hari : {{ $item->hari_belajar }}<br>
                        Waktu : {{ $item->waktu_belajar }}<br>
                        Tempat : {{ $item->tempat_belajar }}
                        </div>
                        <a href="/isi-form/{{ $item->id }}" class="text-muted">
                            <button class="btn btn-success btn-sm">Daftar</button>
                        </a>
                    </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
