@extends('layouts.registrasi.main')

@push('vendorCss')
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/flatpickr/flatpickr.css') }}" />
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/select2/select2.css') }}" />
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
    <strong>Daftar Gagal, Periksa kembali kolom isian anda!</strong>
    <ul class="mb-0 mt-2">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
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

      Untuk melihat detail data anda, silahkan klik disini <a href="/cek">Detail Data</a>
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
                        <div class="col-lg-4 mb-3">
                            <label class="form-label" for="inputNoInduk">Nomor Induk</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-id"></i></span>
                                <input type="text" class="form-control" id="inputNoInduk"
                                    placeholder="Nomor induk pesantren"
                                    name="noInduk" value="{{ old('noInduk') }}">
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label" for="inputNik">NIK (KTP)</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-credit-card"></i></span>
                                <input type="text" class="form-control" id="inputNik"
                                    placeholder="Nomor KTP 16 digit"
                                    name="nik" value="{{ old('nik') }}"
                                    pattern="[0-9]{16}" maxlength="16">
                            </div>
                        </div>
                        <div class="col-lg-4 mb-3">
                            <label class="form-label" for="inputNisn">NISN</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-book"></i></span>
                                <input type="text" class="form-control" id="inputNisn"
                                    placeholder="Nomor NISN 10 digit"
                                    name="nisn" value="{{ old('nisn') }}"
                                    pattern="[0-9]{10}" maxlength="10">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="inputNama">Nama Lengkap <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span id="iconNama" class="input-group-text"
                                ><i class="ti ti-user"></i
                                ></span>
                                <input
                                type="text"
                                class="form-control"
                                id="inputNama"
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
                            <label class="form-label d-block">Jenis Kelamin <span class="text-danger">*</span></label>
                            <div class="form-check form-check-inline mt-3">
                                <input
                                class="form-check-input"
                                type="radio"
                                name="jk"
                                id="dataLakiLaki"
                                value="Laki-Laki"
                                {{ old('jk') == 'Laki-Laki' ? 'checked' : '' }}
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
                                {{ old('jk') == 'Perempuan' ? 'checked' : '' }}
                                required
                                oninvalid="this.setCustomValidity('Wajib diisi!')"
                                oninput="this.setCustomValidity('')"
                                />
                                <label class="form-check-label" for="dataPerempuan">Perempuan</label>
                            </div>
                        </div>
                    </div>

<div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="inputTempatLahir">Tempat Lahir <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span id="iconTempatLahir" class="input-group-text"
                                ><i class="ti ti-building"></i
                                ></span>
                                <input
                                type="text"
                                class="form-control"
                                id="inputTempatLahir"
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
                            <label class="form-label" for="flatpickr-date">Tanggal Lahir <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span id="iconTanggalLahir" class="input-group-text"
                                ><i class="ti ti-calendar"></i
                                ></span>
                                <input type="text" class="form-control"
                                placeholder="Pilih tanggal..."
                                id="flatpickr-date"
                                name="tglLahir"
                                value="{{ old('tglLahir') }}"
                                required
                                oninvalid="this.setCustomValidity('Kapan anda dilahirkan?')"
                                oninput="this.setCustomValidity('')"
                                />
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label" for="inputAlamat">Alamat <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span id="iconAlamat" class="input-group-text"
                                ><i class="ti ti-home"></i
                                ></span>
                                <textarea
                                class="form-control"
                                id="inputAlamat"
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
                            <label class="form-label" for="inputNamaAyah">Nama Ayah</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-user"></i></span>
                                <input type="text" class="form-control" id="inputNamaAyah"
                                    placeholder="Nama lengkap ayah"
                                    name="namaAyah" value="{{ old('namaAyah') }}">
                            </div>
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="inputNoHpAyah">Nomor HP Ayah</label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="ti ti-phone"></i></span>
                                <input type="tel" class="form-control" id="inputNoHpAyah"
                                    placeholder="08123456789"
                                    name="noHpAyah" value="{{ old('noHpAyah') }}"
                                    pattern="[0-9]{8,15}" maxlength="15">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-lg-6 mb-3">
                            <label for="pilihPendidikan" class="form-label">Pendidikan Terakhir <span class="text-danger">*</span></label>
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
                            <label for="pilihPekerjaan" class="form-label">Pekerjaan <span class="text-danger">*</span></label>
                            <select id="pilihPekerjaan"
                            class="select2 form-select form-select-lg"
                            data-allow-clear="true"
                            name="pekerjaanId"
                            required
                            oninvalid="this.setCustomValidity('Apa pekerjaan anda?')"
                            oninput="this.setCustomValidity('')"
                            >
                            <option value="">--Pilih--</option>
                                @foreach ($pekerjaan as $item)
                                    <option value="{{ $item->id }}" {{ old('pekerjaanId') == $item->id ? 'selected' : '' }}>{{ $item->nama_pekerjaan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

<div class="row">
                        <div class="col-lg-6 mb-3">
                            <label class="form-label" for="inputEmail">Email <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span id="iconEmail" class="input-group-text"
                                ><i class="ti ti-mail"></i
                                ></span>
                                <input type="email" class="form-control"
                                id="inputEmail"
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
                            <label class="form-label" for="inputNoHp">Nomor WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="select2 form-select form-select-lg"
                                name="kodeNegara" id="selectKodeNegara">
                                    <option value="62" {{ old('kodeNegara', '62') == '62' ? 'selected' : '' }}>(+62) ID</option>
                                    @foreach ($kodeNegara as $item)
                                        <option value="{{ $item->kode_hp }}" {{ old('kodeNegara') == $item->kode_hp ? 'selected' : '' }}>(+{{ $item->kode_hp }})</option>
                                    @endforeach
                                </select>
                                <input class="form-control" type="tel"
                                id="inputNoHp"
                                name="noHp"
                                value="{{ old('noHp') }}"
                                placeholder="8123456789"
                                pattern="[0-9]{8,15}"
                                required
                                oninvalid="this.setCustomValidity('Anda harus mengisi nomor whatsapp yang valid (8-15 digit)')"
                                oninput="this.setCustomValidity('')"
                                >
                            </div>
                            <div class="form-text">Tulis nomor HP dengan kode negara, ex : (+62) 85775645281</div>
                        </div>
                    </div>

                    <label><b>LAMPIRAN BERKAS!</b></label><br>
                    <div class="row">
                        <div class="col-lg-4 col-md-6 mb-3">
                            <label class="form-label">Pas Photo <span class="text-danger">*</span></label>
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
                            <label class="form-label">KTP/KTS/SIM/KK <span class="text-danger">*</span></label>
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
                            <label class="form-label">Bukti Transfer <span class="text-danger">*</span></label>
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
<script src="{{ asset('dashboard/assets/vendor/libs/select2/select2.js') }}"></script>
@endpush

@push('pageScript')
<script src="{{ asset('dashboard/assets/js/forms-pickers.js') }}"></script>
<script src="{{ asset('dashboard/assets/js/forms-selects.js') }}"></script>

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
