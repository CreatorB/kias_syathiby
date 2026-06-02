@extends('layouts.registrasi.main')

@push('pageCss')
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/pages/page-help-center.css') }}" />
@endpush

@section('content')
@if (!$psb || !$psb->isOpen())
    <div class="col-12 mb-2">
        <div class="alert alert-danger" role="alert">
            Mohon maaf, pendaftaran program KIAS sudah TUTUP! Silahkan tunggu tahun depan, <em>Baarakallahu fiikum</em>
        </div>
    </div>
@else
    @if($psb->quota_ikhwan || $psb->quota_akhwat)
    <div class="col-12 mb-3">
        <div class="alert alert-info py-2">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <strong><i class="fas fa-chart-pie me-1"></i> Kuota Pendaftaran</strong>
                </div>
                <div class="d-flex gap-4">
                    <div class="text-center">
                        <span class="badge bg-primary"><i class="fas fa-male me-1"></i> Ikhwan</span>
                        <div class="mt-1">
                            @if($psb->quota_ikhwan)
                                {{ $psb->registered_ikhwan_count }} / {{ $psb->quota_ikhwan }}
                                @if($psb->remaining_quota_ikhwan === 0)
                                    <span class="text-danger small">(Penuh)</span>
                                @endif
                            @else
                                Unlimited
                            @endif
                        </div>
                    </div>
                    <div class="text-center">
                        <span class="badge bg-danger"><i class="fas fa-female me-1"></i> Akhwat</span>
                        <div class="mt-1">
                            @if($psb->quota_akhwat)
                                {{ $psb->registered_akhwat_count }} / {{ $psb->quota_akhwat }}
                                @if($psb->remaining_quota_akhwat === 0)
                                    <span class="text-danger small">(Penuh)</span>
                                @endif
                            @else
                                Unlimited
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="alert alert-info py-2 mb-3">
        <div class="d-flex align-items-center">
            <i class="fas fa-info-circle me-2"></i>
            <div>
                <strong>PERHATIAN!</strong> Sebelum mendaftar, pastikan:
                <ol class="mb-0 mt-1">
                    <li>Siapkan file <b class="text-primary">Pas photo & KTP/SIM/KTS/KK</b></li>
                    <li>Pelunasi biaya pendaftaran <b class="text-primary">Rp {{ number_format($psb->biaya_pendaftaran,0,',','.') }}</b> ke <b class="text-primary">BSI 756 2929 007 a/n Yayasan Cahaya Sunnah</b></li>
                    <li>Isi formulir dengan lengkap dan benar</li>
                </ol>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-semibold mb-0">Pilih Program</h4>
        <span class="badge bg-secondary">{{ $tajwid->count() + $bahasaArab->count() + $takmili->count() + $syariah->count() }} Program Tersedia</span>
    </div>

    <div class="row">
        @php
        $quotaFull = false;
        if($psb->quota_ikhwan !== null && $psb->remaining_quota_ikhwan === 0) $quotaFull = true;
        if($psb->quota_akhwat !== null && $psb->remaining_quota_akhwat === 0) $quotaFull = true;
        @endphp

        @foreach($tajwid as $item)
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-primary">Tajwid Al-Qur'an</span>
                        <span class="text-muted small">
                            <i class="fas fa-users me-1"></i>
                            {{ $item->santri->count() }} pendaftar
                        </span>
                    </div>
                    <h5 class="card-title fw-bold mb-1">{{ $item->nama_program }}</h5>
                    <p class="text-muted small mb-2">{{ $item->persyaratan }}</p>
                    <div class="mt-auto">
                        <div class="row text-muted small mb-2">
                            <div class="col-6"><i class="fas fa-calendar me-1"></i> {{ $item->hari_belajar }}</div>
                            <div class="col-6"><i class="fas fa-clock me-1"></i> {{ $item->waktu_belajar }}</div>
                            <div class="col-12"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->tempat_belajar }}</div>
                        </div>
                        @if($quotaFull)
                            <button class="btn btn-secondary btn-sm w-100" disabled>Kuota Penuh</button>
                        @else
                            <a href="/isi-form/{{ $item->id }}" class="btn btn-success btn-sm w-100">Daftar Sekarang</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($bahasaArab as $item)
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-info">Bahasa Arab</span>
                        <span class="text-muted small">
                            <i class="fas fa-users me-1"></i>
                            {{ $item->santri->count() }} pendaftar
                        </span>
                    </div>
                    <h5 class="card-title fw-bold mb-1">{{ $item->nama_program }}</h5>
                    <p class="text-muted small mb-2">{{ $item->persyaratan }}</p>
                    <div class="mt-auto">
                        <div class="row text-muted small mb-2">
                            <div class="col-6"><i class="fas fa-calendar me-1"></i> {{ $item->hari_belajar }}</div>
                            <div class="col-6"><i class="fas fa-clock me-1"></i> {{ $item->waktu_belajar }}</div>
                            <div class="col-12"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->tempat_belajar }}</div>
                        </div>
                        @if($quotaFull)
                            <button class="btn btn-secondary btn-sm w-100" disabled>Kuota Penuh</button>
                        @else
                            <a href="/isi-form/{{ $item->id }}" class="btn btn-success btn-sm w-100">Daftar Sekarang</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($takmili as $item)
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-warning text-dark">Takmili</span>
                        <span class="text-muted small">
                            <i class="fas fa-users me-1"></i>
                            {{ $item->santri->count() }} pendaftar
                        </span>
                    </div>
                    <h5 class="card-title fw-bold mb-1">{{ $item->nama_program }}</h5>
                    <p class="text-muted small mb-2">{{ $item->persyaratan }}</p>
                    <div class="mt-auto">
                        <div class="row text-muted small mb-2">
                            <div class="col-6"><i class="fas fa-calendar me-1"></i> {{ $item->hari_belajar }}</div>
                            <div class="col-6"><i class="fas fa-clock me-1"></i> {{ $item->waktu_belajar }}</div>
                            <div class="col-12"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->tempat_belajar }}</div>
                        </div>
                        @if($quotaFull)
                            <button class="btn btn-secondary btn-sm w-100" disabled>Kuota Penuh</button>
                        @else
                            <a href="/isi-form/{{ $item->id }}" class="btn btn-success btn-sm w-100">Daftar Sekarang</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        @foreach($syariah as $item)
        <div class="col-lg-4 col-md-6 col-12 mb-3">
            <div class="card h-100">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <span class="badge bg-danger">Ulum Asy-Syariah</span>
                        <span class="text-muted small">
                            <i class="fas fa-users me-1"></i>
                            {{ $item->santri->count() }} pendaftar
                        </span>
                    </div>
                    <h5 class="card-title fw-bold mb-1">{{ $item->nama_program }}</h5>
                    <p class="text-muted small mb-2">{{ $item->persyaratan }}</p>
                    <div class="mt-auto">
                        <div class="row text-muted small mb-2">
                            <div class="col-6"><i class="fas fa-calendar me-1"></i> {{ $item->hari_belajar }}</div>
                            <div class="col-6"><i class="fas fa-clock me-1"></i> {{ $item->waktu_belajar }}</div>
                            <div class="col-12"><i class="fas fa-map-marker-alt me-1"></i> {{ $item->tempat_belajar }}</div>
                        </div>
                        @if($quotaFull)
                            <button class="btn btn-secondary btn-sm w-100" disabled>Kuota Penuh</button>
                        @else
                            <a href="/isi-form/{{ $item->id }}" class="btn btn-success btn-sm w-100">Daftar Sekarang</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection