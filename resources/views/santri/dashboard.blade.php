@extends('layouts.app')

@section('content')
<x-breadcrumb title="Dashboard" parent="Dashboard" parentLink="#" current="Dashboard" />

<div class="content-body">
@use('\App\Helpers\TanggalHelper', 'TanggalHelper')

<div class="row">
    <div class="col-12">
        <h4 class="mb-1">Selamat Datang, {{ Auth::user()->nama ?? 'Calon Santri' }}!</h4>
        <p class="text-muted">Berikut status pendaftaran dan informasi penting untuk Anda.</p>
    </div>
</div>

@if(!$santri)
<div class="alert alert-warning">
    <i class="ti ti-alert-triangle me-2"></i>
    <strong>Perhatian!</strong> Data pendaftaran Anda belum ditemukan. Silakan hubungi admin.
</div>
@endif

<div class="row">
    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Status Pendaftaran</h6>
                    @if($santri)
                        @if($santri->status_pendaftaran == 'Menunggu')
                            <span class="badge bg-warning">Menunggu</span>
                        @elseif($santri->status_pendaftaran == 'Diterima')
                            <span class="badge bg-success">Diterima</span>
                        @else
                            <span class="badge bg-danger">Ditolak</span>
                        @endif
                    @endif
                </div>
                @if($santri)
                    <p class="mb-1"><small class="text-muted">No. Registrasi:</small></p>
                    <p class="mb-0"><strong><code>{{ $santri->kode_registrasi }}</code></strong></p>

                    @if($santri->status_pendaftaran == 'Ditolak' && $santri->alasan_penolakan)
                    <div class="alert alert-danger py-2 mt-2 mb-0">
                        <small><strong>Alasan:</strong> {{ $santri->alasan_penolakan }}</small>
                    </div>
                    @endif
                @else
                    <p class="mb-0 text-muted">-</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Program</h6>
                    <i class="ti ti-book"></i>
                </div>
                @if($santri && $santri->program)
                    <p class="mb-1"><strong>{{ $santri->program->nama_program }}</strong></p>
                    <p class="mb-0 text-muted">{{ $santri->tahun_psb }}</p>
                @else
                    <p class="mb-0 text-muted">Belum memilih program</p>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6 mb-3">
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="mb-0">Status Pembayaran</h6>
                    <i class="ti ti-credit-card"></i>
                </div>
                @if($santri)
                    @if($santri->status_transfer == 'Valid')
                        <span class="badge bg-success mb-2">LUNAS</span>
                        <p class="mb-0 text-muted">Rp {{ number_format($santri->nominal_transfer ?? 0, 0, ',', '.') }}</p>
                    @elseif($santri->status_transfer == 'Cek')
                        <span class="badge bg-warning mb-2">SEDANG DIVERIFIKASI</span>
                        <p class="mb-0 text-muted">Nominal: Rp {{ number_format($santri->nominal_transfer ?? 0, 0, ',', '.') }}</p>
                    @elseif($santri->status_transfer == 'Invalid')
                        <span class="badge bg-danger mb-2">TIDAK VALID</span>
                        <p class="mb-0 text-muted">Total: Rp {{ number_format($biayaPendaftaran, 0, ',', '.') }}</p>
                        @if($santri->alasan_penolakan)
                        <div class="alert alert-danger py-2 mt-2 mb-0">
                            <small><strong>Catatan:</strong> {{ $santri->alasan_penolakan }}</small>
                        </div>
                        @endif
                        <a href="{{ route('revisi-berkas', $santri->kode_registrasi) }}" class="btn btn-warning btn-sm mt-2">
                            <i class="ti ti-upload me-1"></i> Revisi Berkas
                        </a>
                    @else
                        <span class="badge bg-secondary mb-2">BELUM UPLOAD</span>
                        <p class="mb-0 text-muted">Total: Rp {{ number_format($biayaPendaftaran, 0, ',', '.') }}</p>
                    @endif
                @else
                    <p class="mb-0 text-muted">-</p>
                @endif
            </div>
        </div>
    </div>
</div>

