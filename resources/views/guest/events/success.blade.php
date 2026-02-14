@extends('layouts.landing.page')

@section('content')
    <!--page title start-->
    <section class="page-title" data-bg-img="{{ asset('landing/images/bg/03.png') }}">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="title">Pendaftaran Berhasil</h1>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Sukses</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!--page title end-->

    <!--success section start-->
    <section class="pt-3 pb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="card border-0 shadow text-center">
                        <div class="card-body p-5">
                            <div class="mb-4">
                                <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
                            </div>

                            <h2 class="mb-3">Pendaftaran Berhasil!</h2>

                            <p class="text-muted mb-4">
                                Terima kasih telah mendaftar untuk event <strong>{{ $event->title }}</strong>.
                                @if($event->is_paid)
                                    Pembayaran Anda sedang kami verifikasi. Mohon tunggu konfirmasi dari admin.
                                @else
                                    Anda sudah terdaftar sebagai peserta.
                                @endif
                            </p>

                            <div class="alert alert-info text-start">
                                <h6><i class="fas fa-info-circle me-2"></i> Informasi Event:</h6>
                                <ul class="mb-0">
                                    <li><strong>Event:</strong> {{ $event->title }}</li>
                                    <li><strong>Tanggal:</strong>
                                        {{ $event->start_date->format('d M Y, H:i') }} WIB</li>
                                    @if($event->has_attendance)
                                        <li><strong>Absensi:</strong> Tersedia</li>
                                    @endif
                                    @if($event->has_certificate)
                                        <li><strong>Sertifikat:</strong> Tersedia setelah mengikuti event</li>
                                    @endif
                                </ul>
                            </div>

                            {{-- Auto Redirect Countdown --}}
                            @if(auth()->check())
                            <div class="alert alert-success mb-4">
                                <i class="fas fa-user-check me-2"></i>
                                <strong>Anda sudah login!</strong>
                                <p class="mb-2 mt-2">
                                    Anda akan dialihkan ke halaman akun dalam <span id="countdown" class="fw-bold fs-4">5</span> detik...
                                </p>
                                <p class="small mb-0">
                                    Di halaman akun Anda dapat melihat detail event, link grup WhatsApp, dan tombol absen saat event berlangsung.
                                </p>
                            </div>
                            @endif

                            <div class="d-flex gap-2 justify-content-center mt-4">
                                @if(auth()->check())
                                <a href="{{ route('dashboard::events') }}" class="btn btn-theme" id="btn-dashboard">
                                    <i class="fas fa-tachometer-alt me-2"></i> Ke Dashboard Sekarang
                                </a>
                                @else
                                <a href="{{ route('login') }}" class="btn btn-theme">
                                    <i class="fas fa-sign-in-alt me-2"></i> Login
                                </a>
                                @endif
                                <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Events
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--success section end-->
@endsection

@push('pageCss')
<style>
    .page-title {
        padding: 70px 0 20px !important;
    }

    .page-title .title {
        font-size: 1.8rem;
        margin-bottom: 8px;
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

    #countdown {
        display: inline-block;
        min-width: 30px;
        color: #359090;
    }

    .card-body {
        padding: 1.5rem !important;
    }

    .card-body .mb-4 {
        margin-bottom: 1rem !important;
    }

    .card-body h2 {
        font-size: 1.5rem;
    }

    @media (max-width: 768px) {
        .page-title {
            padding: 60px 0 15px !important;
        }
        .page-title .title {
            font-size: 1.5rem;
        }
    }
</style>
@endpush

@if(auth()->check())
@push('pageJS')
<script>
    $(document).ready(function() {
        var seconds = 5;
        var countdownEl = document.getElementById('countdown');

        var interval = setInterval(function() {
            seconds--;
            if (countdownEl) {
                countdownEl.textContent = seconds;
            }

            if (seconds <= 0) {
                clearInterval(interval);
                window.location.href = "{{ route('dashboard::events') }}";
            }
        }, 1000);

        // Allow clicking button to go immediately
        document.getElementById('btn-dashboard').addEventListener('click', function() {
            clearInterval(interval);
        });
    });
</script>
@endpush
@endif
