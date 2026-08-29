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
                                <div class="d-flex align-items-center gap-2">
                                    <h2 class="fw-bolder mb-0">{{ $this->totalRegistrations }}</h2>
                                    <div class="d-flex flex-column gap-25" style="font-size: 11px;">
                                        <span class="text-primary" title="Ikhwan">🧔 {{ $this->ikhwanCount }}</span>
                                        <span class="text-danger" title="Akhwat">🧕 {{ $this->akhwatCount }}</span>
                                    </div>
                                </div>
                                <p class="card-text mb-0">Total</p>
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

        {{-- Tabs --}}
        <ul class="nav nav-pills mb-2">
            <li class="nav-item">
                <a class="nav-link active" id="participants-tab" data-bs-toggle="pill" href="#participants" role="tab"
                    aria-controls="participants" aria-selected="true">
                    <i data-feather="users" class="font-medium-3 me-50"></i>
                    <span class="fw-bold">Daftar Peserta</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="internal-links-tab" data-bs-toggle="pill" href="#internal-links" role="tab"
                    aria-controls="internal-links" aria-selected="false">
                    <i data-feather="link" class="font-medium-3 me-50"></i>
                    <span class="fw-bold">Link Internal</span>
                </a>
            </li>
        </ul>

        <div class="tab-content">
            {{-- Participants Tab --}}
            <div class="tab-pane fade show active" id="participants" role="tabpanel" aria-labelledby="participants-tab">
                {{-- Participants Table --}}
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Daftar Peserta</h4>
                        <div class="d-flex gap-1">
                            <button type="button"
                                wire:click="bulkResetPassword"
                                wire:confirm="Yakin ingin mereset password SEMUA peserta di event ini?"
                                class="btn btn-outline-warning"
                                wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="bulkResetPassword">
                                    <i data-feather="refresh-cw" class="me-50"></i> Reset Semua Password
                                </span>
                                <span wire:loading wire:target="bulkResetPassword">
                                    <span class="spinner-border spinner-border-sm me-50"></span> Mereset...
                                </span>
                            </button>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#manualParticipantModal">
                                <i data-feather="plus" class="me-50"></i> Tambah Peserta Manual
                            </button>
                        </div>
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
                                    placeholder="Cari nama/email/HP...">
                            </div>
                            <div class="col-md-2">
                                <select wire:model.live="filterStatus" class="form-select">
                                    <option value="">Semua Status</option>
                                    <option value="pending">Menunggu</option>
                                    <option value="valid">Terkonfirmasi</option>
                                    <option value="invalid">Ditolak</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select wire:model.live="filterGender" class="form-select">
                                    <option value="">Semua Gender</option>
                                    <option value="L">Ikhwan (Laki-laki)</option>
                                    <option value="P">Akhwat (Perempuan)</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button wire:click="resetFilters" class="btn btn-outline-secondary w-100">Reset</button>
                            </div>
                        </div>
                    </div>

                    {{-- Desktop Table View --}}
                    <div class="table-responsive d-none d-md-block">
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
                                            @endif
                                            <button wire:click="editParticipant({{ $registration->id }})"
                                                class="btn btn-sm btn-outline-warning" title="Edit">
                                                <i data-feather="edit-2" style="width: 14px;"></i>
                                            </button>
                                            <button wire:click="resetPassword({{ $registration->id }})"
                                                wire:confirm="Reset password peserta ini?"
                                                class="btn btn-sm btn-outline-secondary" title="Reset Password">
                                                <i data-feather="key" style="width: 14px;"></i>
                                            </button>
                                            <button wire:click="deleteRegistration({{ $registration->id }})"
                                                wire:confirm="Yakin ingin menghapus peserta ini?"
                                                class="btn btn-sm btn-outline-danger" title="Hapus">
                                                <i data-feather="trash-2" style="width: 14px;"></i>
                                            </button>
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

                    {{-- Mobile Card View --}}
                    <div class="d-md-none">
                        @forelse($this->registrations as $registration)
                            <div class="card mb-2">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <div>
                                            <h6 class="mb-0">{{ $registration->name }}</h6>
                                            <small class="text-muted">{{ $registration->gender }}</small>
                                        </div>
                                        <div>
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
                                        </div>
                                    </div>
                                    
                                    <div class="mb-2">
                                        <small class="d-block"><i data-feather="mail" style="width: 14px;"></i> {{ $registration->email }}</small>
                                        <small class="d-block"><i data-feather="phone" style="width: 14px;"></i> {{ $registration->phone }}</small>
                                        <small class="d-block text-muted"><i data-feather="calendar" style="width: 14px;"></i> {{ $registration->registered_at->format('d M Y H:i') }}</small>
                                    </div>

                                    @if($event->is_paid && $registration->payment_proof)
                                        <div class="mb-2">
                                            <a href="{{ asset('berkas/events/payments/' . $registration->payment_proof) }}"
                                                target="_blank" class="btn btn-sm btn-outline-primary w-100">
                                                <i data-feather="image" style="width: 14px;"></i> Lihat Bukti Bayar
                                            </a>
                                        </div>
                                    @endif

                                    <div class="d-flex flex-wrap gap-1">
                                        @if($registration->payment_status == 'pending')
                                            <button wire:click="confirmPayment({{ $registration->id }})"
                                                class="btn btn-sm btn-success flex-fill">
                                                <i data-feather="check" style="width: 14px;"></i> Konfirmasi
                                            </button>
                                            <button wire:click="rejectPayment({{ $registration->id }})"
                                                class="btn btn-sm btn-danger flex-fill">
                                                <i data-feather="x" style="width: 14px;"></i> Tolak
                                            </button>
                                        @endif
                                        <button wire:click="editParticipant({{ $registration->id }})"
                                            class="btn btn-sm btn-outline-warning">
                                            <i data-feather="edit-2" style="width: 14px;"></i>
                                        </button>
                                        <button wire:click="resetPassword({{ $registration->id }})"
                                            wire:confirm="Reset password peserta ini?"
                                            class="btn btn-sm btn-outline-secondary">
                                            <i data-feather="key" style="width: 14px;"></i>
                                        </button>
                                        <button wire:click="deleteRegistration({{ $registration->id }})"
                                            wire:confirm="Yakin ingin menghapus peserta ini?"
                                            class="btn btn-sm btn-outline-danger">
                                            <i data-feather="trash-2" style="width: 14px;"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <div class="text-muted">
                                    <i data-feather="users" style="width: 48px; height: 48px;"></i>
                                    <p class="mt-1">Belum ada peserta terdaftar</p>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="card-footer">
                        {{ $this->registrations->links() }}
                    </div>
                </div>
            </div>

            {{-- Internal Links Tab --}}
            <div class="tab-pane fade" id="internal-links" role="tabpanel" aria-labelledby="internal-links-tab">
                <div class="card">
                    <div class="card-header border-bottom d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Manajemen Link Internal</h4>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#linkModal" wire:click="resetLinkInput">
                            <i data-feather="plus" class="me-50"></i> Buat Link Baru
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Nama Label</th>
                                    <th>Link / Token</th>
                                    <th>Ikhwan (Isi/Max)</th>
                                    <th>Akhwat (Isi/Max)</th>
                                    <th>Periode Aktif</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($this->internalLinks as $link)
                                    <tr>
                                        <td><strong>{{ $link->name }}</strong></td>
                                        <td>
                                            <div class="input-group input-group-sm" style="width: 300px;">
                                                <input type="text" class="form-control" value="{{ route('events.internal.show', ['slug' => $event->slug, 'token' => $link->token]) }}" readonly id="link-{{ $link->id }}">
                                                <button class="btn btn-outline-primary" type="button" onclick="copyToClipboard('link-{{ $link->id }}')">
                                                    <i data-feather="copy"></i>
                                                </button>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $link->usage_ikhwan >= $link->quota_ikhwan ? 'bg-danger' : 'bg-success' }}">
                                                {{ $link->usage_ikhwan }} / {{ $link->quota_ikhwan }}
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge {{ $link->usage_akhwat >= $link->quota_akhwat ? 'bg-danger' : 'bg-success' }}">
                                                {{ $link->usage_akhwat }} / {{ $link->quota_akhwat }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($link->active_from || $link->active_until)
                                                <small class="d-block">
                                                    Mulai: {{ $link->active_from ? $link->active_from->format('d M Y H:i') : '-' }}
                                                </small>
                                                <small class="d-block">
                                                    Selesai: {{ $link->active_until ? $link->active_until->format('d M Y H:i') : '-' }}
                                                </small>
                                            @else
                                                <span class="badge bg-light-secondary">Selamanya</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button wire:click="editLink({{ $link->id }})" class="btn btn-sm btn-info me-1">
                                                <i data-feather="edit-2"></i>
                                            </button>
                                            <button wire:click="deleteLink({{ $link->id }})" wire:confirm="Hapus link ini?" class="btn btn-sm btn-danger">
                                                <i data-feather="trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4">
                                            <div class="text-muted">
                                                <i data-feather="link" style="width: 48px; height: 48px;"></i>
                                                <p class="mt-1">Belum ada link internal dibuat</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Link Internal --}}
    <div class="modal fade" id="linkModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <h5 class="modal-title">{{ $isEditingLink ? 'Edit Link Internal' : 'Buat Link Internal Baru' }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form wire:submit="saveLink">
                        <div class="mb-1">
                            <label class="form-label">Nama Label (Referensi)</label>
                            <input type="text" wire:model="linkName" class="form-control" placeholder="Contoh: Japri Ustadz Fulan">
                            @error('linkName') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Kuota Ikhwan</label>
                                <input type="number" wire:model="linkQuotaIkhwan" class="form-control" min="0">
                                @error('linkQuotaIkhwan') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Kuota Akhwat</label>
                                <input type="number" wire:model="linkQuotaAkhwat" class="form-control" min="0">
                                @error('linkQuotaAkhwat') <span class="text-danger small d-block">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        <div class="mb-1">
                            <small class="text-muted">Jumlah maksimal yang bisa daftar lewat link ini.</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Aktif Dari (Opsional)</label>
                                <input type="datetime-local" wire:model="linkActiveFrom" class="form-control">
                            </div>
                            <div class="col-md-6 mb-1">
                                <label class="form-label">Aktif Sampai (Opsional)</label>
                                <input type="datetime-local" wire:model="linkActiveUntil" class="form-control">
                            </div>
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">{{ $isEditingLink ? 'Simpan Perubahan' : 'Buat Link' }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Manual Participant --}}
    <div class="modal fade" id="manualParticipantModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-transparent">
                    <h5 class="modal-title">Tambah Peserta Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-info p-1 mb-1">
                        <small>Peserta yang ditambahkan manual akan otomatis berstatus <strong>Valid/Terkonfirmasi</strong> dan akan menambah kuota event.</small>
                    </div>
                    <form wire:submit="addParticipant">
                        <div class="mb-1">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" wire:model="manualName" class="form-control">
                            @error('manualName') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Email</label>
                            <input type="email" wire:model="manualEmail" class="form-control">
                            @error('manualEmail') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-1">
                            <label class="form-label">No. WhatsApp</label>
                            <input type="text" wire:model="manualPhone" class="form-control">
                            @error('manualPhone') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Jenis Kelamin</label>
                            <div class="d-flex gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="manualGender" value="Laki-Laki" id="gL">
                                    <label class="form-check-label" for="gL">Laki-laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="manualGender" value="Perempuan" id="gP">
                                    <label class="form-check-label" for="gP">Perempuan</label>
                                </div>
                            </div>
                            @error('manualGender') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Alamat (Opsional)</label>
                            <textarea wire:model="manualAddress" class="form-control" rows="2"></textarea>
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Password</label>
                            <input type="password" wire:model="manualPassword" class="form-control" value="">
                            @error('manualPassword') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-1">
                            <label class="form-label">Konfirmasi Password</label>
                            <input type="password" wire:model="manualPasswordConfirmation" class="form-control" value="">
                            @error('manualPasswordConfirmation') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>
                        <div class="d-flex justify-content-end mt-2">
                            <button type="button" class="btn btn-secondary me-1" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambahkan Peserta</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Participant Modal -->
    <div wire:ignore.self class="modal fade" id="editParticipantModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form wire:submit.prevent="updateParticipant">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" wire:model="editName" class="form-control">
                        @error('editName') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" wire:model="editEmail" class="form-control">
                        @error('editEmail') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">No. WhatsApp</label>
                        <input type="text" wire:model="editPhone" class="form-control">
                        @error('editPhone') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jenis Kelamin</label>
                        <select wire:model="editGender" class="form-select">
                            <option value="Laki-Laki">Laki-Laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                        @error('editGender') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Alamat / Asal Kota</label>
                        <textarea wire:model="editAddress" class="form-control" rows="2"></textarea>
                        @error('editAddress') <span class="text-danger small">{{ $message }}</span> @enderror
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
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
    function copyToClipboard(elementId) {
        var copyText = document.getElementById(elementId);
        copyText.select();
        copyText.setSelectionRange(0, 99999); /* For mobile devices */
        document.execCommand("copy");
        toastr.success('Link berhasil disalin!');
    }

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
        
        // Link Modals
        const linkModal = new bootstrap.Modal(document.getElementById('linkModal'));
        Livewire.on('open-link-modal', () => {
            linkModal.show();
        });
        Livewire.on('close-link-modal', () => {
            linkModal.hide();
        });
        Livewire.on('link-saved', (message) => {
            linkModal.hide();
            toastr.success(message);
        });
        Livewire.on('link-deleted', (message) => {
            toastr.success(message);
        });

        // Manual Participant Modal
        const manualModal = new bootstrap.Modal(document.getElementById('manualParticipantModal'));
        Livewire.on('close-manual-modal', () => {
            manualModal.hide();
        });
        Livewire.on('participant-added', (message) => {
            manualModal.hide();
            toastr.success(message);
        });

        // Edit Participant Modal
        const editModal = new bootstrap.Modal(document.getElementById('editParticipantModal'));
        Livewire.on('open-edit-participant-modal', () => {
             editModal.show();
        });
        Livewire.on('close-edit-participant-modal', () => {
             editModal.hide();
        });
        Livewire.on('participant-updated', (message) => {
            editModal.hide();
            toastr.success(message);
        });
        Livewire.on('password-reset', (message) => {
            toastr.success(message);
        });
        Livewire.on('bulk-password-reset', (message) => {
            toastr.success(message);
        });
    });
</script>
@endpush
