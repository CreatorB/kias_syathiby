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
<h4 class="fw-bold py-1 mb-2"><span class="text-muted fw-light">Daftar/</span> Formulir Online</h4>

@if(session('GagalUpload'))
<div class="row">
    <div class="col-12 mb-2">
        <div class="alert alert-danger" role="alert">
            Upload Berkas GAGAL!
        </div>
    </div>
</div>
@endif

<!--Alert jika ada validasi yang tidak sesuai-->
@if (isset($errors) && $errors->any())
<div class="alert alert-danger" role="alert">
    Daftar Gagal, Periksa kembali kolom isian anda!
</div>
@endif

@if (session('DataSudahAda'))
<div class="alert alert-danger alert-dismissible" role="alert">
    <h5 class="alert-heading mb-2">Daftar GAGAL!</h5>
    <p class="mb-0">
      Nama anda sudah terdaftar di sistem kami, berikut datanya :<br><br>
      Nama Lengkap : <b>{{ $nama }}</b><br>
      Jenis Kelamin : <b>{{ $jk }}</b><br>
      Nomor HP : <b>+{{ $hp }}</b><br>
      Program : <b>{{ $programPilihan }}</b><br>
      Tanggal Daftar : <b>{{ $tgl }} pukul {{ $jam }}</b><br><br>

      Untuk melihat detail data anda, silahkan klik disini <a href="/cari-nama">Detail Data</a>
    </p>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Program <b class="text-primary">{{ $program->nama_program }}</b></h5>
            </div>
            <div class="card-body">
                <form method="POST" action="/isi-form/store" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Nama Lengkap</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"
                                ><i class="ti ti-user"></i
                                ></span>
                                <input
                                type="text"
                                class="form-control"
                                id="basic-icon-default-fullname"
                                placeholder="Tulis nama lengkap"
                                name="nama"
                                value="{{ old('nama') }}"
                                required
                                oninvalid="this.setCustomValidity('Siapa nama anda?')"
                                oninput="this.setCustomValidity('')"
                                />
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label d-block">Jenis Kelamin</label>
                            <div class="form-check form-check-inline mt-3">
                                <input
                                class="form-check-input"
                                type="radio"
                                name="jk"
                                id="dataLakiLaki"
                                value="Laki-Laki"
                                required
                                oninvalid="this.setCustomValidity('Wajib diisi!')"
                                oninput="this.setCustomValidity('')"
                                />
                                <label class="form-check-label" for="dataLakiLaki">Laki-Laki</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input
                                class="form-check-input"
                                type="radio"
                                name="jk"
                                id="dataPerempuan"
                                value="Perempuan"
                                />
                                <label class="form-check-label" for="dataPerempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="basic-icon-default-fullname">Tempat Lahir</label>
                            <div class="input-group input-group-merge">
                                <span id="basic-icon-default-fullname2" class="input-group-text"
                                ><i class="ti ti-building"></i
                                ></span>
                                <input
                                type="text"
                                class="form-control"
                                id="basic-icon-default-fullname"
                                placeholder="Kota kelahiran anda"
                                name="tmpLahir"
                                value="{{ old('tmpLahir') }}"
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
                                placeholder="Pilih tanggal..."
                                id="flatpickr-date"
                                name="tglLahir"
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
                                placeholder="Tulis alamat domisili dengan lengkap disertai kecamatan, kabupaten dan provinsi"
                                name="alamat"
                                required
                                oninvalid="this.setCustomValidity('Dimana anda tinggal?')"
                                oninput="this.setCustomValidity('')"
                                >{{ old('alamat') }}</textarea>
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
                            <option value="">--Pilih--</option>
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
                            class="select2 form-select form-select-lg"
                            data-allow-clear="true"
                            name="pekerjaanId"
                            required
                            oninvalid="this.setCustomValidity('Apa pekerjaan anda?')"
                            oninput="this.setCustomValidity('')"
                            >
                            <option value=""></option>
                                @foreach ($pekerjaan as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama_pekerjaan }}</option>
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
                                value="{{ old('email') }}"
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
                                    <option value="62">(+62) ID</option>
                                    @foreach ($kodeNegara as $item)
                                        <option value="{{ $item->kode_hp }}">(+{{ $item->kode_hp }})</option>
                                    @endforeach
                                </select>
                                <input class="form-control" type="number" step="any"
                                name="noHp"
                                value="{{ old('noHp') }}"
                                required
                                oninvalid="this.setCustomValidity('Anda harus mengisi nomor whatsapp')"
                                oninput="this.setCustomValidity('')"
                                >
                            </div>
                            <div class="form-text">Tulis nomor HP dengan kode negara, ex : (+62) 85775645281</div>
                        </div>
                    </div>

                    <label><b>LAMPIRAN BERKAS!</b></label><br>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="form-label">Pas Photo</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"
                                ><i class="ti ti-photo"></i
                                ></span>
                                <input type="file" class="form-control @error('photo') is-invalid @enderror"
                                name="photo"
                                accept="image/*"
                                required
                                oninvalid="this.setCustomValidity('Wajib melampirkan photo')"
                                oninput="this.setCustomValidity('')"
                                />
                                <div class="invalid-feedback">
                                    @error('photo')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            @if (!(isset($errors) && $errors->any()))
                            <div class="form-text">Ukuran file <b style="color:red">maksimal 1 MB</b></div>
                            @endif
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="form-label">KTP/KTS/SIM/KK</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"
                                ><i class="ti ti-photo"></i
                                ></span>
                                <input type="file" class="form-control @error('ktp') is-invalid @enderror"
                                name="ktp"
                                accept="image/*"
                                required
                                oninvalid="this.setCustomValidity('Wajib melampirkan kartu identitas')"
                                oninput="this.setCustomValidity('')"
                                />
                                <div class="invalid-feedback">
                                    @error('ktp')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            @if (!(isset($errors) && $errors->any()))
                            <div class="form-text">Ukuran file <b style="color:red">maksimal 1 MB</b></div>
                            @endif
                        </div>

                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="form-label">Bukti Transfer</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"
                                ><i class="ti ti-photo"></i
                                ></span>
                                <input type="file" class="form-control @error('transfer') is-invalid @enderror"
                                name="transfer"
                                accept="image/*"
                                required
                                oninvalid="this.setCustomValidity('Wajib melampirkan bukti transfer')"
                                oninput="this.setCustomValidity('')"
                                />
                                <div class="invalid-feedback">
                                    @error('transfer')
                                    {{ $message }}
                                    @enderror
                                </div>
                            </div>
                            @if (!(isset($errors) && $errors->any()))
                            <div class="form-text">Ukuran file <b style="color:red">maksimal 1 MB</b></div>
                            @endif
                        </div>
                    </div>

                    <input type="hidden" name="programId" value="{{ $program->id }}">
                    <input type="hidden" name="tahunPsb" value="{{ $tahunPsb }}">
                    <input type="hidden" name="nominalTransfer" value="{{ $psb->biaya_pendaftaran }}">

                    @if ($program->status_psb == 'Buka')
                    <button type="submit" class="btn btn-primary" id="simpan">Kirim</button>
                    @else
                    <button type="button" class="btn btn-primary" disabled>Tutup</button>
                    @endif

                </form>
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
