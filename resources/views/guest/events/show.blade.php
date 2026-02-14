@extends('layouts.landing.page')

@section('content')
    <!--page title start-->
    <section class="page-title" data-bg-img="{{ asset('landing/images/bg/03.png') }}">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="title">{{ $event->title }}</h1>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('events.index') }}">Events</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail</li>
                        </ol>
                    </nav>
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
                        @php $eventImages = $event->getAllImages(); @endphp
                        @if(count($eventImages) > 0)
                            @if(count($eventImages) > 1)
                                {{-- Multiple Images - Carousel Slider with Lightbox --}}
                                <div id="eventImageCarousel" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-indicators">
                                        @foreach($eventImages as $index => $img)
                                            <button type="button" data-bs-target="#eventImageCarousel"
                                                data-bs-slide-to="{{ $index }}" @if($index === 0) class="active" aria-current="true" @endif
                                                aria-label="Slide {{ $index + 1 }}"></button>
                                        @endforeach
                                    </div>
                                    <div class="carousel-inner">
                                        @foreach($eventImages as $index => $img)
                                            <div class="carousel-item @if($index === 0) active @endif">
                                                <a href="{{ asset('berkas/events/images/' . $img) }}" class="event-lightbox" data-gallery="event-gallery">
                                                    <div class="carousel-image-wrapper">
                                                        <img src="{{ asset('berkas/events/images/' . $img) }}" class="d-block carousel-img"
                                                            alt="{{ $event->title }}">
                                                        <div class="zoom-overlay">
                                                            <i class="fas fa-search-plus"></i>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#eventImageCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#eventImageCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                                {{-- Thumbnail Navigation --}}
                                <div class="event-thumbnails d-flex justify-content-center gap-2 mt-2 px-3">
                                    @foreach($eventImages as $index => $img)
                                        <img src="{{ asset('berkas/events/images/' . $img) }}"
                                            class="event-thumb @if($index === 0) active @endif"
                                            data-bs-target="#eventImageCarousel" data-bs-slide-to="{{ $index }}"
                                            alt="Thumbnail {{ $index + 1 }}">
                                    @endforeach
                                </div>
                            @else
                                {{-- Single Image with Lightbox --}}
                                <a href="{{ asset('berkas/events/images/' . $eventImages[0]) }}" class="event-lightbox">
                                    <div class="single-image-wrapper">
                                        <img src="{{ asset('berkas/events/images/' . $eventImages[0]) }}" class="card-img-top single-event-img"
                                            alt="{{ $event->title }}">
                                        <div class="zoom-overlay">
                                            <i class="fas fa-search-plus"></i>
                                        </div>
                                    </div>
                                </a>
                            @endif
                        @endif
                        <div class="card-body p-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div>
                                    @if($event->is_paid)
                                        <span class="badge bg-info fs-6">Berbayar - Rp
                                            {{ number_format($event->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="badge bg-success fs-6">Gratis</span>
                                    @endif
                                </div>
                                <div>
                                    @if($event->has_attendance)
                                        <span class="badge bg-secondary"><i class="fas fa-check-square"></i> Absensi</span>
                                    @endif
                                    @if($event->has_certificate)
                                        <span class="badge bg-secondary"><i class="fas fa-certificate"></i>
                                            Sertifikat</span>
                                    @endif
                                </div>
                            </div>

                            <h2 class="mb-3">{{ $event->title }}</h2>

                            {{-- Countdown Timer --}}
                            @php
                                $now = now();
                                $showCountdown = false;
                                $countdownDate = null;
                                $countdownLabel = '';

                                if ($event->registration_start && $now->isBefore($event->registration_start)) {
                                    // Countdown to registration opening
                                    $showCountdown = true;
                                    $countdownDate = $event->registration_start;
                                    $countdownLabel = 'Pendaftaran Dibuka Dalam';
                                } elseif ($event->isRegistrationOpen() && $event->registration_end) {
                                    // Countdown to registration closing
                                    $showCountdown = true;
                                    $countdownDate = $event->registration_end;
                                    $countdownLabel = 'Pendaftaran Ditutup Dalam';
                                } elseif ($now->isBefore($event->start_date)) {
                                    // Countdown to event start
                                    $showCountdown = true;
                                    $countdownDate = $event->start_date;
                                    $countdownLabel = 'Event Dimulai Dalam';
                                }
                            @endphp

                            @if($showCountdown && $countdownDate)
                            <div class="countdown-wrapper bg-light rounded p-3 mb-3 text-center">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-clock me-1"></i> {{ $countdownLabel }}
                                </h6>
                                <ul class="countdown list-unstyled d-flex justify-content-center gap-3 mb-0"
                                    data-countdown="{{ $countdownDate->format('Y/m/d H:i:s') }}">
                                </ul>
                            </div>
                            @endif

                            <div class="d-flex flex-wrap gap-4 mb-3 text-muted">
                                <div>
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    <strong>Acara Mulai:</strong> {{ $event->start_date->format('d M Y, H:i') }} WIB
                                </div>
                                <div>
                                    <i class="fas fa-calendar-check me-2"></i>
                                    <strong>Acara Selesai:</strong> {{ $event->end_date->format('d M Y, H:i') }} WIB
                                </div>
                            </div>

                            @if($event->registration_start || $event->registration_end)
                            <div class="alert alert-light border mb-3">
                                <h6 class="mb-2"><i class="fas fa-clipboard-list me-2 text-primary"></i>Periode Pendaftaran</h6>
                                <div class="d-flex flex-wrap gap-3 small">
                                    @if($event->registration_start)
                                    <div>
                                        <i class="fas fa-door-open text-success me-1"></i>
                                        <strong>Buka:</strong> {{ $event->registration_start->format('d M Y, H:i') }} WIB
                                    </div>
                                    @endif
                                    @if($event->registration_end)
                                    <div>
                                        <i class="fas fa-door-closed text-danger me-1"></i>
                                        <strong>Tutup:</strong> {{ $event->registration_end->format('d M Y, H:i') }} WIB
                                    </div>
                                    @endif
                                </div>
                                @if($event->isRegistrationOpen())
                                    <span class="badge bg-success mt-2"><i class="fas fa-check-circle me-1"></i> Pendaftaran Dibuka</span>
                                @elseif($event->registration_start && now()->isBefore($event->registration_start))
                                    <span class="badge bg-warning mt-2"><i class="fas fa-clock me-1"></i> Pendaftaran Belum Dibuka</span>
                                @else
                                    <span class="badge bg-danger mt-2"><i class="fas fa-times-circle me-1"></i> Pendaftaran Ditutup</span>
                                @endif
                            </div>
                            @endif

                            {{-- Quota Display --}}
                            @if($event->quota_ikhwan || $event->quota_akhwat)
                            <div class="alert alert-info border mb-4">
                                <h6 class="mb-2"><i class="fas fa-users me-2"></i>Kuota Peserta</h6>
                                <div class="row">
                                    @if($event->quota_ikhwan)
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-male text-primary me-2"></i>
                                            <div>
                                                <div class="small text-muted">Ikhwan</div>
                                                <strong class="{{ $event->remaining_quota_ikhwan === 0 ? 'text-danger' : '' }}">
                                                    {{ $event->registered_ikhwan_count }}/{{ $event->quota_ikhwan }}
                                                </strong>
                                                @if($event->remaining_quota_ikhwan === 0)
                                                    <span class="badge bg-danger ms-1">Penuh</span>
                                                @else
                                                    <span class="text-muted small">(Sisa: {{ $event->remaining_quota_ikhwan }})</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @if($event->quota_akhwat)
                                    <div class="col-6">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-female text-danger me-2"></i>
                                            <div>
                                                <div class="small text-muted">Akhwat</div>
                                                <strong class="{{ $event->remaining_quota_akhwat === 0 ? 'text-danger' : '' }}">
                                                    {{ $event->registered_akhwat_count }}/{{ $event->quota_akhwat }}
                                                </strong>
                                                @if($event->remaining_quota_akhwat === 0)
                                                    <span class="badge bg-danger ms-1">Penuh</span>
                                                @else
                                                    <span class="text-muted small">(Sisa: {{ $event->remaining_quota_akhwat }})</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

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
                            <h5 class="mb-0 text-white"><i class="fas fa-user-plus me-2"></i> Daftar Event</h5>
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
                                    <p class="text-muted mb-0">
                                        Status:
                                        @switch($registration->payment_status)
                                            @case('pending')
                                                <span class="badge bg-warning">Menunggu Konfirmasi</span>
                                                @break
                                            @case('valid')
                                                <span class="badge bg-success">Terkonfirmasi</span>
                                                @break
                                            @case('invalid')
                                                <span class="badge bg-danger">Ditolak</span>
                                                @break
                                        @endswitch
                                    </p>
                                </div>
                            @elseif($event->hasEnded())
                                <div class="text-center py-3">
                                    <i class="fas fa-calendar-times text-muted fa-3x mb-3"></i>
                                    <h5 class="text-muted">Event Telah Berakhir</h5>
                                </div>
                            @elseif(!$event->isRegistrationOpen())
                                <div class="text-center py-3">
                                    <i class="fas fa-clock text-warning fa-3x mb-3"></i>
                                    @if($event->registration_start && now()->isBefore($event->registration_start))
                                        <h5 class="text-warning">Pendaftaran Belum Dibuka</h5>
                                        <p class="text-muted small">
                                            Pendaftaran akan dibuka pada:<br>
                                            <strong>{{ $event->registration_start->format('d M Y, H:i') }} WIB</strong>
                                        </p>
                                    @else
                                        <h5 class="text-danger">Pendaftaran Ditutup</h5>
                                        <p class="text-muted small">
                                            Pendaftaran telah ditutup pada:<br>
                                            <strong>{{ $event->registration_end?->format('d M Y, H:i') ?? '-' }} WIB</strong>
                                        </p>
                                    @endif
                                </div>
                            @elseif(
                                ($event->quota_ikhwan && $event->remaining_quota_ikhwan === 0) &&
                                ($event->quota_akhwat && $event->remaining_quota_akhwat === 0)
                            )
                                <div class="text-center py-3">
                                    <i class="fas fa-users-slash text-danger fa-3x mb-3"></i>
                                    <h5 class="text-danger">Kuota Peserta Penuh</h5>
                                    <p class="text-muted small">
                                        Kuota untuk semua jenis kelamin sudah terisi penuh.
                                    </p>
                                </div>
                            @else
                                @if(!auth()->check())
                                    <div class="alert alert-info small mb-3">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Sudah punya akun? <a href="{{ route('login') }}"
                                            class="fw-bold">Login</a> untuk pendaftaran lebih mudah!
                                    </div>
                                @endif

                                <form action="{{ route('events.register', $event->slug) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf

                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                            value="{{ old('name', $user->nama ?? '') }}" required>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Email <span class="text-danger">*</span></label>
                                        <input type="email" name="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email', $user->email ?? '') }}" required>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if(!auth()->check())
                                    <div class="mb-3">
                                        <label class="form-label">Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror"
                                            placeholder="Buat password untuk login" required minlength="6">
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Min. 6 karakter. Password ini untuk login ke dashboard.</small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                        <input type="password" name="password_confirmation"
                                            class="form-control" required minlength="6">
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                                        <input type="text" name="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone', $user->phone ?? '') }}" required>
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select name="gender" id="genderSelect" class="form-select @error('gender') is-invalid @enderror"
                                            required>
                                            <option value="">-- Pilih --</option>
                                            <option value="Laki-Laki"
                                                {{ old('gender', $user->gender ?? '') == 'Laki-Laki' ? 'selected' : '' }}
                                                @if($event->quota_ikhwan && $event->remaining_quota_ikhwan === 0) disabled @endif>
                                                Laki-Laki @if($event->quota_ikhwan && $event->remaining_quota_ikhwan === 0) (Kuota Penuh) @endif
                                            </option>
                                            <option value="Perempuan"
                                                {{ old('gender', $user->gender ?? '') == 'Perempuan' ? 'selected' : '' }}
                                                @if($event->quota_akhwat && $event->remaining_quota_akhwat === 0) disabled @endif>
                                                Perempuan @if($event->quota_akhwat && $event->remaining_quota_akhwat === 0) (Kuota Penuh) @endif
                                            </option>
                                        </select>
                                        @error('gender')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if(($event->quota_ikhwan && $event->remaining_quota_ikhwan === 0) || ($event->quota_akhwat && $event->remaining_quota_akhwat === 0))
                                            <small class="text-muted">
                                                <i class="fas fa-info-circle"></i> Pilihan yang tidak tersedia berarti kuotanya sudah penuh.
                                            </small>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Alamat</label>
                                        <textarea name="address" class="form-control" rows="2">{{ old('address', $user->address ?? '') }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Tempat Lahir</label>
                                            <input type="text" name="birth_place" class="form-control"
                                                value="{{ old('birth_place', $user?->birth_place ?? '') }}">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label class="form-label">Tanggal Lahir</label>
                                            <input type="date" name="birth_date" class="form-control"
                                                value="{{ old('birth_date', $user?->birth_date?->format('Y-m-d') ?? '') }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Pekerjaan</label>
                                        <input type="text" name="occupation" class="form-control"
                                            value="{{ old('occupation', $user->occupation ?? '') }}">
                                    </div>

                                    @if($event->is_paid)
                                        <div class="mb-3">
                                            <label class="form-label">Bukti Pembayaran <span
                                                    class="text-danger">*</span></label>
                                            <input type="file" name="payment_proof"
                                                class="form-control @error('payment_proof') is-invalid @enderror"
                                                accept="image/*" required>
                                            <small class="text-muted">Transfer ke: Bank BSI 123456789 a.n KIAS</small>
                                            @error('payment_proof')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    <button type="submit" class="btn btn-theme w-100">
                                        <i class="fas fa-paper-plane me-2"></i> Daftar Sekarang
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--event detail section end-->
@endsection

@push('pageCss')
<style>
    /* Page title - reduced spacing */
    .page-title {
        padding: 80px 0 30px !important;
    }

    .page-title .title {
        font-size: 2rem;
        margin-bottom: 10px;
    }

    /* Event detail section */
    .event-detail-section {
        padding: 30px 0 50px;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .page-title {
            padding: 70px 0 20px !important;
        }

        .page-title .title {
            font-size: 1.5rem;
        }

        .event-detail-section {
            padding: 20px 0 40px;
        }
    }

    .event-content img {
        max-width: 100%;
        height: auto;
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

    /* Carousel & Image Styling - Proportional without cropping */
    .carousel-image-wrapper,
    .single-image-wrapper {
        position: relative;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 250px;
        max-height: 450px;
        overflow: hidden;
    }

    .carousel-img,
    .single-event-img {
        max-width: 100%;
        max-height: 450px;
        width: auto;
        height: auto;
        object-fit: contain;
        margin: 0 auto;
    }

    .zoom-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
        cursor: pointer;
    }

    .zoom-overlay i {
        color: #fff;
        font-size: 2rem;
    }

    .carousel-image-wrapper:hover .zoom-overlay,
    .single-image-wrapper:hover .zoom-overlay {
        opacity: 1;
    }

    /* Carousel controls */
    #eventImageCarousel .carousel-control-prev,
    #eventImageCarousel .carousel-control-next {
        width: 50px;
        background: rgba(0,0,0,0.5);
        border-radius: 5px;
        height: 50px;
        top: 50%;
        transform: translateY(-50%);
    }

    #eventImageCarousel .carousel-indicators {
        margin-bottom: 10px;
    }

    #eventImageCarousel .carousel-indicators button {
        width: 10px;
        height: 10px;
        border-radius: 50%;
    }

    /* Thumbnail navigation */
    .event-thumbnails {
        padding: 10px 0;
        background: #f8f9fa;
        border-radius: 0 0 5px 5px;
    }

    .event-thumb {
        width: 60px;
        height: 45px;
        object-fit: cover;
        border-radius: 4px;
        cursor: pointer;
        border: 2px solid transparent;
        transition: all 0.3s ease;
        opacity: 0.7;
    }

    .event-thumb:hover,
    .event-thumb.active {
        border-color: #359090;
        opacity: 1;
    }

    /* Lightbox styling */
    .mfp-bg {
        background: rgba(0,0,0,0.9);
    }

    .mfp-figure::after {
        background: transparent;
        box-shadow: none;
    }

    .mfp-counter {
        color: #fff;
    }

    /* Countdown Styling */
    .countdown-wrapper {
        border: 2px dashed #359090;
    }

    .countdown li {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 10px 15px;
        background: #359090;
        border-radius: 8px;
        min-width: 70px;
    }

    .countdown li span {
        font-size: 1.8rem;
        font-weight: 700;
        color: #fff;
        line-height: 1;
    }

    .countdown li p {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.9);
        margin: 5px 0 0 0;
        text-transform: uppercase;
    }

    @media (max-width: 576px) {
        .countdown li {
            padding: 8px 10px;
            min-width: 55px;
        }
        .countdown li span {
            font-size: 1.3rem;
        }
        .countdown li p {
            font-size: 0.65rem;
        }
    }
</style>
@endpush

@push('pageJS')
<script>
    // Initialize Magnific Popup for lightbox
    $(document).ready(function() {
        $('.event-lightbox').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                preload: [0,1]
            },
            image: {
                titleSrc: function(item) {
                    return '{{ $event->title }}';
                }
            },
            zoom: {
                enabled: true,
                duration: 300
            }
        });

        // Update thumbnail active state on carousel slide
        $('#eventImageCarousel').on('slide.bs.carousel', function(e) {
            $('.event-thumb').removeClass('active');
            $('.event-thumb').eq(e.to).addClass('active');
        });

        // Click on thumbnail to change slide
        $('.event-thumb').on('click', function() {
            var index = $(this).data('bs-slide-to');
            $('#eventImageCarousel').carousel(index);
        });
    });
</script>
@endpush
