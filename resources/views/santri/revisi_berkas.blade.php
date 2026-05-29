@extends('layouts.registrasi.main')

@push('vendorCss')
<link rel="stylesheet" href="{{ asset('dashboard-assets/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard-assets/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard-assets/assets/vendor/libs/select2/select2.css') }}" />
@endpush

@section('content')
<h4 class="fw-bold py-1 mb-2">
    <span class="text-muted fw-light">
        <a href="/cari-nama">
        < Kembali
        </a>
    </span>
</h4>

@if(session('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <i class="ti ti-check me-2"></i> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <i class="ti ti-alert-circle me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-0">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center flex-column">
                        <div class="user-avatar-section text-center w-100">
                            <h4 class="mb-2">{{ $santri->nama }}</h4>
                            <span class="badge bg-label-secondary mt-1">{{ $santri->kode_registrasi }}</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4">
                        <div class="d-flex align-items-start me-4 mt-3 gap-2">
                            <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-checkbox ti-sm"></i></span>
                            <div>
                                <p class="mb-0 fw-semibold">{{ $santri->program->nama_program ?? '-' }}</p>
                                <small>Program Pilihan</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Status Pendaftaran</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $santri->status_pendaftaran == 'Diterima' ? 'success' : ($santri->status_pendaftaran == 'Ditolak' ? 'danger' : 'warning') }} p-2 me-2">
                                    <i class="ti ti-{{ $santri->status_pendaftaran == 'Diterima' ? 'circle-check' : ($santri->status_pendaftaran == 'Ditolak' ? 'x' : 'clock') }} ti-sm"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Status Pendaftaran</small>
                                    <strong>{{ $santri->status_pendaftaran }}</strong>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $santri->status_transfer == 'Valid' ? 'success' : ($santri->status_transfer == 'Invalid' ? 'danger' : 'warning') }} p-2 me-2">
                                    <i class="ti ti-{{ $santri->status_transfer == 'Valid' ? 'circle-check' : ($santri->status_transfer == 'Invalid' ? 'x' : 'clock') }} ti-sm"></i>
                                </span>
                                <div>
                                    <small class="text-muted d-block">Status Transfer</small>
                                    <strong>{{ $santri->status_transfer ?? 'Menunggu' }}</strong>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($santri->status_pendaftaran == 'Ditolak' && $santri->alasan_penolakan)
                    <div class="alert alert-danger mt-3">
                        <i class="ti ti-alert-circle me-2"></i>
                        <strong>Pesan dari Admin:</strong><br>
                        {{ $santri->alasan_penolakan }}
                    </div>
                    @endif

                    @if($santri->status_transfer == 'Invalid' && $santri->alasan_penolakan)
                    <div class="alert alert-danger mt-3">
                        <i class="ti ti-alert-circle me-2"></i>
                        <strong>Catatan dari Admin:</strong><br>
                        {{ $santri->alasan_penolakan }}
                    </div>
                    @endif
                </div>
            </div>

            @if($santri->status_transfer == 'Invalid' || $santri->status_transfer == 'Cek')
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        @if($santri->status_transfer == 'Invalid')
                        <i class="ti ti-upload me-2"></i>Upload Ulang Dokumen
                        @else
                        <i class="ti ti-file-info me-2"></i>Dokumen Anda Sedang Diproses
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if($santri->status_transfer == 'Invalid')
                    <p class="text-muted mb-3">Silakan upload ulang dokumen yang diperlukan. Pastikan file sesuai format dan ukuran yang ditentukan.</p>

                    <form method="POST" action="/revisi-berkas/{{ $santri->kode_registrasi }}" enctype="multipart/form-data" id="form-revisi">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="foto">Foto 4x6 <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="foto" name="foto" accept="image/jpeg,image/png" />
                                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ktp">KTP/Kartu Identitas <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('ktp') is-invalid @enderror" id="ktp" name="ktp" accept="image/jpeg,image/png,application/pdf" />
                                <small class="text-muted">Format: JPG, PNG, PDF. Maksimal 2MB</small>
                                @error('ktp')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="ijazah">Ijazah SMA/Sederajat <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('ijazah') is-invalid @enderror" id="ijazah" name="ijazah" accept="image/jpeg,image/png,application/pdf" />
                                <small class="text-muted">Format: JPG, PNG, PDF. Maksimal 5MB</small>
                                @error('ijazah')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="bukti_pembayaran">Bukti Pembayaran <span class="text-danger">*</span></label>
                                <input type="file" class="form-control @error('bukti_pembayaran') is-invalid @enderror" id="bukti_pembayaran" name="bukti_pembayaran" accept="image/jpeg,image/png" />
                                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>
                                @error('bukti_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary" id="btn-submit">
                                <i class="ti ti-upload me-2"></i> Simpan Perubahan
                            </button>
                            <a href="/cari-nama" class="btn btn-secondary ms-2">
                                Batal
                            </a>
                        </div>
                    </form>
                    @else
                    <div class="text-center py-4">
                        <i class="ti ti-clock text-warning" style="font-size: 3rem;"></i>
                        <p class="mt-2 mb-0">Dokumen Anda sedang dalam proses verifikasi oleh admin.</p>
                        <p class="text-muted">Silakan tunggu informasi lebih lanjut.</p>
                    </div>
                    @endif
                </div>
            </div>
            @elseif($santri->status_transfer == 'Valid')
            <div class="card bg-opacity-10 border-success">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <i class="ti ti-circle-check text-success me-3" style="font-size: 2rem;"></i>
                        <div>
                            <h5 class="mb-1 text-success">Pendaftaran Anda Sudah Valid!</h5>
                            <p class="mb-0 text-muted">Dokumen sudah diverifikasi. Silakan tunggu informasi selanjutnya.</p>
                        </div>
                    </div>
                    @if($linkGroup)
                    <hr class="my-3">
                    <div class="d-flex align-items-center mt-3">
                        <div class="avatar avatar-xl bg-primary rounded-circle me-3">
                            <i class="ti ti-users" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <h6 class="mb-1 text-primary">Bergabung ke Group Komunikasi</h6>
                            <p class="mb-0 text-muted small">Segera bergabung ke group untuk informasi penting lainnya.</p>
                        </div>
                        <div class="ms-auto">
                            <a href="{{ $linkGroup }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="ti ti-brand-whatsapp me-2"></i> Bergabung
                            </a>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('vendorScript')
<script src="{{ asset('dashboard/assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('pageScript')
<script>
    document.getElementById('form-revisi').addEventListener('submit', function(event) {
        var submitBtn = document.getElementById('btn-submit');
        if (submitBtn.classList.contains('submitted')) {
            event.preventDefault();
        } else {
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Memproses...';
            submitBtn.classList.add('submitted');
        }
    });
</script>
@endpush