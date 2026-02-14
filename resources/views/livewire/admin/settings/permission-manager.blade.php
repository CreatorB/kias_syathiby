<div>
    {{-- Breadcrumb --}}
    <x-breadcrumb title="Manajemen Hak Akses" parent="Dashboard" parentLink="{{ route('admin::dashboard') }}"
        current="Hak Akses" />

    <div class="content-body">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            {{-- Role Selection --}}
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pilih Role</h4>
                    </div>
                    <div class="card-body">
                        <div class="list-group">
                            @foreach ($this->roles as $role)
                                <button type="button" wire:click="$set('selectedRole', {{ $role->id }})"
                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center {{ $selectedRole == $role->id ? 'active' : '' }}">
                                    <span>
                                        <i data-feather="users" class="me-2" style="width: 16px;"></i>
                                        {{ ucfirst($role->nama_role) }}
                                    </span>
                                    <span class="badge bg-{{ $selectedRole == $role->id ? 'light text-primary' : 'primary' }} rounded-pill">
                                        {{ $role->permissions->count() }}
                                    </span>
                                </button>
                            @endforeach
                        </div>

                        @if ($selectedRole)
                            <div class="mt-3">
                                <div class="d-grid gap-2">
                                    <button wire:click="grantAllPermissions" class="btn btn-success btn-sm"
                                        wire:confirm="Berikan semua hak akses ke role ini?">
                                        <i data-feather="check-circle" class="me-1" style="width: 14px;"></i>
                                        Berikan Semua
                                    </button>
                                    <button wire:click="revokeAllPermissions" class="btn btn-danger btn-sm"
                                        wire:confirm="Cabut semua hak akses dari role ini?">
                                        <i data-feather="x-circle" class="me-1" style="width: 14px;"></i>
                                        Cabut Semua
                                    </button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Permissions List --}}
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            Hak Akses
                            @if ($selectedRole)
                                <span class="text-muted">- {{ ucfirst($this->roles->firstWhere('id', $selectedRole)?->nama_role ?? '') }}</span>
                            @endif
                        </h4>
                    </div>
                    <div class="card-body">
                        @if ($selectedRole)
                            @foreach ($this->permissions as $group => $groupPermissions)
                                <div class="mb-4">
                                    <h5 class="text-uppercase text-muted mb-3">
                                        <i data-feather="folder" class="me-1" style="width: 16px;"></i>
                                        {{ $group ?: 'Umum' }}
                                    </h5>
                                    <div class="row">
                                        @foreach ($groupPermissions as $permission)
                                            <div class="col-md-6 mb-2">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox"
                                                        id="perm_{{ $permission->id }}"
                                                        wire:click="togglePermission({{ $permission->id }})"
                                                        {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="perm_{{ $permission->id }}">
                                                        <strong>{{ $permission->display_name }}</strong>
                                                        @if ($permission->description)
                                                            <br>
                                                            <small class="text-muted">{{ $permission->description }}</small>
                                                        @endif
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i data-feather="shield" style="width: 48px; height: 48px;" class="text-muted mb-3"></i>
                                <p class="text-muted">Pilih role untuk mengatur hak akses</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
