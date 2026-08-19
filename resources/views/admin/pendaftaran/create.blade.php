@extends('layouts.dashboard.master')

@section('content')

<x-links.breadcrumb>
    <x-slot:judul_halaman>Pendaftaran</x-slot:judul_halaman>
    <x-slot:halaman_aktif>Tambah Pendaftaran Susulan</x-slot:halaman_aktif>
</x-links.breadcrumb>

<div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
    <i class="ti ti-alert-circle me-2"></i>
    <div>
        <strong>Mode Susulan.</strong> Anda sedang membuat pendaftaran baru atas nama calon pendaftar.
        Fitur ini digunakan saat pendaftaran sudah ditutup atau kuota tambahan dibuka.
        Tahun ajaran aktif: <strong>{{ $psb ? $psb->tahun_ajaran : '-' }}</strong>.
        @if($psb && !$psb->isOpen())
            <br><span class="text-danger">PSB sedang TUTUP, tapi Anda sebagai admin tetap bisa membuat pendaftaran melalui halaman ini.</span>
        @endif
    </div>
</div>

@if ($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Validasi gagal:</strong>
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<form method="POST" action="{{ route('admin::pendaftaran.store') }}">
    @csrf

    <div class="row">
        <div class="col-md-6">
            <x-cards.basic-card>
                <x-slot:cardHeader>Data Pribadi</x-slot:cardHeader>

                <div class="mb-3">
                    <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}" required>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select name="jk" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Laki-Laki" {{ old('jk') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki (Ikhwan)</option>
                            <option value="Perempuan" {{ old('jk') == 'Perempuan' ? 'selected' : '' }}>Perempuan (Akhwat)</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Program <span class="text-danger">*</span></label>
                        <select name="program_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($programs as $prog)
                                <option value="{{ $prog->id }}" {{ old('program_id') == $prog->id ? 'selected' : '' }}>
                                    {{ $prog->nama_program }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NIK</label>
                        <input type="text" name="nik" class="form-control" value="{{ old('nik') }}" maxlength="20">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">NISN</label>
                        <input type="text" name="nisn" class="form-control" value="{{ old('nisn') }}" maxlength="20">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tempat Lahir</label>
                        <input type="text" name="tmp_lahir" class="form-control" value="{{ old('tmp_lahir') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Tanggal Lahir</label>
                        <input type="date" name="tgl_lahir" class="form-control" value="{{ old('tgl_lahir') }}">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="alamat" class="form-control" rows="2">{{ old('alamat') }}</textarea>
                </div>
            </x-cards.basic-card>
        </div>

        <div class="col-md-6">
            <x-cards.basic-card>
                <x-slot:cardHeader>Kontak</x-slot:cardHeader>

                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="(opsional, jika kosong akan dibuat otomatis)">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Kode Negara</label>
                        <select name="kode_negara" class="form-select">
                            <option value="62" {{ old('kode_negara', '62') == '62' ? 'selected' : '' }}>+62</option>
                            <option value="60" {{ old('kode_negara') == '60' ? 'selected' : '' }}>+60</option>
                            <option value="65" {{ old('kode_negara') == '65' ? 'selected' : '' }}>+65</option>
                            <option value="966" {{ old('kode_negara') == '966' ? 'selected' : '' }}>+966</option>
                        </select>
                    </div>
                    <div class="col-md-8 mb-3">
                        <label class="form-label">No. WhatsApp <span class="text-danger">*</span></label>
                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="81234567890" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Pendidikan Terakhir</label>
                    <input type="text" name="pendidikan" class="form-control" value="{{ old('pendidikan', 'SMA') }}" placeholder="contoh: SMA, MA, Pondok">
                </div>

                <div class="mb-3">
                    <label class="form-label">Pekerjaan</label>
                    <select name="pekerjaan_id" class="form-select">
                        <option value="">-- Pilih --</option>
                        @foreach($pekerjaans as $pk)
                            <option value="{{ $pk->id }}" {{ old('pekerjaan_id') == $pk->id ? 'selected' : '' }}>
                                {{ $pk->nama_pekerjaan }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </x-cards.basic-card>

            <x-cards.basic-card>
                <x-slot:cardHeader>Orang Tua / Wali</x-slot:cardHeader>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Ayah</label>
                        <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. HP Ayah</label>
                        <input type="text" name="no_hp_ayah" class="form-control" value="{{ old('no_hp_ayah') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Ibu</label>
                        <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. HP Ibu</label>
                        <input type="text" name="no_hp_ibu" class="form-control" value="{{ old('no_hp_ibu') }}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Wali</label>
                        <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali') }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">No. HP Wali</label>
                        <input type="text" name="no_hp_wali" class="form-control" value="{{ old('no_hp_wali') }}">
                    </div>
                </div>
            </x-cards.basic-card>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <x-cards.basic-card>
                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin::pendaftaran.index') }}" class="btn btn-light">
                        <i class="ti ti-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-device-floppy"></i> Simpan Pendaftaran Susulan
                    </button>
                </div>
            </x-cards.basic-card>
        </div>
    </div>
</form>

@endsection
