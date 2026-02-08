@extends('layouts.registrasi.main')

@push('vendorCss')
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/jquery-timepicker/jquery-timepicker.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/pickr/pickr-themes.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/select2/select2.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/tagify/tagify.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/bootstrap-select/bootstrap-select.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/typeahead-js/typeahead.css') }}" />
@endpush

@push('pageCss')
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/pages/page-help-center.css') }}" />
@endpush

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Biodata</b></h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/edit-biodata/update">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Program Pilihan</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"
                                ><i class="ti ti-book"></i
                                ></span>
                                <select class="form-select"
                                name="programId"
                                required
                                oninvalid="this.setCustomValidity('Wajib diisi!')"
                                oninput="this.setCustomValidity('')"
                                >
                                <option value="{{ $santri->program_id }}">{{ $santri->nama_program}}</option>
                                @foreach ($program as $item)
                                    @if ($item->nama_program != $santri->nama_program)
                                        <option value="{{ $item->id }}">{{ $item->nama_program }}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"
                                ><i class="ti ti-user"></i
                                ></span>
                                <input
                                type="text"
                                class="form-control"
                                name="nama"
                                value="{{ $santri->nama }}"
                                />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label d-block">Jenis Kelamin</label>
                            <select class="form-select" name="jk">
                                <option>{{ $santri->jk }}</option>
                                @if ($santri->jk != 'Laki-Laki')
                                    <option>Laki-Laki</option>
                                @endif
                                @if ($santri->jk != 'Perempuan')
                                    <option>Perempuan</option>
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Tempat Lahir</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"
                                ><i class="ti ti-building"></i
                                ></span>
                                <input
                                type="text"
                                class="form-control"
                                name="tmpLahir"
                                value="{{ $santri->tmp_lahir }}"
                                required
                                oninvalid="this.setCustomValidity('Dimana anda dilahirkan?')"
                                oninput="this.setCustomValidity('')"
                                />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Tanggal Lahir</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"
                                ><i class="ti ti-calendar"></i
                                ></span>
                                <input type="text" class="form-control"
                                id="flatpickr-date"
                                name="tglLahir"
                                value="{{ $santri->tgl_lahir }}"
                                required
                                oninvalid="this.setCustomValidity('Kapan anda dilahirkan?')"
                                oninput="this.setCustomValidity('')"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"
                                ><i class="ti ti-home"></i
                                ></span>
                                <textarea
                                class="form-control"
                                name="alamat"
                                required
                                oninvalid="this.setCustomValidity('Dimana anda tinggal?')"
                                oninput="this.setCustomValidity('')"
                                >{{ $santri->alamat }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="pilihPendidikan" class="form-label">Pendidikan Terakhir</label>
                            <select id="pilihPendidikan" class="form-select"
                            name="pendidikan"
                            required
                            oninvalid="this.setCustomValidity('Wajib diisi!')"
                            oninput="this.setCustomValidity('')"
                            >
                            <option>{{ $santri->pendidikan }}</option>
                            <option {{ old('pendidikan')=="Tidak Ada" ? 'selected' : '' }}>Tidak Ada</option>
                            <option {{ old('pendidikan')=="SD/MI" ? 'selected' : '' }}>SD/MI</option>
                            <option {{ old('pendidikan')=="SMP/Mts" ? 'selected' : '' }}>SMP/Mts</option>
                            <option {{ old('pendidikan')=="SMA/SMK/MA" ? 'selected' : '' }}>SMA/SMK/MA</option>
                            <option {{ old('pendidikan')=="Akademi" ? 'selected' : '' }}>Akademi</option>
                            <option {{ old('pendidikan')=="D1" ? 'selected' : '' }}>D1</option>
                            <option {{ old('pendidikan')=="D2" ? 'selected' : '' }}>D2</option>
                            <option {{ old('pendidikan')=="D3" ? 'selected' : '' }}>D3</option>
                            <option {{ old('pendidikan')=="Sarjana (S1)" ? 'selected' : '' }}>Sarjana (S1)</option>
                            <option {{ old('pendidikan')=="Magister (S2)" ? 'selected' : '' }}>Magister (S2)</option>
                            <option {{ old('pendidikan')=="Doktor (S3)" ? 'selected' : '' }}>Doktor (S3)</option>
                            </select>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label for="select2Basic" class="form-label">Pekerjaan</label>
                            <select id="select2Basic"
                            class="form-select"
                            data-allow-clear="true"
                            name="pekerjaanId"
                            required
                            oninvalid="this.setCustomValidity('Apa pekerjaan anda?')"
                            oninput="this.setCustomValidity('')"
                            >
                            <option value="{{ $santri->pekerjaan_id }}">{{ $santri->nama_pekerjaan }}</option>
                            @foreach ($pekerjaan as $item)
                                @if ($item->id != $santri->pekerjaan_id)
                                    <option value="{{ $item->id }}">{{ $item->nama_pekerjaan }}</option>
                                @endif
                            @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Email</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"
                                ><i class="ti ti-mail"></i
                                ></span>
                                <input type="email" class="form-control"
                                placeholder="nama@domain.com"
                                name="email"
                                value="{{ $santri->email }}"
                                required
                                oninvalid="this.setCustomValidity('Email harus diisi dengan benar!')"
                                oninput="this.setCustomValidity('')"
                                />
                            </div>
                        </div>

                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Nomor Whatsapp</label>
                            <div class="input-group">
                                <select class="select2 form-select form-select-lg"
                                name="kodeNegara">
                                    <option value="{{ $santri->kode_negara }}">(+{{ $santri->kode_negara }}) ID</option>
                                    @foreach ($kodeNegara as $item)
                                        <option value="{{ $item->kode_hp }}">(+{{ $item->kode_hp }})</option>
                                    @endforeach
                                </select>
                                <input class="form-control" type="number" step="any"
                                name="noHp"
                                value="{{ $santri->no_hp }}"
                                required
                                oninvalid="this.setCustomValidity('Anda harus mengisi nomor whatsapp')"
                                oninput="this.setCustomValidity('')"
                                >
                            </div>
                            <div class="form-text">Tulis nomor HP dengan kode negara, ex : (+62) 85775645281</div>
                        </div>
                    </div>

                    <input type="hidden" value="{{ $santri->id }}" name="id">
                    <input type="hidden" value="{{ $santri->kode_registrasi }}" name="kodeRegistrasi">
                    <button type="submit" class="btn btn-primary mb-2" id="simpan">Simpan</button>
                </form>
                <button class="btn btn-secondary" onclick="history.back()">Kembali</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('vendorScript')
<script src="{{ asset('dashboard/assets/vendor/libs/moment/moment.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/bootstrap-daterangepicker/bootstrap-daterangepicker.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/jquery-timepicker/jquery-timepicker.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/pickr/pickr.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/select2/select2.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/tagify/tagify.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/bootstrap-select/bootstrap-select.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/typeahead-js/typeahead.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/bloodhound/bloodhound.js') }}"></script>
@endpush

@push('pageScript')
<script src="{{ asset('dashboard/assets/js/forms-pickers.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/forms-selects.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/forms-tagify.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/forms-typeahead.js') }}"></script>

<script>
    $('form').submit(function (event) {
        if ($(this).hasClass('submitted')) {
            event.preventDefault();
        }
        else {
            $(this).find(':submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span class="ms-25 align-middle"> Proses...</span>');
            $(this).addClass('submitted');
            document.getElementById("simpan").disabled = true;
        }
    });
</script>
@endpush
