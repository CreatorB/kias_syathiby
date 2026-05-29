<div>
    <x-links.breadcrumb>
        <x-slot:judul_halaman>Data Pendaftar</x-slot:judul_halaman>
        <x-slot:halaman1 href="{{ route('admin::data_santri') }}">Data Santri</x-slot:halaman1>
        <x-slot:halaman_aktif>Detail Data Pendaftar</x-slot:halaman_aktif>
    </x-links.breadcrumb>

    <div class="row">
        <div class="col-lg-4 col-12">
            <x-cards.user-detail>
<x-slot:photo>
                    @php
                        $photoPath = 'berkas/'.$dataPendaftar->tahun_psb.'/'.$dataPendaftar->kode_registrasi.'/'.$dataPendaftar->photo;
                        $photoExists = file_exists(public_path($photoPath)) && !empty($dataPendaftar->photo);
                    @endphp
                    @if($photoExists)
                        <img class="img-fluid rounded mt-3 mb-2" src="{{ asset($photoPath) }}" height="210" width="210" />
                    @else
                        <div class="bg-light rounded mt-3 mb-2 d-flex align-items-center justify-content-center" style="height: 210px; width: 210px;">
                            <i class="ti ti-user" style="font-size: 4rem; color: #ccc;"></i>
                        </div>
                    @endif
                </x-slot:photo>
                <x-slot:nama>{{ $dataPendaftar->nama }}</x-slot:nama>
                <x-slot:subtitle>{{ $dataPendaftar->kode_registrasi }}</x-slot:subtitle>
                <x-slot:judul_fitur>Program</x-slot:judul_fitur>
                <x-slot:keterangan_fitur>{{ $dataPendaftar->program?->nama_program }}</x-slot:keterangan_fitur>
                <x-slot:judul_informasi>Informasi Penting</x-slot:judul_informasi>
                <x-slot:informasi>
                    <li class="mb-1">Jenis Kelamin : {{ $dataPendaftar->jk }}</li>
                    <li class="mb-1">Email : {{ $dataPendaftar->email }}</li>
                    <li class="mb-1">No. HP : +{{ $dataPendaftar->hp }}</li>
                    <li class="mb-1">Tahun Ajaran : {{ $dataPendaftar->tahun_psb }}</li>
                    <li class="mb-1">NIK : {{ $dataPendaftar->nik }}</li>
                    <li class="mb-1">NISN : {{ $dataPendaftar->nisn }}</li>
                </x-slot:informasi>
            </x-cards.user-detail>
        </div>

        <div class="col-lg-8 col-12">
            <!-- Data Diri -->
            <x-cards.basic-card>
                <x-slot:cardHeader>Data Diri</x-slot:cardHeader>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-12 mb-2">
                        <h6 class="text-muted small mb-1">Tempat Lahir</h6>
                        <span>{{ $dataPendaftar->tmp_lahir }}</span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-2">
                        <h6 class="text-muted small mb-1">Tanggal Lahir</h6>
                        <span>{{ \App\Helpers\TanggalHelper::konversiTanggal($dataPendaftar->tgl_lahir) }}</span>
                    </div>
                    <div class="col-12 mb-2">
                        <h6 class="text-muted small mb-1">Alamat Lengkap</h6>
                        <span>{{ $dataPendaftar->alamat }}</span>
                    </div>
                </div>
            </x-cards.basic-card>

            <!-- Data Orang Tua/Wali -->
            <x-cards.basic-card>
                <x-slot:cardHeader>Data Orang Tua/Wali</x-slot:cardHeader>
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">Nama Ayah</h6>
                        <span>{{ $dataPendaftar->nama_ayah ?? '-' }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">No. HP Ayah</h6>
                        <span>{{ $dataPendaftar->no_hp_ayah ? '+'.$dataPendaftar->kode_negara.$dataPendaftar->no_hp_ayah : '-' }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">Nama Ibu</h6>
                        <span>{{ $dataPendaftar->nama_ibu ?? '-' }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">No. HP Ibu</h6>
                        <span>{{ $dataPendaftar->no_hp_ibu ? '+'.$dataPendaftar->kode_negara.$dataPendaftar->no_hp_ibu : '-' }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">Nama Wali</h6>
                        <span>{{ $dataPendaftar->nama_wali ?? '-' }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">No. HP Wali</h6>
                        <span>{{ $dataPendaftar->no_hp_wali ? '+'.$dataPendaftar->kode_negara.$dataPendaftar->no_hp_wali : '-' }}</span>
                    </div>
                </div>
            </x-cards.basic-card>

            <!-- Lampiran Dokumen -->
            <x-cards.basic-card>
                <x-slot:cardHeader>Lampiran Dokumen</x-slot:cardHeader>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <h6 class="text-muted small mb-1">Photo</h6>
                        @php
                            $photoPath = 'berkas/'.$dataPendaftar->tahun_psb.'/'.$dataPendaftar->kode_registrasi.'/'.$dataPendaftar->photo;
                            $photoExists = file_exists(public_path($photoPath)) && !empty($dataPendaftar->photo);
                        @endphp
                        @if($photoExists)
                            <a href="{{ asset($photoPath) }}" target="_blank">
                                <img class="img-fluid rounded" src="{{ asset($photoPath) }}" height="auto" width="150" />
                            </a>
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px; width: 150px;">
                                <span class="text-muted small"><i class="ti ti-photo-off me-1"></i>Tidak ada</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <h6 class="text-muted small mb-1">KTP</h6>
                        @php
                            $ktpPath = 'berkas/'.$dataPendaftar->tahun_psb.'/'.$dataPendaftar->kode_registrasi.'/'.$dataPendaftar->ktp;
                            $ktpExists = file_exists(public_path($ktpPath)) && !empty($dataPendaftar->ktp);
                        @endphp
                        @if($ktpExists)
                            <a href="{{ asset($ktpPath) }}" target="_blank">
                                <img class="img-fluid rounded" src="{{ asset($ktpPath) }}" height="auto" width="150" />
                            </a>
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px; width: 150px;">
                                <span class="text-muted small"><i class="ti ti-photo-off me-1"></i>Tidak ada</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-4 col-md-6 col-12 mb-3">
                        <h6 class="text-muted small mb-1">Ijazah</h6>
                        @php
                            $ijazahPath = 'berkas/'.$dataPendaftar->tahun_psb.'/'.$dataPendaftar->kode_registrasi.'/'.$dataPendaftar->ijazah;
                            $ijazahExists = file_exists(public_path($ijazahPath)) && !empty($dataPendaftar->ijazah);
                        @endphp
                        @if($ijazahExists)
                            <a href="{{ asset($ijazahPath) }}" target="_blank">
                                <img class="img-fluid rounded" src="{{ asset($ijazahPath) }}" height="auto" width="150" />
                            </a>
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px; width: 150px;">
                                <span class="text-muted small"><i class="ti ti-photo-off me-1"></i>Tidak ada</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <h6 class="text-muted small mb-1">Bukti Transfer</h6>
                        @php
                            $transferPath = 'berkas/'.$dataPendaftar->tahun_psb.'/'.$dataPendaftar->kode_registrasi.'/'.$dataPendaftar->transfer;
                            $transferExists = file_exists(public_path($transferPath)) && !empty($dataPendaftar->transfer);
                        @endphp
                        @if($transferExists)
                            <a href="{{ asset($transferPath) }}" target="_blank">
                                <img class="img-fluid rounded" src="{{ asset($transferPath) }}" height="auto" width="200" />
                            </a>
                        @else
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 100px; width: 200px;">
                                <span class="text-muted small"><i class="ti ti-photo-off me-1"></i>Tidak ada</span>
                            </div>
                        @endif
                    </div>
                    <div class="col-lg-6 col-md-6 col-12 mb-3">
                        <h6 class="text-muted small mb-1">Nominal Transfer</h6>
                        <strong>Rp {{ number_format($dataPendaftar->nominal_transfer ?? 0, 0, ',', '.') }}</strong>
                    </div>
                </div>
            </x-cards.basic-card>

            @if($dataPendaftar->status_pendaftaran == 'Menunggu')
            <div class="d-grid gap-2 mb-3">
                <button type="button" class="btn btn-success btn-lg" wire:click="approve" wire:confirm="Terima pendaftaran ini?">
                    <i class="ti ti-check me-2"></i> TERIMA PENDAFTARAN
                </button>
                <button type="button" class="btn btn-danger btn-lg" data-bs-toggle="modal" data-bs-target="#rejectModal">
                    <i class="ti ti-x me-2"></i> TOLAK PENDAFTARAN
                </button>
            </div>

            <div class="modal fade" id="rejectModal" tabindex="-1" aria-hidden="true" wire:ignore.self>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Pendaftaran</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Alasan Penolakan</label>
                                <textarea wire:model="alasan" class="form-control" rows="3" required placeholder="Masukkan alasan penolakan..."></textarea>
                                @error('alasan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-danger" wire:click="reject" data-bs-dismiss="modal">Tolak Pendaftaran</button>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Status -->
            <x-cards.basic-card>
                <x-slot:cardHeader>Status Pendaftaran</x-slot:cardHeader>
                <div class="row">
                    <div class="col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">Status Pendaftaran</h6>
                        <span class="badge bg-{{ $dataPendaftar->status_pendaftaran == 'Diterima' ? 'success' : ($dataPendaftar->status_pendaftaran == 'Ditolak' ? 'danger' : 'warning') }}">
                            {{ $dataPendaftar->status_pendaftaran }}
                        </span>
                    </div>
                    <div class="col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">Status Transfer</h6>
                        <span class="badge bg-{{ $dataPendaftar->status_transfer == 'Valid' ? 'success' : ($dataPendaftar->status_transfer == 'Invalid' ? 'danger' : 'warning') }}">
                            {{ $dataPendaftar->status_transfer ?? 'Menunggu' }}
                        </span>
                    </div>
                    <div class="col-md-4 col-12 mb-2">
                        <h6 class="text-muted small mb-1">Tanggal Daftar</h6>
                        <span>{{ \App\Helpers\TanggalHelper::hariTanggalWaktu($dataPendaftar->created_at) }}</span>
                    </div>
                    @if($dataPendaftar->alasan_penolakan)
                    <div class="col-12 mt-2">
                        <div class="alert alert-danger">
                            <i class="ti ti-alert-circle me-2"></i>
                            <strong>Alasan Penolakan:</strong> {{ $dataPendaftar->alasan_penolakan }}
                        </div>
                    </div>
                    @endif
                </div>
            </x-cards.basic-card>

            <div class="row">
                <div class="col-12">
                    <x-buttons.outline color="dark" onclick="window.history.back()">
                        <x-slot:icon><i data-feather='arrow-left'></i></x-slot:icon>
                        Kembali
                    </x-buttons.outline>
                </div>
            </div>
        </div>
    </div>
</div>
