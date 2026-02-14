@extends('layouts.landing.page')

@section('content')
    <!--page title start-->
    <section class="page-title" data-bg-img="{{ asset('landing/images/bg/03.png') }}">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8">
                    <h1 class="title">Daftar Event</h1>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Events</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!--page title end-->

    <!--events section start-->
    <section class="events-list-section">
        <div class="container">
            <div class="row">
                @forelse($events as $event)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm border-0">
                            @php $eventImages = $event->getAllImages(); @endphp
                            @if(count($eventImages) > 0)
                                <img src="{{ asset('berkas/events/images/' . $eventImages[0]) }}" class="card-img-top event-thumbnail"
                                    alt="{{ $event->title }}"
                                    onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div class="bg-light align-items-center justify-content-center event-placeholder" style="display: none;">
                                    <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center event-placeholder">
                                    <i class="fas fa-calendar-alt fa-3x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <div class="d-flex justify-content-between mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar"></i>
                                        {{ $event->start_date->format('d M Y') }}
                                    </small>
                                    @if($event->is_paid)
                                        <span class="badge bg-info">Rp
                                            {{ number_format($event->price, 0, ',', '.') }}</span>
                                    @else
                                        <span class="badge bg-success">Gratis</span>
                                    @endif
                                </div>
                                <h5 class="card-title">
                                    <a href="{{ route('events.show', $event->slug) }}"
                                        class="text-dark text-decoration-none">
                                        {{ $event->title }}
                                    </a>
                                </h5>
                                <p class="card-text text-muted small">
                                    {{ Str::limit(strip_tags($event->content), 100) }}
                                </p>
                            </div>
                            <div class="card-footer bg-transparent border-0 pb-3">
                                <a href="{{ route('events.show', $event->slug) }}" class="btn btn-theme btn-sm w-100">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-calendar-times fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">Belum ada event tersedia</h4>
                        <p class="text-muted">Nantikan event-event menarik dari kami!</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($events->hasPages())
                <div class="row mt-4">
                    <div class="col-12 d-flex justify-content-center">
                        {{ $events->links() }}
                    </div>
                </div>
            @endif
        </div>
    </section>
    <!--events section end-->
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

    /* Events list section */
    .events-list-section {
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

        .events-list-section {
            padding: 20px 0 40px;
        }
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

    /* Event thumbnail - show from top, not cropped center */
    .event-thumbnail {
        height: 180px;
        object-fit: cover;
        object-position: top;
        width: 100%;
    }

    .event-placeholder {
        height: 180px;
    }
</style>
@endpush
