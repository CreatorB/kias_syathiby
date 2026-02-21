<div>
    {{-- Breadcrumb --}}
    <x-breadcrumb title="Pengaturan Akun" parent="Dashboard" parentLink="#" current="Pengaturan" />

    <div class="content-body">
        <div class="row">
            {{-- Profile Section --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">
                            <i data-feather="user" class="me-50"></i> Informasi Profil
                        </h4>
                    </div>
                    <div class="card-body pt-2">
                        @if(session()->has('profile_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i data-feather="check-circle" class="me-50"></i>
                                {{ session('profile_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form wire:submit="updateProfile">
                            <div class="row">
                                {{-- Nama Lengkap --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" wire:model="nama" placeholder="Masukkan nama lengkap">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Email --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" wire:model="email" placeholder="Masukkan email">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- No. Telepon --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="phone">No. Telepon / WhatsApp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" wire:model="phone" placeholder="Contoh: 08123456789">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Jenis Kelamin --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="gender">Jenis Kelamin</label>
                                    <select class="form-select @error('gender') is-invalid @enderror"
                                        id="gender" wire:model="gender">
                                        <option value="">-- Pilih --</option>
                                        <option value="Laki-Laki">Laki-Laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                    @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Tempat Lahir --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="birth_place">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                        id="birth_place" wire:model="birth_place" placeholder="Contoh: Jakarta">
                                    @error('birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Tanggal Lahir --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="birth_date">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                        id="birth_date" wire:model="birth_date">
                                    @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Pekerjaan --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="occupation">Pekerjaan</label>
                                    <input type="text" class="form-control @error('occupation') is-invalid @enderror"
                                        id="occupation" wire:model="occupation" placeholder="Contoh: Mahasiswa, Wiraswasta">
                                    @error('occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                {{-- Alamat --}}
                                <div class="col-12 mb-1">
                                    <label class="form-label" for="address">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                        id="address" wire:model="address" rows="3" placeholder="Masukkan alamat lengkap"></textarea>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mt-1">
                                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="updateProfile">
                                        <i data-feather="save" class="me-25"></i> Simpan Profil
                                    </span>
                                    <span wire:loading wire:target="updateProfile">
                                        <span class="spinner-border spinner-border-sm me-25"></span> Menyimpan...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Password Section --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header border-bottom">
                        <h4 class="card-title">
                            <i data-feather="lock" class="me-50"></i> Ganti Password
                        </h4>
                    </div>
                    <div class="card-body pt-2">
                        @if(session()->has('password_success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i data-feather="check-circle" class="me-50"></i>
                                {{ session('password_success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form wire:submit="updatePassword">
                            <div class="row">
                                {{-- Password Lama --}}
                                <div class="col-md-12 mb-1">
                                    <label class="form-label" for="current_password">Password Lama <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" class="form-control @error('current_password') is-invalid @enderror"
                                            id="current_password" wire:model="current_password" placeholder="Masukkan password lama">
                                    </div>
                                    @error('current_password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                {{-- Password Baru --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="new_password">Password Baru <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror"
                                        id="new_password" wire:model="new_password" placeholder="Minimal 8 karakter">
                                    @error('new_password') <span class="text-danger small">{{ $message }}</span> @enderror
                                </div>

                                {{-- Konfirmasi Password --}}
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="new_password_confirmation">Konfirmasi Password Baru <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control"
                                        id="new_password_confirmation" wire:model="new_password_confirmation" placeholder="Ulangi password baru">
                                </div>
                            </div>

                            <div class="mt-1">
                                <button type="submit" class="btn btn-warning" wire:loading.attr="disabled">
                                    <span wire:loading.remove wire:target="updatePassword">
                                        <i data-feather="key" class="me-25"></i> Ganti Password
                                    </span>
                                    <span wire:loading wire:target="updatePassword">
                                        <span class="spinner-border spinner-border-sm me-25"></span> Memproses...
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
