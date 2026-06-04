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
                            {{-- Data Diri --}}
                            <h5 class="mb-2 text-primary"><i data-feather="info" class="me-50"></i>Data Diri</h5>
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror"
                                        id="nama" wire:model="nama" placeholder="Masukkan nama lengkap">
                                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="email">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        id="email" wire:model="email" placeholder="Masukkan email">
                                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="phone">No. Telepon / WhatsApp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                        id="phone" wire:model="phone" placeholder="Contoh: 08123456789">
                                    @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

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

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="birth_place">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('birth_place') is-invalid @enderror"
                                        id="birth_place" wire:model="birth_place" placeholder="Contoh: Jakarta">
                                    @error('birth_place') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="birth_date">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror"
                                        id="birth_date" wire:model="birth_date">
                                    @error('birth_date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="occupation">Pekerjaan (User)</label>
                                    <input type="text" class="form-control @error('occupation') is-invalid @enderror"
                                        id="occupation" wire:model="occupation" placeholder="Contoh: Mahasiswa, Wiraswasta">
                                    @error('occupation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 mb-1">
                                    <label class="form-label" for="address">Alamat</label>
                                    <textarea class="form-control @error('address') is-invalid @enderror"
                                        id="address" wire:model="address" rows="2" placeholder="Masukkan alamat lengkap"></textarea>
                                    @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            @if($has_santri)
                            <hr class="my-3">
                            <h5 class="mb-2 text-primary"><i data-feather="book-open" class="me-50"></i>Data Pendaftaran Santri</h5>

                            {{-- Data Santri --}}
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="nik">NIK</label>
                                    <input type="text" class="form-control @error('nik') is-invalid @enderror"
                                        id="nik" wire:model="nik" maxlength="16" placeholder="16 digit NIK">
                                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="nisn">NISN</label>
                                    <input type="text" class="form-control @error('nisn') is-invalid @enderror"
                                        id="nisn" wire:model="nisn" maxlength="10" placeholder="10 digit NISN">
                                    @error('nisn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="tmp_lahir">Tempat Lahir</label>
                                    <input type="text" class="form-control @error('tmp_lahir') is-invalid @enderror"
                                        id="tmp_lahir" wire:model="tmp_lahir" placeholder="Kota/Kabupaten">
                                    @error('tmp_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="tgl_lahir">Tanggal Lahir</label>
                                    <input type="date" class="form-control @error('tgl_lahir') is-invalid @enderror"
                                        id="tgl_lahir" wire:model="tgl_lahir">
                                    @error('tgl_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="no_hp">No. HP Santri</label>
                                    <input type="text" class="form-control @error('no_hp') is-invalid @enderror"
                                        id="no_hp" wire:model="no_hp" placeholder="Contoh: 08123456789">
                                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="kode_negara">Kode Negara</label>
                                    <select class="form-select @error('kode_negara') is-invalid @enderror"
                                        id="kode_negara" wire:model="kode_negara">
                                        <option value="62">+62 (Indonesia)</option>
                                        <option value="60">+60 (Malaysia)</option>
                                        <option value="65">+65 (Singapura)</option>
                                    </select>
                                    @error('kode_negara') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-12 mb-1">
                                    <label class="form-label" for="alamat">Alamat Lengkap</label>
                                    <textarea class="form-control @error('alamat') is-invalid @enderror"
                                        id="alamat" wire:model="alamat" rows="2" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten"></textarea>
                                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr class="my-3">
                            <h5 class="mb-2 text-primary"><i data-feather="users" class="me-50"></i>Data Orang Tua / Wali</h5>

                            {{-- Data Orang Tua --}}
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="nama_ayah">Nama Ayah</label>
                                    <input type="text" class="form-control @error('nama_ayah') is-invalid @enderror"
                                        id="nama_ayah" wire:model="nama_ayah" placeholder="Nama lengkap ayah">
                                    @error('nama_ayah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="no_hp_ayah">No. HP Ayah</label>
                                    <input type="text" class="form-control @error('no_hp_ayah') is-invalid @enderror"
                                        id="no_hp_ayah" wire:model="no_hp_ayah" placeholder="Contoh: 08123456789">
                                    @error('no_hp_ayah') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="nama_ibu">Nama Ibu</label>
                                    <input type="text" class="form-control @error('nama_ibu') is-invalid @enderror"
                                        id="nama_ibu" wire:model="nama_ibu" placeholder="Nama lengkap ibu">
                                    @error('nama_ibu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="no_hp_ibu">No. HP Ibu</label>
                                    <input type="text" class="form-control @error('no_hp_ibu') is-invalid @enderror"
                                        id="no_hp_ibu" wire:model="no_hp_ibu" placeholder="Contoh: 08123456789">
                                    @error('no_hp_ibu') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="nama_wali">Nama Wali</label>
                                    <input type="text" class="form-control @error('nama_wali') is-invalid @enderror"
                                        id="nama_wali" wire:model="nama_wali" placeholder="Nama lengkap wali">
                                    @error('nama_wali') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="no_hp_wali">No. HP Wali</label>
                                    <input type="text" class="form-control @error('no_hp_wali') is-invalid @enderror"
                                        id="no_hp_wali" wire:model="no_hp_wali" placeholder="Contoh: 08123456789">
                                    @error('no_hp_wali') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <hr class="my-3">
                            <h5 class="mb-2 text-primary"><i data-feather="award" class="me-50"></i>Pendidikan & Pekerjaan</h5>

                            {{-- Pendidikan & Pekerjaan --}}
                            <div class="row">
                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="pendidikan">Pendidikan Terakhir</label>
                                    <select class="form-select @error('pendidikan') is-invalid @enderror"
                                        id="pendidikan" wire:model="pendidikan">
                                        <option value="">-- Pilih --</option>
                                        <option value="Tidak Ada">Tidak Ada</option>
                                        <option value="SD/MI">SD/MI</option>
                                        <option value="SMP/MTS">SMP/MTS</option>
                                        <option value="SMA/SMK/MA">SMA/SMK/MA</option>
                                        <option value="Akademi">Akademi</option>
                                        <option value="D1">D1</option>
                                        <option value="D2">D2</option>
                                        <option value="D3">D3</option>
                                        <option value="Sarjana (S1)">Sarjana (S1)</option>
                                        <option value="Magister (S2)">Magister (S2)</option>
                                        <option value="Doktor (S3)">Doktor (S3)</option>
                                    </select>
                                    @error('pendidikan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-1">
                                    <label class="form-label" for="pekerjaan">Pekerjaan</label>
                                    <input type="text" class="form-control @error('pekerjaan') is-invalid @enderror"
                                        id="pekerjaan" wire:model="pekerjaan" placeholder="Contoh: Pelajar, Mahasiswa, Guru, Wiraswasta">
                                    @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                            @endif

                            <div class="mt-2">
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
