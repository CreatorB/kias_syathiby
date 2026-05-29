<div>
    <x-breadcrumb title="Pengaturan PSB" parent="Pendaftaran" parentLink="{{ route('admin::data_santri') }}" current="Pengaturan" />

    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Pengaturan Pendaftaran Santri Baru (PSB)</h4>
                    </div>
                    <div class="card-body">
                        @if(session()->has('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <div class="alert-body">
                                    <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form wire:submit="save">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="tahun_ajaran">Tahun Ajaran <span class="text-danger">*</span></label>
                                        <input type="text" wire:model="tahun_ajaran" id="tahun_ajaran"
                                            class="form-control @error('tahun_ajaran') is-invalid @enderror"
                                            placeholder="Contoh: 2026/2027">
                                        @error('tahun_ajaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="biaya_pendaftaran">Biaya Pendaftaran (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" wire:model="biaya_pendaftaran" id="biaya_pendaftaran"
                                            class="form-control @error('biaya_pendaftaran') is-invalid @enderror"
                                            placeholder="Contoh: 50000" min="0">
                                        @error('biaya_pendaftaran')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="biaya_sarana_prasana">Biaya Sarana Prasarana (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" wire:model="biaya_sarana_prasana" id="biaya_sarana_prasana"
                                            class="form-control @error('biaya_sarana_prasana') is-invalid @enderror"
                                            placeholder="Contoh: 300000" min="0">
                                        @error('biaya_sarana_prasana')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="biaya_kuliah_perdana">Biaya Kuliah Perdana (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" wire:model="biaya_kuliah_perdana" id="biaya_kuliah_perdana"
                                            class="form-control @error('biaya_kuliah_perdana') is-invalid @enderror"
                                            placeholder="Contoh: 250000" min="0">
                                        @error('biaya_kuliah_perdana')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="biaya_spp_bulanan">SPP Bulanan (Rp) <span class="text-danger">*</span></label>
                                        <input type="number" wire:model="biaya_spp_bulanan" id="biaya_spp_bulanan"
                                            class="form-control @error('biaya_spp_bulanan') is-invalid @enderror"
                                            placeholder="Contoh: 250000" min="0">
                                        @error('biaya_spp_bulanan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="link_group">Link Group Komunikasi</label>
                                        <input type="url" wire:model="link_group" id="link_group"
                                            class="form-control @error('link_group') is-invalid @enderror"
                                            placeholder="https://chat.whatsapp.com/... atau https://t.me/... atau https://discord.gg/...">
                                        @error('link_group')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Link grup WhatsApp, Telegram, atau Discord untuk komunikasi dengan peserta.
                                        </small>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="manual_password">Password Pendaftaran Manual</label>
                                        <input type="password" wire:model="manual_password" id="manual_password"
                                            class="form-control @error('manual_password') is-invalid @enderror"
                                            placeholder="Minimal 4 karakter (kosongkan untuk nonaktifkan)">
                                        @error('manual_password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Password untuk halaman /psb-manual. Kosongkan untuk menonaktifkan.
                                        </small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Status Pendaftaran</label>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="radio" wire:model="status_psb"
                                                        id="status_buka" value="Buka">
                                                    <label class="form-check-label" for="status_buka">
                                                        <span class="badge bg-success"><i class="fas fa-lock-open me-1"></i> BUKA</span>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-check form-check-primary">
                                                    <input class="form-check-input" type="radio" wire:model="status_psb"
                                                        id="status_tutup" value="Tutup">
                                                    <label class="form-check-label" for="status_tutup">
                                                        <span class="badge bg-danger"><i class="fas fa-lock me-1"></i> TUTUP</span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <small class="text-muted d-block mt-1">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Status manual. Jika jadwal diatur, sistem akan auto open/close sesuai jadwal.
                                        </small>
                                    </div>

                                    @if($psb)
                                    <div class="alert alert-info py-2">
                                        <div class="d-flex align-items-center">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <div>
                                                <strong>Status Saat Ini:</strong>
                                                @if($psb->isOpen())
                                                    <span class="badge bg-success ms-1">BUKA</span>
                                                @else
                                                    <span class="badge bg-danger ms-1">TUTUP</span>
                                                @endif
                                                @if($psb->datetime_open && $psb->datetime_closed)
                                                    <br><small>Jadwal: {{ $psb->datetime_open->format('d M Y H:i') }} - {{ $psb->datetime_closed->format('d M Y H:i') }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3"><i class="fas fa-calendar-alt me-2 text-info"></i>Jadwal Pendaftaran (Auto Open/Close)</h5>
                            <p class="text-muted small mb-3">Kosongkan jadwal jika hanya ingin menggunakan switch status manual di atas.</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="datetime_open">Tanggal & Waktu Buka</label>
                                        <div class="input-group">
                                            <input type="datetime-local" wire:model="datetime_open" id="datetime_open"
                                                class="form-control @error('datetime_open') is-invalid @enderror">
                                            <button type="button" wire:click="clearDatetimeOpen"
                                                class="btn btn-outline-secondary" title="Kosongkan">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        @error('datetime_open')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Kosongkan jika tidak ada jadwal spesifik</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="datetime_closed">Tanggal & Waktu Tutup</label>
                                        <div class="input-group">
                                            <input type="datetime-local" wire:model="datetime_closed" id="datetime_closed"
                                                class="form-control @error('datetime_closed') is-invalid @enderror">
                                            <button type="button" wire:click="clearDatetimeClosed"
                                                class="btn btn-outline-secondary" title="Kosongkan">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                        @error('datetime_closed')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3"><i class="fas fa-users-cog me-2 text-info"></i>Kuota Peserta</h5>
                            <p class="text-muted small mb-3">Kosongkan jika tidak ada batasan kuota (unlimited). Pendaftar tidak bisa mendaftar jika kuota sudah habis.</p>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="quota_ikhwan">
                                            <i class="fas fa-male text-primary me-1"></i> Kuota Ikhwan (Laki-laki)
                                        </label>
                                        <div class="input-group">
                                            <input type="number" wire:model="quota_ikhwan" id="quota_ikhwan"
                                                class="form-control @error('quota_ikhwan') is-invalid @enderror"
                                                placeholder="Contoh: 50" min="0">
                                            <button type="button" wire:click="clearQuotaIkhwan"
                                                class="btn btn-outline-secondary" title="Unlimited">
                                                <i class="fas fa-infinity"></i>
                                            </button>
                                        </div>
                                        @error('quota_ikhwan')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        @if($psb)
                                            <small class="text-muted d-block mt-1">
                                                Terdaftar: <strong>{{ $psb->registered_ikhwan_count }}</strong> orang
                                                @if($psb->quota_ikhwan)
                                                    (Sisa: {{ $psb->remaining_quota_ikhwan }})
                                                @else
                                                    (Unlimited)
                                                @endif
                                            </small>
                                            @if($psb->quota_ikhwan)
                                                <div class="progress mt-1" style="height: 6px;">
                                                    @php $percent = min(100, ($psb->registered_ikhwan_count / $psb->quota_ikhwan) * 100); @endphp
                                                    <div class="progress-bar {{ $percent >= 90 ? 'bg-danger' : ($percent >= 70 ? 'bg-warning' : 'bg-success') }}"
                                                        role="progressbar" style="width: {{ $percent }}%"></div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="quota_akhwat">
                                            <i class="fas fa-female text-danger me-1"></i> Kuota Akhwat (Perempuan)
                                        </label>
                                        <div class="input-group">
                                            <input type="number" wire:model="quota_akhwat" id="quota_akhwat"
                                                class="form-control @error('quota_akhwat') is-invalid @enderror"
                                                placeholder="Contoh: 50" min="0">
                                            <button type="button" wire:click="clearQuotaAkhwat"
                                                class="btn btn-outline-secondary" title="Unlimited">
                                                <i class="fas fa-infinity"></i>
                                            </button>
                                        </div>
                                        @error('quota_akhwat')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        @if($psb)
                                            <small class="text-muted d-block mt-1">
                                                Terdaftar: <strong>{{ $psb->registered_akhwat_count }}</strong> orang
                                                @if($psb->quota_akhwat)
                                                    (Sisa: {{ $psb->remaining_quota_akhwat }})
                                                @else
                                                    (Unlimited)
                                                @endif
                                            </small>
                                            @if($psb->quota_akhwat)
                                                <div class="progress mt-1" style="height: 6px;">
                                                    @php $percent = min(100, ($psb->registered_akhwat_count / $psb->quota_akhwat) * 100); @endphp
                                                    <div class="progress-bar {{ $percent >= 90 ? 'bg-danger' : ($percent >= 70 ? 'bg-warning' : 'bg-success') }}"
                                                        role="progressbar" style="width: {{ $percent }}%"></div>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <h5 class="mb-3"><i class="fas fa-edit me-2 text-info"></i>Konten Halaman PSB (WYSIWYG)</h5>
                            <p class="text-muted small mb-3">Konten ini akan ditampilkan di halaman informasi PSB. Gunakan editor untuk mengatur teks, gambar, dan layout.</p>

                            <div wire:ignore>
                                <div id="quill-editor">{!! $konten_psb !!}</div>
                            </div>
                            <input type="hidden" id="konten-psb-input" wire:model="konten_psb">

                            <hr class="my-4">

                            <div class="d-flex justify-content-end gap-2">
                                <button type="reset" class="btn btn-secondary">
                                    <i class="fas fa-undo me-1"></i> Reset
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Pengaturan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('vendorCss')
<link rel="stylesheet" type="text/css"
    href="{{ asset('style/app-assets/vendors/css/editors/quill/katex.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('style/app-assets/vendors/css/editors/quill/quill.snow.css') }}">
@endpush

@push('vendorJS')
<script src="{{ asset('style/app-assets/vendors/js/editors/quill/katex.min.js') }}"></script>
<script src="{{ asset('style/app-assets/vendors/js/editors/quill/quill.min.js') }}"></script>
@endpush

@push('pageJS')
<script>
    document.addEventListener('livewire:initialized', () => {
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    ['blockquote', 'code-block'],
                    [{ 'header': 1 }, { 'header': 2 }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    [{ 'indent': '-1' }, { 'indent': '+1' }],
                    [{ 'direction': 'rtl' }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'font': [] }],
                    [{ 'align': [] }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        });

        quill.on('text-change', function() {
            let content = quill.root.innerHTML;
            if (content === '<p><br></p>') {
                content = '';
            }
            @this.set('konten_psb', content);
        });
    });
</script>
@endpush