@extends('layouts.dashboard.master')

@section('content')
@use('\App\Helpers\TanggalHelper', 'TanggalHelper')

<x-links.breadcrumb>
    <x-slot:judul_halaman>Pendaftaran</x-slot:judul_halaman>
    <x-slot:halaman_aktif>Manajemen Pendaftaran Santri Baru</x-slot:halaman_aktif>
</x-links.breadcrumb>

@if (session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Berhasil!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-12">
        <x-cards.basic-card>
            <x-slot:cardHeader>
                <div class="d-flex justify-content-between align-items-center">
                    <span>Data Pendaftaran PSB</span>
                    <span class="badge bg-primary">{{ $stats['total'] }} Total</span>
                </div>
            </x-slot:cardHeader>

            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex flex-wrap gap-2">
                        <x-items.light-badge content="Menunggu : {{ $stats['menunggu'] }}" color="warning"/>
                        <x-items.light-badge content="Diterima : {{ $stats['diterima'] }}" color="success"/>
                        <x-items.light-badge content="Ditolak : {{ $stats['ditolak'] }}" color="danger"/>
                    </div>
                </div>
            </div>

            <form method="GET" action="{{ route('admin::pendaftaran.index') }}" class="mb-3">
                <div class="row g-2">
                    <div class="col-md-2">
                        <select name="tahun" class="form-select">
                            @foreach($tahunAjaran as $tahun)
                                <option value="{{ $tahun->tahun_ajaran }}" {{ $tahunPsb == $tahun->tahun_ajaran ? 'selected' : '' }}>
                                    {{ $tahun->tahun_ajaran }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Menunggu" {{ $status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                            <option value="Diterima" {{ $status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Ditolak" {{ $status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="program" class="form-select">
                            <option value="">Semua Program</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}" {{ $program == $prog->id ? 'selected' : '' }}>
                                    {{ $prog->nama_program }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="jk" class="form-select">
                            <option value="">Semua Gender</option>
                            <option value="Laki-Laki" {{ $jk == 'Laki-Laki' ? 'selected' : '' }}>Ikhwan</option>
                            <option value="Perempuan" {{ $jk == 'Perempuan' ? 'selected' : '' }}>Akhwat</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau kode..." value="{{ $search }}">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="ti ti-search"></i>
                        </button>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-hover table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Program</th>
                            <th>JK</th>
                            <th>Status Daftar</th>
                            <th>Status Bayar</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendaftar as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><code>{{ $p->kode_registrasi }}</code></td>
                                <td>{{ $p->nama }}</td>
                                <td>{{ $p->program?->nama_program ?? '-' }}</td>
                                <td>{{ $p->jk == 'Laki-Laki' ? 'Ikhwan' : 'Akhwat' }}</td>
                                <td>
                                    @if($p->status_pendaftaran == 'Menunggu')
                                        <x-items.light-badge content="Menunggu" color="warning"/>
                                    @elseif($p->status_pendaftaran == 'Diterima')
                                        <x-items.light-badge content="Diterima" color="success"/>
                                    @else
                                        <x-items.light-badge content="Ditolak" color="danger"/>
                                    @endif
                                </td>
                                <td>
                                    @if($p->status_transfer == 'Valid')
                                        <x-items.light-badge content="Valid" color="success"/>
                                    @elseif($p->status_transfer == 'Cek')
                                        <x-items.light-badge content="Proses" color="warning"/>
                                    @else
                                        <x-items.light-badge content="Invalid" color="danger"/>
                                    @endif
                                </td>
                                <td>{{ TanggalHelper::konversiTanggal($p->created_at) }}</td>
                                <td>
                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin::pendaftaran.show', $p->kode_registrasi) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @if($p->status_pendaftaran == 'Menunggu')
                                            <form action="{{ route('admin::pendaftaran.approve', $p->kode_registrasi) }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-success" onclick="return confirm('Terima pendaftaran ini?')">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                            </form>
                                            <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $p->id }}">
                                                <i class="ti ti-x"></i>
                                            </button>

                                            <div class="modal fade" id="rejectModal{{ $p->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <form action="{{ route('admin::pendaftaran.reject', $p->kode_registrasi) }}" method="POST">
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
                                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endif
                                        <form action="{{ route('admin::pendaftaran.destroy', $p->kode_registrasi) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-dark" onclick="return confirm('Hapus data ini?')">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">Tidak ada data pendaftaran</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $pendaftar->withQueryString()->links() }}
            </div>
        </x-cards.basic-card>
    </div>
</div>
@endsection