@if($santri && $santri->status_pendaftaran == 'Diterima')
<div class="row">
    <div class="col-12 mb-3">
        <div class="card bg-success bg-opacity-10 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="ti ti-circle-check text-success me-3" style="font-size: 2rem;"></i>
                    <div>
                        <h5 class="mb-1 text-success">Selamat! Pendaftaran Anda Diterima</h5>
                        <p class="mb-0 text-muted">Silakan cetak formulir F2 untuk referensi Anda.</p>
                    </div>
                    <div class="ms-auto">
                        <a href="{{ route('peserta::formulir', $santri->kode_registrasi) }}" class="btn btn-success" target="_blank">
                            <i class="ti ti-printer me-2"></i> Cetak F2
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<div class="row">
    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0">
                        <i class="ti ti-bell me-2"></i> Notifikasi
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-1">{{ $unreadCount }} baru</span>
                        @endif
                    </h6>
                    @if($unreadCount > 0)
                        <a href="{{ route('peserta::notification.readAll') }}" class="btn btn-sm btn-outline-primary">
                            Tandai semua dibaca
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body p-0">
                @if($notifications->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($notifications as $notif)
                            <div class="list-group-item {{ $notif->is_read ? '' : 'bg-light' }}">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div class="me-auto">
                                        <p class="mb-1 {!! $notif->is_read ? 'text-muted' : 'fw-bold' !!}">
                                            {{ $notif->title }}
                                        </p>
                                        <p class="mb-0 text-muted small">{{ $notif->message }}</p>
                                        <small class="text-muted">{{ TanggalHelper::konversiTanggal($notif->created_at) }}</small>
                                    </div>
                                    @if(!$notif->is_read)
                                        <a href="{{ route('peserta::notification.read', $notif->id) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="ti ti-check"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="card-footer">
                        {{ $notifications->links() }}
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="ti ti-bell-off" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">Tidak ada notifikasi</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-6 mb-3">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">
                    <i class="ti ti-info-circle me-2"></i> Informasi Penting
                </h6>
            </div>
            <div class="card-body">
                <div class="alert alert-info mb-0">
                    <h6 class="alert-heading"><i class="ti ti-calendar me-2"></i> Biaya Pendidikan</h6>
                    <hr class="my-2">
                    <p class="mb-1">Biaya Pendaftaran : <strong>Rp {{ number_format($biayaPendaftaran, 0, ',', '.') }}</strong></p>
                    @if($santri && $santri->tahun_psb)
                        @php
                            $infoPsb = \App\Models\InfoPsb::where('tahun_ajaran', $santri->tahun_psb)->first();
                        @endphp
                        @if($infoPsb)
                            <p class="mb-1">Sarana Prasarana : <strong>Rp {{ number_format($infoPsb->biaya_sarana_prasana ?? 300000, 0, ',', '.') }}</strong></p>
                            {{-- <p class="mb-1">Kuliah Perdana : <strong>Rp {{ number_format($infoPsb->biaya_kuliah_perdana ?? 250000, 0, ',', '.') }}</strong></p> --}}
                            <p class="mb-0">SPP Bulanan : <strong>Rp {{ number_format($infoPsb->biaya_spp_bulanan ?? 250000, 0, ',', '.') }}</strong></p>
                        @endif
                    @endif
                </div>

                @if($santri && $santri->status_pendaftaran == 'Menunggu')
                <div class="alert alert-warning mt-3 mb-0">
                    <p class="mb-2"><strong>Langkah selanjutnya:</strong></p>
                    <ol class="mb-0 ps-3">
                        <li>Upload bukti pembayaran jika belum</li>
                        <li>Tunggu verifikasi dari admin</li>
                        <li>Setelah diterima, cetak F2 formulir</li>
                    </ol>
                </div>
                @endif

                @if(!$santri)
                <div class="alert alert-secondary mt-3 mb-0">
                    <p class="mb-0">
                        <i class="ti ti-info-circle me-2"></i>
                        Jika Anda belum terdaftar sebagai peserta PSB, silakan hubungi admin untuk informasi lebih lanjut.
                    </p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
@endsection
