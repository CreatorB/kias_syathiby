<div>
    {{-- Breadcrumb --}}
    <x-breadcrumb title="{{ $eventId ? 'Edit Event' : 'Buat Event' }}" parent="Events"
        parentLink="{{ route('admin::events.index') }}" current="{{ $eventId ? 'Edit' : 'Buat' }}" />

    <div class="content-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $eventId ? 'Edit Event' : 'Buat Event Baru' }}</h4>
                    </div>
                    <div class="card-body">
                        <form wire:submit="save">
                            <div class="row">
                                {{-- Left Column --}}
                                <div class="col-md-8">
                                    {{-- Title --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="title">Judul Event <span
                                                class="text-danger">*</span></label>
                                        <input type="text" wire:model="title" id="title"
                                            class="form-control @error('title') is-invalid @enderror"
                                            placeholder="Masukkan judul event">
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Content --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="content">Deskripsi Event <span
                                                class="text-danger">*</span></label>
                                        <div wire:ignore>
                                            <div id="quill-editor">{!! $content !!}</div>
                                        </div>
                                        <input type="hidden" id="content-input" wire:model="content">
                                        @error('content')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    {{-- Images --}}
                                    <div class="mb-3">
                                        <label class="form-label">Gambar Event (Maks. 5 gambar)</label>

                                        {{-- Existing Images --}}
                                        @if(is_array($existingImages) && count($existingImages) > 0)
                                            <div class="row mb-2">
                                                @foreach($existingImages as $index => $img)
                                                    <div class="col-4 col-md-3 mb-2 position-relative">
                                                        <img src="{{ asset('berkas/events/images/' . $img) }}"
                                                            class="img-fluid rounded border" style="height: 100px; object-fit: cover; width: 100%;"
                                                            onerror="this.src='{{ asset('style/app-assets/images/placeholder.png') }}'">
                                                        <button type="button" wire:click="removeExistingImage({{ $index }})"
                                                            class="btn btn-sm btn-danger position-absolute"
                                                            style="top: 5px; right: 20px; padding: 2px 6px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Loading Indicator --}}
                                        <div wire:loading wire:target="images" class="mb-2">
                                            <div class="d-flex align-items-center text-primary">
                                                <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                                                <span>Mengupload gambar...</span>
                                            </div>
                                        </div>

                                        {{-- New Images Preview --}}
                                        @if(is_array($newImages) && count($newImages) > 0)
                                            <div class="row mb-2" wire:loading.remove wire:target="images">
                                                @foreach($newImages as $index => $img)
                                                    <div class="col-4 col-md-3 mb-2 position-relative">
                                                        <img src="{{ $img->temporaryUrl() }}"
                                                            class="img-fluid rounded border" style="height: 100px; object-fit: cover; width: 100%;">
                                                        <button type="button" wire:click="removeNewImage({{ $index }})"
                                                            class="btn btn-sm btn-danger position-absolute"
                                                            style="top: 5px; right: 20px; padding: 2px 6px;">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                                        </button>
                                                        <span class="badge bg-primary position-absolute" style="bottom: 5px; left: 20px;">Baru</span>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif

                                        {{-- Upload Input --}}
                                        @php $remainingSlots = 5 - (is_array($existingImages) ? count($existingImages) : 0) - (is_array($newImages) ? count($newImages) : 0); @endphp
                                        @if($remainingSlots > 0)
                                            <input type="file" wire:model="images" id="images" class="form-control"
                                                accept="image/*" multiple>
                                            <small class="text-muted">Sisa slot: {{ $remainingSlots }} gambar. Pilih hingga {{ $remainingSlots }} gambar sekaligus.</small>
                                        @else
                                            <div class="alert alert-info py-2">Maksimal 5 gambar telah tercapai. Hapus gambar untuk menambah yang baru.</div>
                                        @endif

                                        @error('images')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                        @error('images.*')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Right Column --}}
                                <div class="col-md-4">
                                    {{-- Date Range --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="start_date">Tanggal Mulai <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" wire:model="start_date" id="start_date"
                                            class="form-control @error('start_date') is-invalid @enderror">
                                        @error('start_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="end_date">Tanggal Selesai <span
                                                class="text-danger">*</span></label>
                                        <input type="datetime-local" wire:model="end_date" id="end_date"
                                            class="form-control @error('end_date') is-invalid @enderror">
                                        @error('end_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <hr class="my-3">
                                    <p class="text-muted small mb-2"><i class="fas fa-info-circle"></i> Periode Pendaftaran (Opsional)</p>

                                    {{-- Registration Date Range --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="registration_start">Pendaftaran Dibuka</label>
                                        <input type="datetime-local" wire:model="registration_start" id="registration_start"
                                            class="form-control @error('registration_start') is-invalid @enderror">
                                        @error('registration_start')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label" for="registration_end">Pendaftaran Ditutup</label>
                                        <input type="datetime-local" wire:model="registration_end" id="registration_end"
                                            class="form-control @error('registration_end') is-invalid @enderror">
                                        @error('registration_end')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <hr class="my-3">

                                    {{-- Payment --}}
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" wire:model.live="is_paid"
                                                id="is_paid">
                                            <label class="form-check-label" for="is_paid">Event Berbayar</label>
                                        </div>
                                    </div>

                                    @if($is_paid)
                                        <div class="mb-3">
                                            <label class="form-label" for="price">Harga (Rp)</label>
                                            <input type="number" wire:model="price" id="price"
                                                class="form-control @error('price') is-invalid @enderror" min="0">
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif

                                    {{-- Features --}}
                                    <div class="mb-3">
                                        <div class="form-check form-switch mb-2">
                                            <input class="form-check-input" type="checkbox" wire:model.live="has_attendance"
                                                id="has_attendance">
                                            <label class="form-check-label" for="has_attendance">Fitur Absensi</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox"
                                                wire:model.live="has_certificate" id="has_certificate">
                                            <label class="form-check-label" for="has_certificate">Fitur Sertifikat</label>
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="mb-3">
                                        <label class="form-label" for="status">Status <span
                                                class="text-danger">*</span></label>
                                        <select wire:model="status" id="status" class="form-select">
                                            <option value="draft">Draft</option>
                                            <option value="published">Published</option>
                                            <option value="closed">Closed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Certificate Settings --}}
                            @if($has_certificate)
                                <hr class="my-4">
                                <h5 class="mb-3">Pengaturan Sertifikat</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Template Sertifikat</label>
                                            <input type="file" wire:model="certificate_template" class="form-control"
                                                accept="image/*">
                                            @if ($certificate_template)
                                                <img src="{{ $certificate_template->temporaryUrl() }}"
                                                    class="img-fluid mt-2 border" style="max-height: 200px;">
                                            @elseif($existingCertificate)
                                                <img src="{{ asset('berkas/events/certificates/' . $existingCertificate) }}"
                                                    class="img-fluid mt-2 border" style="max-height: 200px;">
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Font</label>
                                                <select wire:model="certificate_font" class="form-select">
                                                    <option value="Arial">Arial</option>
                                                    <option value="Times New Roman">Times New Roman</option>
                                                    <option value="Georgia">Georgia</option>
                                                    <option value="Verdana">Verdana</option>
                                                </select>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Warna Font</label>
                                                <input type="color" wire:model="certificate_font_color"
                                                    class="form-control form-control-color" style="height: 38px;">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Ukuran Font</label>
                                                <input type="number" wire:model="certificate_font_size" class="form-control"
                                                    min="10" max="100">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Posisi X</label>
                                                <input type="number" wire:model="certificate_name_x" class="form-control">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Posisi Y</label>
                                                <input type="number" wire:model="certificate_name_y" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            {{-- Group Links Section --}}
                            <hr class="my-4">
                            <h5 class="mb-3"><i class="fab fa-whatsapp text-success me-2"></i>Link Grup WhatsApp</h5>
                            <p class="text-muted small mb-3">Peserta akan melihat link grup sesuai jenis kelaminnya. Jika grup public diisi, akan tampil untuk semua peserta.</p>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="group_ikhwan">
                                            <i class="fas fa-male text-primary me-1"></i> Grup Ikhwan (Laki-laki)
                                        </label>
                                        <input type="url" wire:model="group_ikhwan" id="group_ikhwan"
                                            class="form-control @error('group_ikhwan') is-invalid @enderror"
                                            placeholder="https://chat.whatsapp.com/...">
                                        @error('group_ikhwan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="group_akhwat">
                                            <i class="fas fa-female text-danger me-1"></i> Grup Akhwat (Perempuan)
                                        </label>
                                        <input type="url" wire:model="group_akhwat" id="group_akhwat"
                                            class="form-control @error('group_akhwat') is-invalid @enderror"
                                            placeholder="https://chat.whatsapp.com/...">
                                        @error('group_akhwat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="group_public">
                                            <i class="fas fa-users text-success me-1"></i> Grup Public (Semua)
                                        </label>
                                        <input type="url" wire:model="group_public" id="group_public"
                                            class="form-control @error('group_public') is-invalid @enderror"
                                            placeholder="https://chat.whatsapp.com/...">
                                        @error('group_public')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            {{-- Quota Section --}}
                            <hr class="my-4">
                            <h5 class="mb-3"><i class="fas fa-users-cog me-2 text-info"></i>Kuota Peserta</h5>
                            <p class="text-muted small mb-3">Kosongkan jika tidak ada batasan kuota (unlimited). Pendaftar tidak bisa mendaftar jika kuota sudah habis.</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="quota_ikhwan">
                                            <i class="fas fa-male text-primary me-1"></i> Kuota Ikhwan (Laki-laki)
                                        </label>
                                        <input type="number" wire:model="quota_ikhwan" id="quota_ikhwan"
                                            class="form-control @error('quota_ikhwan') is-invalid @enderror"
                                            placeholder="Contoh: 50" min="1">
                                        @error('quota_ikhwan')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($eventId && $event)
                                            <small class="text-muted">
                                                Terdaftar: {{ $event->registered_ikhwan_count }} orang
                                                @if($event->quota_ikhwan)
                                                    (Sisa: {{ $event->remaining_quota_ikhwan }})
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="quota_akhwat">
                                            <i class="fas fa-female text-danger me-1"></i> Kuota Akhwat (Perempuan)
                                        </label>
                                        <input type="number" wire:model="quota_akhwat" id="quota_akhwat"
                                            class="form-control @error('quota_akhwat') is-invalid @enderror"
                                            placeholder="Contoh: 50" min="1">
                                        @error('quota_akhwat')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        @if($eventId && $event)
                                            <small class="text-muted">
                                                Terdaftar: {{ $event->registered_akhwat_count }} orang
                                                @if($event->quota_akhwat)
                                                    (Sisa: {{ $event->remaining_quota_akhwat }})
                                                @endif
                                            </small>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Auto Accept Section --}}
                            <hr class="my-4">
                            <h5 class="mb-3"><i class="fas fa-check-double me-2 text-success"></i>Konfirmasi Pendaftaran</h5>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" wire:model="auto_accept"
                                        id="auto_accept">
                                    <label class="form-check-label" for="auto_accept">
                                        <strong>Auto Accept Pendaftar</strong>
                                    </label>
                                </div>
                                <small class="text-muted d-block mt-1">
                                    @if($auto_accept)
                                        <span class="text-success"><i class="fas fa-check-circle"></i> Pendaftar akan otomatis dikonfirmasi (status: valid)</span>
                                    @else
                                        <span class="text-warning"><i class="fas fa-clock"></i> Pendaftar harus dikonfirmasi manual oleh admin (status: pending)</span>
                                    @endif
                                </small>
                            </div>

                            <hr class="my-4">

                            {{-- Submit --}}
                            <div class="d-flex justify-content-between">
                                <a href="{{ route('admin::events.index') }}" class="btn btn-outline-secondary">
                                    <i data-feather="arrow-left" class="me-25"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i data-feather="save" class="me-25"></i>
                                    {{ $eventId ? 'Update Event' : 'Simpan Event' }}
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

        // Sync content on text change
        quill.on('text-change', function() {
            let content = quill.root.innerHTML;
            // Check if content is not empty (Quill returns <p><br></p> when empty)
            if (content === '<p><br></p>') {
                content = '';
            }
            @this.set('content', content);
        });

        // Also sync before form submit
        document.querySelector('form').addEventListener('submit', function(e) {
            let content = quill.root.innerHTML;
            if (content === '<p><br></p>') {
                content = '';
            }
            @this.set('content', content);
        });
    });
</script>
@endpush
