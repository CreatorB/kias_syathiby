@extends('layouts.landing.page')

@section('content')
    <!--page title start-->
    <section class="page-title" data-bg-img="{{ asset('landing/images/bg/03.png') }}">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="title">{{ $event->title }}</h1>
                    <h4 class="text-white mt-2"><span class="badge bg-warning text-dark"><i class="fas fa-lock me-1"></i>
                            Pendaftaran Jalur Khusus/Internal</span></h4>
                    <p class="text-white mt-2">Link: {{ $internalLink->name }}</p>
                </div>
            </div>
        </div>
    </section>
    <!--page title end-->

    <!--event detail section start-->
    <section class="event-detail-section">
        <div class="container">
            <div class="row">
                {{-- Event Content --}}
                <div class="col-lg-8 mb-4">
                    <div class="card border-0 shadow-sm">
                        {{-- Reuse Image Logic --}}
                        @php $eventImages = $event->getAllImages(); @endphp
                        @if(count($eventImages) > 0)
                            <div class="single-image-wrapper">
                                <img src="{{ asset('berkas/events/images/' . $eventImages[0]) }}"
                                    class="card-img-top single-event-img" alt="{{ $event->title }}">
                            </div>
                        @endif

                        <div class="card-body p-4">
                            <h2 class="mb-3">{{ $event->title }}</h2>
                            <div class="alert alert-warning border mb-3">
                                <h6 class="mb-2"><i class="fas fa-info-circle me-2"></i>Informasi Pendaftaran Internal</h6>
                                <p class="mb-0 small">
                                    Anda mendaftar melalui jalur khusus <strong>"{{ $internalLink->name }}"</strong>.
                                    Jalur ini memungkinkan pendaftaran meskipun kuota umum telah penuh atau pendaftaran umum
                                    ditutup (selama kuota link ini masih tersedia).
                                </p>
                            </div>

                            <hr>
                            <div class="event-content">
                                {!! $event->content !!}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Registration Form --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
                        <div class="card-header bg-theme text-white">
                            <h5 class="mb-0 text-white"><i class="fas fa-user-plus me-2"></i> Form Pendaftaran</h5>
                        </div>
                        <div class="card-body p-4">
                            @if(session('error'))
                                <div class="alert alert-danger small">
                                    <i class="fas fa-exclamation-circle me-1"></i>
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($isRegistered)
                                <div class="text-center py-3">
                                    <i class="fas fa-check-circle text-success fa-3x mb-3"></i>
                                    <h5>Anda Sudah Terdaftar!</h5>
                                    <p class="text-muted mb-0">Status: {{ strtoupper($registration->payment_status) }}</p>
                                </div>
                            @elseif(!$internalLink->isAvailable())
                                <div class="text-center py-3">
                                    <i class="fas fa-ban text-danger fa-3x mb-3"></i>
                                    <h5 class="text-danger">Link Tidak Berlaku</h5>
                                    <p class="text-muted small">Kuota link penuh atau masa berlaku habis.</p>
                                </div>
                            @else
                                <form
                                    action="{{ route('events.internal.store', ['slug' => $event->slug, 'token' => $internalLink->token]) }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->nama ?? '') }}" required>
                                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email ?? '') }}" required>
                                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    @if(!auth()->check())
                                        <div class="mb-3">
                                            <label class="form-label">Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror" required minlength="6">
                                            <small class="text-muted">Untuk login dashboard.</small>
                                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                            <input type="password" name="password_confirmation" class="form-control" required
                                                minlength="6">
                                        </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone ?? '') }}" required>
                                        @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="gender" class="form-select @error('gender') is-invalid @enderror"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Laki-Laki" {{ old('gender', $user->gender ?? '') == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                            <option value="Perempuan" {{ old('gender', $user->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="address" class="form-control"
                                            rows="2">{{ old('address', $user->address ?? '') }}</textarea>
                                    </div>

                                    <button type="submit" class="btn btn-theme w-100">
                                        <i class="fas fa-paper-plane me-2"></i> Daftar (Internal)
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('pageCss')
    <style>
        .page-title {
            padding: 80px 0 30px !important;
        }

        .page-title .title {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #fff;
        }

        .event-detail-section {
            padding: 30px 0 50px;
        }

        .bg-theme {
            background-color: #359090 !important;
        }

        .btn-theme {
            background-color: #359090;
            border-color: #359090;
            color: #fff;
        }

        .btn-theme:hover {
            background-color: #2a7070;
            border-color: #2a7070;
            color: #fff;
        }

        .single-image-wrapper {
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 250px;
            max-height: 450px;
            overflow: hidden;
        }

        .single-event-img {
            max-width: 100%;
            max-height: 450px;
            width: auto;
            height: auto;
            object-fit: contain;
            margin: 0 auto;
        }
    </style>
@endpush