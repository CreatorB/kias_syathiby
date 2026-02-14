<div>
    {{-- Breadcrumb --}}
    <x-breadcrumb title="Kelola Event" parent="Admin" parentLink="{{ route('admin::dashboard') }}" current="Events" />

    <div class="content-body">
        {{-- Stats Cards --}}
        <div class="row mb-2">
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-body statistics-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="fw-bolder">{{ $this->totalEvents }}</h2>
                                <p class="card-text">Total Event</p>
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
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-body statistics-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="fw-bolder text-success">{{ $this->publishedCount }}</h2>
                                <p class="card-text">Published</p>
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
            <div class="col-lg-4 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-body statistics-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="fw-bolder text-warning">{{ $this->draftCount }}</h2>
                                <p class="card-text">Draft</p>
                            </div>
                            <div class="avatar bg-light-warning p-50">
                                <span class="avatar-content">
                                    <i data-feather="edit" class="font-medium-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Filter & Actions --}}
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Daftar Event</h4>
                <a href="{{ route('admin::events.create') }}" class="btn btn-primary">
                    <i data-feather="plus" class="me-25"></i> Buat Event
                </a>
            </div>
            <div class="card-body mt-1">
                <div class="row mb-2 align-items-center">
                    <div class="col-md-2">
                        <select wire:model.live="limitData" class="form-select">
                            <option value="10">10 per hal</option>
                            <option value="25">25 per hal</option>
                            <option value="50">50 per hal</option>
                            <option value="100">100 per hal</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                            placeholder="Cari judul event...">
                    </div>
                    <div class="col-md-3">
                        <select wire:model.live="filterStatus" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="draft">Draft</option>
                            <option value="published">Published</option>
                            <option value="closed">Closed</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button wire:click="resetFilters" class="btn btn-outline-secondary">Reset</button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Judul</th>
                            <th>Tanggal</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Peserta</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->events as $event)
                            <tr>
                                <td>
                                    <strong>{{ $event->title }}</strong>
                                    <br>
                                    <small class="text-muted">{{ Str::limit(strip_tags($event->content), 50) }}</small>
                                </td>
                                <td>
                                    <small>
                                        {{ $event->start_date->format('d M Y H:i') }}
                                        <br>
                                        s/d {{ $event->end_date->format('d M Y H:i') }}
                                    </small>
                                </td>
                                <td>
                                    @if($event->is_paid)
                                        <span class="badge bg-info">Berbayar</span>
                                        <br><small>Rp {{ number_format($event->price, 0, ',', '.') }}</small>
                                    @else
                                        <span class="badge bg-success">Gratis</span>
                                    @endif
                                </td>
                                <td>
                                    @switch($event->status)
                                        @case('draft')
                                            <span class="badge bg-warning">Draft</span>
                                            @break
                                        @case('published')
                                            <span class="badge bg-success">Published</span>
                                            @break
                                        @case('closed')
                                            <span class="badge bg-secondary">Closed</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $event->registrations->count() }}</span>
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                            data-bs-toggle="dropdown">
                                            <i data-feather="more-vertical"></i>
                                        </button>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <a class="dropdown-item" href="{{ route('admin::events.edit', $event->id) }}">
                                                <i data-feather="edit-2" class="me-50"></i> Edit
                                            </a>
                                            <a class="dropdown-item"
                                                href="{{ route('admin::events.participants', $event->id) }}">
                                                <i data-feather="users" class="me-50"></i> Peserta
                                            </a>
                                            @if($event->has_attendance)
                                                <a class="dropdown-item"
                                                    href="{{ route('admin::events.attendance', $event->id) }}">
                                                    <i data-feather="check-square" class="me-50"></i> Absensi
                                                </a>
                                            @endif
                                            <a class="dropdown-item" href="/events/{{ $event->slug }}" target="_blank">
                                                <i data-feather="external-link" class="me-50"></i> Lihat
                                            </a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item text-danger" href="#"
                                                wire:click.prevent="deleteEvent({{ $event->id }})"
                                                wire:confirm="Yakin ingin menghapus event ini?">
                                                <i data-feather="trash" class="me-50"></i> Hapus
                                            </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i data-feather="inbox" style="width: 48px; height: 48px;"></i>
                                        <p class="mt-1">Belum ada event</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="card-footer">
                {{ $this->events->links() }}
            </div>
        </div>
    </div>
</div>

@push('pageCss')
<style>
    /* Fix dropdown menu appearing behind table */
    .table-responsive {
        overflow: visible !important;
    }
    .dropdown-menu {
        z-index: 1050 !important;
    }
</style>
@endpush

@push('pageJS')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('event-deleted', () => {
            toastr.success('Event berhasil dihapus!');
        });
    });
</script>
@endpush
