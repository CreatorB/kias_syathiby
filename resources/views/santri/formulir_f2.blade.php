@extends('layouts.dashboard.master')

@section('content')
@use('\App\Helpers\TanggalHelper', 'TanggalHelper')

<div class="row mb-3">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center">
            <a href="{{ route('peserta::index') }}" class="btn btn-outline-secondary">
                <i class="ti ti-arrow-left me-2"></i> Kembali
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="ti ti-printer me-2"></i> Cetak
            </button>
        </div>
    </div>
</div>

<style>
@media print {
    body { font-size: 12px; }
    .no-print { display: none !important; }
    .card { border: 2px solid #000 !important; box-shadow: none !important; }
    .page-break { page-break-after: always; }
}
</style>

<div class="row">
    <div class="col-12">
        <div class="card" style="border: 2px solid #000;">
            <div class="card-body">
                <div class="text-center mb-4" style="border-bottom: 2px solid #000; padding-bottom: 20px;">
                    <h4 class="mb-1"><strong>FORMULIR PENDAFTARAN F2</strong></h4>
                    <p class="mb-0"><strong>TAHUN AJARAN {{ $santri->tahun_psb }}</strong></p>
                    <p class="mb-0 text-muted">Lembaga Pendidikan Takhassus Al Barkah</p>
                </div>

                <div class="row mt-4">
                    <div class="col-md-6">
                        <h6 class="text-uppercase fw-bold mb-3" style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                            <i class="ti ti-user me-2"></i> Data Diri
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%">No. Registrasi</td>
                                <td><strong>{{ $santri->kode_registrasi }}</strong></td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td><strong>{{ strtoupper($santri->nama) }}</strong></td>
                            </tr>
                            <tr>
                                <td>NIK</td>
                                <td>{{ $santri->nik ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td>{{ $santri->nisn ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>{{ $santri->jk == 'Laki-Laki' ? 'Ikhwan (Laki-laki)' : 'Akhwat (Perempuan)' }}</td>
                            </tr>
                            <tr>
                                <td>Tempat, Tgl Lahir</td>
                                <td>{{ $santri->tmp_lahir }}, {{ $santri->tgl_lahir ? TanggalHelper::konversiTanggal($santri->tgl_lahir) : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat</td>
                                <td>{{ $santri->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>{{ $santri->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>No. HP</td>
                                <td>{{ $santri->hp ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-uppercase fw-bold mb-3" style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                            <i class="ti ti-users me-2"></i> Data Orang Tua / Wali
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%">Nama Ayah</td>
                                <td>{{ $santri->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>No. HP Ayah</td>
                                <td>{{ $santri->no_hp_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Nama Ibu</td>
                                <td>{{ $santri->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>No. HP Ibu</td>
                                <td>{{ $santri->no_hp_ibu ?? '-' }}</td>
                            </tr>
                            @if($santri->nama_wali)
                            <tr>
                                <td>Nama Wali</td>
                                <td>{{ $santri->nama_wali }}</td>
                            </tr>
                            <tr>
                                <td>No. HP Wali</td>
                                <td>{{ $santri->no_hp_wali ?? '-' }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="text-uppercase fw-bold mb-3" style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                            <i class="ti ti-book me-2"></i> Program
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%">Program Pilihan</td>
                                <td><strong>{{ $santri->program?->nama_program ?? '-' }}</strong></td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <h6 class="text-uppercase fw-bold mb-3" style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                            <i class="ti ti-credit-card me-2"></i> Pembayaran
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="40%">Biaya Pendaftaran</td>
                                <td><strong>Rp {{ number_format($santri->nominal_transfer ?? $infoPsb?->biaya_pendaftaran ?? 150000, 0, ',', '.') }}</strong></td>
                            </tr>
                            <tr>
                                <td>Status</td>
                                <td><span class="badge bg-success">LUNAS</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="text-uppercase fw-bold mb-3" style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                            <i class="ti ti-checkup-list me-2"></i> Konfirmasi Penerimaan
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="20%">Tanggal Verifikasi</td>
                                <td>{{ $santri->tgl_verifikasi ? TanggalHelper::konversiTanggalPenuh($santri->tgl_verifikasi) : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Status Pendaftaran</td>
                                <td><span class="badge bg-success" style="font-size: 1rem;">DITERIMA</span></td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="text-uppercase fw-bold mb-3" style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                            <i class="ti ti-calendar-event me-2"></i> Alur Tes Masuk
                        </h6>
                        <div class="alert alert-secondary mb-0">
                            <ol class="mb-0 ps-3">
                                <li class="mb-2"><strong>Tes Tulis:</strong> Tanggal akan diinformasikan kemudian via WhatsApp</li>
                                <li class="mb-2"><strong>Wawancara:</strong> Tanggal akan diinformasikan kemudian via WhatsApp</li>
                                <li><strong>Pengumuman Hasil:</strong> Tanggal akan diinformasikan kemudian via WhatsApp</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12">
                        <h6 class="text-uppercase fw-bold mb-3" style="border-bottom: 1px solid #ccc; padding-bottom: 5px;">
                            <i class="ti ti-phone me-2"></i> Committee Contact
                        </h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td width="20%">Contact Person</td>
                                <td>Panitia PSB KIAS</td>
                            </tr>
                            <tr>
                                <td>WhatsApp</td>
                                <td>Akan diinformasikan kemudian</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>-</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-12 text-center">
                        <p class="text-muted mb-0">
                            <small>
                                Dicetak pada: {{ now()->format('d F Y H:i:s') }} |
                                Formulir ini adalah bukti pendaftaran yang sah. Simpan dokumen ini dengan baik.
                            </small>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
