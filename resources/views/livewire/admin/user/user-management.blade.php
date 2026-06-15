<div>
    @php
        $roleColors = [
            1 => 'primary',
            2 => 'info', 
            3 => 'success',
            4 => 'warning'
        ];
    @endphp

    @session('success')
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Berhasil!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    @session('error')
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Gagal!</strong> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endsession

    <div class="card">
        <div class="card-header">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <h5 class="mb-0">Manajemen User</h5>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" placeholder="Cari nama atau email..." 
                           wire:model.live.debounce.300ms="search" autocomplete="off">
                </div>
                <div class="col-md-3">
                    <select class="form-select" wire:model.live="roleFilter">
                        <option value="">Semua Role</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 text-end">
                    <button class="btn btn-primary" wire:click="openModal()">
                        <i class="ti ti-plus me-1"></i> Tambah User
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Akun</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $index => $user)
                        <tr>
                            <td>{{ $index + $users->firstItem() }}</td>
                            <td>{{ $user->nama ?? '-' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge bg-{{ $roleColors[$user->role_id] ?? 'secondary' }}">
                                    {{ $user->role->nama_role ?? 'Role ' . $user->role_id }}
                                </span>
                            </td>
                            <td>
                                @if($user->is_active)
                                <span class="badge bg-success">Aktif</span>
                                @else
                                <span class="badge bg-warning">Pending</span>
                                @endif
                            </td>
                            <td>
                                @if($user->isBanned())
                                <span class="badge bg-danger">Diblokir</span>
                                @else
                                <span class="badge bg-secondary">Normal</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                        <i class="ti ti-dots-vertical"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" wire:click="openModal({{ $user->id }})">
                                                <i class="ti ti-edit me-1"></i> Edit
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" wire:click="toggleBan({{ $user->id }})">
                                                <i class="ti {{ $user->isBanned() ? 'ti-user-check' : 'ti-user-off' }} me-1"></i>
                                                {{ $user->isBanned() ? 'Unban' : 'Ban' }}
                                            </a>
                                        </li>
                                        @if(!$user->isRoot())
                                        <li>
                                            <a class="dropdown-item text-danger" href="javascript:void(0);" wire:click="confirmDelete({{ $user->id }})">
                                                <i class="ti ti-trash me-1"></i> Hapus
                                            </a>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data user</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($showModal)
    <div class="modal fade show" id="userModal" tabindex="-1" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $isEdit ? 'Edit User' : 'Tambah User' }}</h5>
                    <button type="button" class="btn-close" wire:click="closeModal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                               wire:model="nama" placeholder="Masukkan nama">
                        @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               wire:model="email" placeholder="Masukkan email">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password {{ $isEdit ? '(kosongkan jika tidak diubah)' : '' }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               wire:model="password" placeholder="{{ $isEdit ? 'Kosongkan jika tidak diubah' : 'Masukkan password' }}">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role</label>
                        <select class="form-select @error('role_id') is-invalid @enderror" wire:model="role_id">
                            <option value="">Pilih Role</option>
                            @foreach($roles as $role)
                            <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="is_active" wire:model="is_active">
                            <label class="form-check-label" for="is_active">Aktif</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="closeModal">Batal</button>
                    <button type="button" class="btn btn-primary" wire:click="save">
                        <span wire:loading.remove wire:target="save"><i class="ti ti-device-floppy me-1"></i> Simpan</span>
                        <span wire:loading wire:target="save"><i class="ti ti-loader me-1"></i> Menyimpan...</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif

    <!-- Delete Confirmation Modal -->
    @if($showDeleteModal)
    <div class="modal fade show" id="deleteModal" tabindex="-1" style="display: block;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" wire:click="cancelDelete" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus user ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="cancelDelete">Batal</button>
                    <button type="button" class="btn btn-danger" wire:click="delete">
                        <i class="ti ti-trash me-1"></i> Hapus
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-backdrop fade show"></div>
    @endif
</div>