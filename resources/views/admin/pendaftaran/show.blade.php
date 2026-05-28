@extends('layouts.dashboard.master')

@section('content')
@use('\App\Helpers\TanggalHelper', 'TanggalHelper')

<x-links.breadcrumb>
    <x-slot:judul_halaman>Detail Pendaftaran</x-slot:judul_halaman>
    <x-slot:halaman_aktif>{{ $santri->kode_registrasi }}</x-slot:halaman_aktif>
</x-links.breadcrumb>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-md-4">
        <x-cards.basic-card>
            <x-slot:cardHeader>Status Pendaftaran</x-slot:cardHeader>
            <div class="text-center mb-3">
                @if($santri->status_pendaftaran == 'Menunggu')
                    <x-items.glow-badge content="Menunggu" color="warning"/>
                @elseif($santri->status_pendaftaran == 'Diterima')
                    <x-items.glow-badge content="DITERIMA" color="success"/>
                @else
                    <x-items.glow-badge content="DITOLAK" color="danger"/>
                @endif
            </div>

            @if($santri->status_pendaftaran == 'Ditolak' && $santri->alasan_penolakan)
            <div class="alert alert-danger py-2">
                <small><strong>Alasan:</strong> {{ $santri->alasan_penolakan }}</small>
            </div>
            @endif

            @if($santri->tgl_verifikasi)
            <p class="mb-1"><small class="text-muted">Tgl Verifikasi:</small></p>
            <p class="mb-0">{{ TanggalHelper::konversiTanggalPenuh($santri->tgl_verifikasi) }}</p>
            @endif
        </x-cards.basic-card>

        <x-cards.basic-card>
            <x-slot:cardHeader>Informasi Akun</x-slot:cardHeader>
            <p class="mb-1"><small class="text-muted">Username:</small></p>
            <p class="mb-1"><code>{{ $santri->user?->email ?? '-' }}</code></p>
            <p class="mb-1"><small class="text-muted">Status Akun:</small></p>
            <p class="mb-0">
                @if($santri->user?->is_active)
                    <x-items.light-badge content="Aktif" color="success"/>
                @else
                    <x-items.light-badge content="Nonaktif" color="secondary"/>
                @endif
            </p>
        </x-cards.basic-card>

        @if($santri->status_pendaftaran == 'Menunggu')
        <div class="d-grid gap-2">
            <form action="{{ route('admin::pendaftaran.approve', $santri->kode_registrasi) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-success btn-lg w-100" onclick="return confirm('Terima pendaftaran ini?')">
                    <i class="ti ti-check me-2"></i> TERIMA PENDAFTARAN
                </button>
            </form>
            <button type="button" class="btn btn-danger btn-lg w-100" data-bs-toggle="modal" data-bs-target="#rejectModal">
                <i class="ti ti-x me-2"></i> TOLAK PENDAFTARAN
            </button>
        </div>

        <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('admin::pendaftaran.reject', $santri->kode_registrasi) }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Pendaftaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan</label>
                                <textarea name="alasan" class="form-control" rows="3" required placeholder="Masukkan alasan penolakan..."></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-danger">Tolak Pendaftaran</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        @endif

        <div class="d-grid gap-2 mt-2">
            <a href="{{ route('admin::pendaftaran.index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="col-md-8">
        <x-cards.basic-card>
            <x-slot:cardHeader>Data Diri</x-slot:cardHeader>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><small class="text-muted">No. Registrasi</small></p>
                    <p class="mb-2"><strong><code>{{ $santri->kode_registrasi }}</code></strong></p>

                    <p class="mb-1"><small class="text-muted">Nama Lengkap</small></p>
                    <p class="mb-2">{{ $santri->nama }}</p>

                    <p class="mb-1"><small class="text-muted">NIK</small></p>
                    <p class="mb-2">{{ $santri->nik ?? '-' }}</p>

                    <p class="mb-1"><small class="text-muted">NISN</small></p>
                    <p class="mb-2">{{ $santri->nisn ?? '-' }}</p>

                    <p class="mb-1"><small class="text-muted">Jenis Kelamin</small></p>
                    <p class="mb-2">{{ $santri->jk == 'Laki-Laki' ? 'Ikhwan' : 'Akhwat' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><small class="text-muted">Tempat, Tgl Lahir</small></p>
                    <p class="mb-2">{{ $santri->tmp_lahir }}, {{ $santri->tgl_lahir ? TanggalHelper::konversiTanggal($santri->tgl_lahir) : '-' }}</p>

                    <p class="mb-1"><small class="text-muted">Alamat</small></p>
                    <p class="mb-2">{{ $santri->alamat ?? '-' }}</p>

                    <p class="mb-1"><small class="text-muted">Email</small></p>
                    <p class="mb-2">{{ $santri->email ?? '-' }}</p>

                    <p class="mb-1"><small class="text-muted">No. HP</small></p>
                    <p class="mb-2">{{ $santri->hp ?? '-' }}</p>
                </div>
            </div>
        </x-cards.basic-card>

        <x-cards.basic-card>
            <x-slot:cardHeader>Data Orang Tua / Wali</x-slot:cardHeader>
            <div class="row">
                <div class="col-md-4">
                    <p class="mb-1"><small class="text-muted">Nama Ayah</small></p>
                    <p class="mb-2">{{ $santri->nama_ayah ?? '-' }}</p>

                    <p class="mb-1"><small class="text-muted">No. HP Ayah</small></p>
                    <p class="mb-2">{{ $santri->no_hp_ayah ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><small class="text-muted">Nama Ibu</small></p>
                    <p class="mb-2">{{ $santri->nama_ibu ?? '-' }}</p>

                    <p class="mb-1"><small class="text-muted">No. HP Ibu</small></p>
                    <p class="mb-2">{{ $santri->no_hp_ibu ?? '-' }}</p>
                </div>
                <div class="col-md-4">
                    <p class="mb-1"><small class="text-muted">Nama Wali</small></p>
                    <p class="mb-2">{{ $santri->nama_wali ?? '-' }}</p>

                    <p class="mb-1"><small class="text-muted">No. HP Wali</small></p>
                    <p class="mb-2">{{ $santri->no_hp_wali ?? '-' }}</p>
                </div>
            </div>
        </x-cards.basic-card>

        <x-cards.basic-card>
            <x-slot:cardHeader>Program & Pembayaran</x-slot:cardHeader>
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-1"><small class="text-muted">Program</small></p>
                    <p class="mb-2"><strong>{{ $santri->program?->nama_program ?? '-' }}</strong></p>

                    <p class="mb-1"><small class="text-muted">Tahun PSB</small></p>
                    <p class="mb-2">{{ $santri->tahun_psb }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-1"><small class="text-muted">Nominal Transfer</small></p>
                    <p class="mb-2">Rp {{ number_format($santri->nominal_transfer ?? 0, 0, ',', '.') }}</p>

                    <p class="mb-1"><small class="text-muted">Status Transfer</small></p>
                    <p class="mb-2">
                        @if($santri->status_transfer == 'Valid')
                            <x-items.light-badge content="Valid" color="success"/>
                        @elseif($santri->status_transfer == 'Cek')
                            <x-items.light-badge content="Proses" color="warning"/>
                        @else
                            <x-items.light-badge content="Invalid" color="danger"/>
                        @endif
                    </p>
                </div>
            </div>
        </x-cards.basic-card>

        <x-cards.basic-card>
            <x-slot:cardHeader>Dokumen</x-slot:cardHeader>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <p class="mb-1"><small class="text-muted">KTP</small></p>
                    @if($santri->ktp)
                        <a href="{{ asset('berkas/' . $santri->tahun_psb . '/' . $santri->kode_registrasi . '/' . $santri->ktp) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-file"></i> Lihat
                        </a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <p class="mb-1"><small class="text-muted">Foto</small></p>
                    @if($santri->photo)
                        <a href="{{ asset('berkas/' . $santri->tahun_psb . '/' . $santri->kode_registrasi . '/' . $santri->photo) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-file"></i> Lihat
                        </a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <p class="mb-1"><small class="text-muted">Ijazah</small></p>
                    @if($santri->ijazah)
                        <a href="{{ asset('berkas/' . $santri->tahun_psb . '/' . $santri->kode_registrasi . '/' . $santri->ijazah) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-file"></i> Lihat
                        </a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
                <div class="col-md-3 mb-3">
                    <p class="mb-1"><small class="text-muted">Bukti Bayar</small></p>
                    @if($santri->transfer)
                        <a href="{{ asset('berkas/' . $santri->tahun_psb . '/' . $santri->kode_registrasi . '/' . $santri->transfer) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="ti ti-file"></i> Lihat
                        </a>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </div>
            </div>
        </x-cards.basic-card>
    </div>
</div>
@endsection
