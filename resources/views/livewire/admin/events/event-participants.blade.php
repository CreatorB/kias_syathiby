<div>
    {{-- Breadcrumb --}}
    <x-breadcrumb title="Peserta Event" parent="Events" parentLink="{{ route('admin::events.index') }}"
        current="{{ $event->title }}" />

    <div class="content-body">
        {{-- Event Info --}}
        <div class="card mb-2">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0">{{ $event->title }}</h4>
                        <small class="text-muted">
                            {{ $event->start_date->format('d M Y H:i') }} -
                            {{ $event->end_date->format('d M Y H:i') }}
                        </small>
                    </div>
                    <div>
                        @if($event->is_paid)
                            <span class="badge bg-info">Berbayar - Rp
                                {{ number_format($event->price, 0, ',', '.') }}</span>
                        @else
                            <span class="badge bg-success">Gratis</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Stats --}}
        <div class="row mb-2">
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-body statistics-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="fw-bolder">{{ $this->totalRegistrations }}</h2>
                                <p class="card-text">Total Pendaftar</p>
                            </div>
                            <div class="avatar bg-light-primary p-50">
                                <span class="avatar-content">
                                    <i data-feather="users" class="font-medium-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
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
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-body statistics-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="fw-bolder text-warning">{{ $this->pendingCount }}</h2>
                                <p class="card-text">Menunggu</p>
                            </div>
                            <div class="avatar bg-light-warning p-50">
                                <span class="avatar-content">
                                    <i data-feather="clock" class="font-medium-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <div class="card card-statistics">
                    <div class="card-body statistics-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h2 class="fw-bolder text-danger">{{ $this->rejectedCount }}</h2>
                                <p class="card-text">Ditolak</p>
                            </div>
                            <div class="avatar bg-light-danger p-50">
                                <span class="avatar-content">
                                    <i data-feather="x-circle" class="font-medium-4"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Participants Table --}}
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Daftar Peserta</h4>
            </div>
            <div class="card-body mt-1">
                <div class="row mb-2 align-items-center">
                    <div class="col-md-2">
                        <select wire:model.live="limitData" class="form-select">
                            <option value="15">15 per hal</option>
                            <option value="25">25 per hal</option>
                            <option value="50">50 per hal</option>
                            <option value="100">100 per hal</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                            placeholder="Cari nama/email/HP...">
                    </div>
                    <div class="col-md-3">
                        <select wire:model.live="filterStatus" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="pending">Menunggu</option>
                            <option value="valid">Terkonfirmasi</option>
                            <option value="invalid">Ditolak</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <button wire:click="resetFilters" class="btn btn-outline-secondary">Reset</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Kontak</th>
                            <th>Tanggal Daftar</th>
                            <th>Status</th>
                            @if($event->is_paid)
                                <th>Bukti Bayar</th>
                            @endif
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->registrations as $registration)
                            <tr>
                                <td>
                                    <strong>{{ $registration->name }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $registration->gender }}</small>
                                </td>
                                <td>
                                    <small>
                                        <i data-feather="mail" style="width: 14px;"></i> {{ $registration->email }}
                                        <br>
                                        <i data-feather="phone" style="width: 14px;"></i> {{ $registration->phone }}
                                    </small>
                                </td>
                                <td>
                                    <small>{{ $registration->registered_at->format('d M Y H:i') }}</small>
                                </td>
                                <td>
                                    @switch($registration->payment_status)
                                        @case('pending')
                                            <span class="badge bg-warning">Menunggu</span>
                                            @break
                                        @case('valid')
                                            <span class="badge bg-success">Terkonfirmasi</span>
                                            @break
                                        @case('invalid')
                                            <span class="badge bg-danger">Ditolak</span>
                                            @break
                                    @endswitch
                                </td>
                                @if($event->is_paid)
                                    <td>
                                        @if($registration->payment_proof)
                                            <a href="{{ asset('berkas/events/payments/' . $registration->payment_proof) }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i data-feather="image" style="width: 14px;"></i> Lihat
                                            </a>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                @endif
                                <td>
                                    @if($registration->payment_status == 'pending')
                                        <button wire:click="confirmPayment({{ $registration->id }})"
                                            class="btn btn-sm btn-success" title="Konfirmasi">
                                            <i data-feather="check" style="width: 14px;"></i>
                                        </button>
                                        <button wire:click="rejectPayment({{ $registration->id }})"
                                            class="btn btn-sm btn-danger" title="Tolak">
                                            <i data-feather="x" style="width: 14px;"></i>
                                        </button>
                                    @else
                                        <button wire:click="deleteRegistration({{ $registration->id }})"
                                            wire:confirm="Yakin ingin menghapus peserta ini?"
                                            class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i data-feather="trash-2" style="width: 14px;"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="{{ $event->is_paid ? 6 : 5 }}" class="text-center py-4">
                                    <div class="text-muted">
                                        <i data-feather="users" style="width: 48px; height: 48px;"></i>
                                        <p class="mt-1">Belum ada peserta terdaftar</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $this->registrations->links() }}
            </div>
        </div>
    </div>
</div>

@push('pageCss')
<style>
    .table-responsive {
        overflow: visible !important;
    }
</style>
@endpush

@push('pageJS')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('payment-confirmed', () => {
            toastr.success('Pembayaran berhasil dikonfirmasi!');
        });
        Livewire.on('payment-rejected', () => {
            toastr.warning('Pembayaran ditolak!');
        });
        Livewire.on('registration-deleted', () => {
            toastr.success('Peserta berhasil dihapus!');
        });
    });
</script>
@endpush
