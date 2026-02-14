<div>
    {{-- Breadcrumb --}}
    <x-breadcrumb title="Absensi Event" parent="Events" parentLink="{{ route('admin::events.index') }}"
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
                        <span class="badge bg-primary fs-6">
                            Hadir: {{ $this->attendedCount }} / {{ $this->totalParticipants }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Attendance Table --}}
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">Daftar Absensi</h4>
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
                    <div class="col-md-3">
                        <input type="text" wire:model.live.debounce.300ms="search" class="form-control"
                            placeholder="Cari nama...">
                    </div>
                    <div class="col-md-3">
                        <input type="date" wire:model.live="filterDate" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <button wire:click="resetFilters" class="btn btn-outline-secondary">Hari Ini</button>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Status Kehadiran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($this->participants as $index => $participant)
                            <tr>
                                <td>{{ $this->participants->firstItem() + $index }}</td>
                                <td>
                                    <strong>{{ $participant->name }}</strong>
                                </td>
                                <td>{{ $participant->email }}</td>
                                <td>
                                    @if($participant->attendances->isNotEmpty())
                                        <span class="badge bg-success">
                                            <i data-feather="check" style="width: 12px;"></i> Hadir
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            {{ $participant->attendances->first()->attended_at->format('H:i') }}
                                        </small>
                                    @else
                                        <span class="badge bg-secondary">Belum Hadir</span>
                                    @endif
                                </td>
                                <td>
                                    @if($participant->attendances->isNotEmpty())
                                        <button wire:click="removeAttendance({{ $participant->id }})"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Batalkan Kehadiran">
                                            <i data-feather="x" style="width: 14px;"></i> Batalkan
                                        </button>
                                    @else
                                        <button wire:click="markAttendance({{ $participant->id }})"
                                            class="btn btn-sm btn-success"
                                            title="Tandai Hadir">
                                            <i data-feather="check" style="width: 14px;"></i> Hadir
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <div class="text-muted">
                                        <i data-feather="users" style="width: 48px; height: 48px;"></i>
                                        <p class="mt-1">Tidak ada peserta yang terkonfirmasi</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer">
                {{ $this->participants->links() }}
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
        Livewire.on('attendance-marked', () => {
            toastr.success('Kehadiran berhasil dicatat!');
        });
        Livewire.on('attendance-removed', () => {
            toastr.warning('Kehadiran dibatalkan!');
        });
    });
</script>
@endpush
