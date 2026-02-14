<div>
    {{-- Breadcrumb --}}
    <x-breadcrumb title="Riwayat Event" parent="Dashboard" parentLink="#" current="Events" />

    <div class="content-body">
        {{-- Upgrade to Santri Banner (only for peserta role_id = 4) --}}
        @if(auth()->user()->role_id == 4)
        <div class="card mb-2 bg-gradient-primary">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="text-white mb-1">Upgrade ke Santri KIAS</h4>
                        <p class="text-white mb-0">Ikuti program pembelajaran lengkap Tajwid, Bahasa Arab, Takmili, atau Ulum Syariah dengan bimbingan para asatidzah berpengalaman.</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-2 mt-md-0">
                        <a href="/pilih-program" class="btn btn-light">
                            <i data-feather="arrow-up-circle" class="me-50"></i> Daftar Santri
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- Stats --}}
        <div class="row mb-2">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-body statistics-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="fw-bolder">{{ $this->totalEvents }}</h2>
                                <p class="card-text">Total Event Diikuti</p>
                            </div>
                            <div class="avatar bg-light-primary p-50">
                                <span class="avatar-content">
                                    <i data-feather="calendar" class="font-medium-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-body statistics-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="fw-bolder text-success">{{ $this->confirmedCount }}</h2>
                                <p class="card-text">Terkonfirmasi</p>
                            </div>
                            <div class="avatar bg-light-success p-50">
                                <span class="avatar-content">
                                    <i data-feather="check-circle" class="font-medium-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Flash Messages --}}
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i data-feather="check-circle" class="me-50"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i data-feather="alert-circle" class="me-50"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Event List --}}
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Daftar Event yang Diikuti</h4>
                <a href="/events" class="btn btn-outline-primary btn-sm">
                    <i data-feather="plus" class="me-25"></i> Cari Event
                </a>
            </div>

            <div class="card-body">
                @forelse($this->registrations as $registration)
                    @php
                        $event = $registration->event;
                        $userGender = auth()->user()->gender ?? null;
                        $groups = $event->getGroupsForGender($userGender);
                        $isEventOngoing = $event->isEventOngoing();
                        $hasAttendedToday = $registration->attendances()->whereDate('attended_at', now()->toDateString())->exists();
                        $canAttend = $isEventOngoing && $event->has_attendance && $registration->payment_status === 'valid' && !$hasAttendedToday;
                    @endphp

                    <div class="card border mb-2 shadow-sm">
                        <div class="card-body">
                            <div class="row">
                                {{-- Event Info --}}
                                <div class="col-md-6">
                                    <h5 class="mb-1">
                                        <a href="/events/{{ $event->slug }}" target="_blank" class="text-dark">
                                            {{ $event->title }}
                                        </a>
                                    </h5>
                                    <p class="text-muted small mb-2">
                                        <i data-feather="calendar" style="width: 14px;"></i>
                                        {{ $event->start_date->format('d M Y, H:i') }} - {{ $event->end_date->format('d M Y, H:i') }} WIB
                                    </p>

                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        {{-- Payment Status --}}
                                        @switch($registration->payment_status)
                                            @case('pending')
                                                <span class="badge bg-warning">
                                                    <i data-feather="clock" style="width: 12px;"></i> Menunggu Konfirmasi
                                                </span>
                                                @break
                                            @case('valid')
                                                <span class="badge bg-success">
                                                    <i data-feather="check-circle" style="width: 12px;"></i> Terkonfirmasi
                                                </span>
                                                @break
                                            @case('invalid')
                                                <span class="badge bg-danger">
                                                    <i data-feather="x-circle" style="width: 12px;"></i> Ditolak
                                                </span>
                                                @break
                                        @endswitch

                                        {{-- Attendance Status --}}
                                        @if($registration->attendances->count() > 0)
                                            <span class="badge bg-info">
                                                <i data-feather="user-check" style="width: 12px;"></i>
                                                Hadir {{ $registration->attendances->count() }}x
                                            </span>
                                        @endif

                                        {{-- Event Status --}}
                                        @if($event->hasEnded())
                                            <span class="badge bg-secondary">Event Selesai</span>
                                        @elseif($isEventOngoing)
                                            <span class="badge bg-primary animate__animated animate__pulse animate__infinite">
                                                <i data-feather="play-circle" style="width: 12px;"></i> Sedang Berlangsung
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark">Belum Dimulai</span>
                                        @endif
                                    </div>
                                </div>

                                {{-- Actions --}}
                                <div class="col-md-6">
                                    <div class="d-flex flex-column gap-2">
                                        {{-- Attendance Button --}}
                                        @if($event->has_attendance && $registration->payment_status === 'valid')
                                            @if($canAttend)
                                                <button wire:click="markAttendance({{ $registration->id }})"
                                                    wire:loading.attr="disabled"
                                                    class="btn btn-success btn-sm">
                                                    <span wire:loading.remove wire:target="markAttendance({{ $registration->id }})">
                                                        <i data-feather="check-square" style="width: 14px;"></i> Klik untuk Absen
                                                    </span>
                                                    <span wire:loading wire:target="markAttendance({{ $registration->id }})">
                                                        <span class="spinner-border spinner-border-sm"></span> Memproses...
                                                    </span>
                                                </button>
                                            @elseif($hasAttendedToday)
                                                <button class="btn btn-outline-success btn-sm" disabled>
                                                    <i data-feather="check" style="width: 14px;"></i> Sudah Absen Hari Ini
                                                </button>
                                            @elseif(!$isEventOngoing && !$event->hasEnded())
                                                <button class="btn btn-outline-secondary btn-sm" disabled>
                                                    <i data-feather="clock" style="width: 14px;"></i> Absen saat acara dimulai
                                                </button>
                                            @endif
                                        @endif

                                        {{-- Certificate Button - TODO: Implement certificate download feature --}}
                                        @if($event->has_certificate && $registration->payment_status === 'valid' && $registration->attendances->count() > 0 && $event->hasEnded())
                                            <button class="btn btn-warning btn-sm" disabled title="Fitur sertifikat akan segera hadir">
                                                <i data-feather="award" style="width: 14px;"></i> Sertifikat (Segera)
                                            </button>
                                        @endif

                                        {{-- View Event Button --}}
                                        <a href="/events/{{ $event->slug }}" target="_blank"
                                            class="btn btn-outline-primary btn-sm">
                                            <i data-feather="external-link" style="width: 14px;"></i> Lihat Event
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {{-- Group Links Section --}}
                            @if(count($groups) > 0 && $registration->payment_status === 'valid')
                                <hr class="my-2">
                                <div class="alert alert-success py-2 mb-0">
                                    <div class="d-flex align-items-center mb-1">
                                        <i data-feather="message-circle" style="width: 16px;" class="me-1"></i>
                                        <strong class="small">Bergabung ke Grup WhatsApp</strong>
                                    </div>
                                    <p class="small mb-2 text-muted">
                                        Bergabunglah ke grup agar tidak ketinggalan informasi penting terkait event ini!
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($groups as $type => $link)
                                            <a href="{{ $link }}" target="_blank" class="btn btn-sm btn-success">
                                                <i data-feather="message-circle" style="width: 14px;"></i>
                                                @if($type === 'ikhwan')
                                                    Grup Ikhwan
                                                @elseif($type === 'akhwat')
                                                    Grup Akhwat
                                                @else
                                                    Grup Umum
                                                @endif
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @elseif($registration->payment_status !== 'valid' && (
                                $event->group_ikhwan || $event->group_akhwat || $event->group_public
                            ))
                                <hr class="my-2">
                                <div class="alert alert-light py-2 mb-0">
                                    <p class="small mb-0 text-muted">
                                        <i data-feather="lock" style="width: 14px;"></i>
                                        Link grup akan tersedia setelah pembayaran dikonfirmasi.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="text-center py-4">
                        <div class="text-muted">
                            <i data-feather="calendar" style="width: 48px; height: 48px;"></i>
                            <p class="mt-1">Anda belum mengikuti event apapun</p>
                            <a href="/events" class="btn btn-primary btn-sm">
                                <i data-feather="search" class="me-25"></i> Cari Event
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($this->registrations->hasPages())
            <div class="card-footer">
                {{ $this->registrations->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
