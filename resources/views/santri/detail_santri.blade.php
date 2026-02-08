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

@section('content')
<h4 class="fw-bold py-1 mb-2">
    <span class="text-muted fw-light">
        <a href="/pilih-program">
        <
        Kembali
        </a>
    </span>
</h4>
@if ($cekSantri == 0)
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger" role="alert">
                <span>Mohon maaf, kami tidak dapat menemukan data yang anda cari.</span>
                <button class="btn btn-sm btn-primary" onclick="location.href='/cari-nama'">Kembali</button>
            </div>
        </div>
    </div>
@else
<div class="flex-grow-1 container-p-y">
    <div class="row">
        @if(session('BerhasilEditBiodata'))
        <div class="col-12">
            <div class="alert alert-success alert-dismissible" role="alert">
                Biodata anda berhasil di update!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        @endif
      <!-- User Sidebar -->
      <div class="col-xl-4 col-lg-5 col-md-5 order-0 order-md-0">
        <!-- User Card -->
        <div class="card mb-4">
        <div class="card-body">
            <div class="user-avatar-section">
            <div class="d-flex align-items-center flex-column">
                <img
                class="img-fluid rounded mb-3 pt-1 mt-4"
                src="{{ asset('berkas/'.$tahunPsb.'/'.$santri->photo) }}"
                height="100"
                width="100"
                alt="User avatar"
                />
                <div class="user-info text-center">
                <h4 class="mb-2">{{ $santri->nama }}</h4>
                <span class="badge bg-label-secondary mt-1">{{ $santri->kode_registrasi }}</span>
                </div>
            </div>
            </div>
            <div class="d-flex justify-content-around flex-wrap mt-3 pt-3 pb-4">
                <div class="d-flex align-items-start me-4 mt-3 gap-2">
                    <span class="badge bg-label-primary p-2 rounded"><i class="ti ti-checkbox ti-sm"></i></span>
                    <div>
                    <p class="mb-0 fw-semibold">{{ $santri->nama_program }}</p>
                    <small>Program Pilihan</small>
                    </div>
                </div>
            </div>
        </div>
        </div>
        <!-- /User Card -->
      </div>
      <!--/ User Sidebar -->

      <!-- User Content -->
      <div class="col-xl-8 col-lg-7 col-md-7 order-1 order-md-1">
        <div class="card card-action mb-4">
            <div class="card-header align-items-center">
              <h5 class="card-action-title mb-0">Detail Data</h5>
              <div class="card-action-element">
                <button
                  class="btn btn-primary btn-sm edit-address"
                  type="button"
                  onclick="location.href='/edit-biodata/{{ $santri->kode_registrasi }}'"
                >
                  Ubah Data
                </button>
              </div>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-xl-7 col-12">
                  <dl class="row mb-0">
                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Nama Lengkap :</dt>
                    <dd class="col-sm-8">{{ $santri->nama }}</dd>

                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Jenis Kelamin :</dt>
                    <dd class="col-sm-8">{{ $santri->jk }}</dd>

                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Tempat Lahir :</dt>
                    <dd class="col-sm-8">{{ $santri->tmp_lahir }}</dd>

                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Tanggal Lahir :</dt>
                    <dd class="col-sm-8">{{ $tanggalIndo }}</dd>

                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Alamat :</dt>
                    <dd class="col-sm-8">
                      {{ $santri->alamat }}
                    </dd>
                  </dl>
                </div>
                <div class="col-xl-5 col-12">
                  <dl class="row mb-0">
                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Pendidikan :</dt>
                    <dd class="col-sm-8">{{ $santri->pendidikan }}</dd>

                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Pekerjaan :</dt>
                    <dd class="col-sm-8">{{ $santri->nama_pekerjaan }}</dd>

                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Email :</dt>
                    <dd class="col-sm-8">{{ $santri->email }}</dd>

                    <dt class="col-sm-4 mb-2 fw-semibold text-nowrap">Nomor HP:</dt>
                    <dd class="col-sm-8">+{{ $santri->hp }}</dd>
                  </dl>
                </div>
              </div>
            </div>
        </div>

        <div class="card card-action mb-4">
            <div class="card-header align-items-center">
              <h5 class="card-action-title mb-0">Lampiran Berkas</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-lg-6 col-12">
                    <label>KTP/KTS/KK</label>
                    <img
                    class="img-fluid rounded mb-3 pt-1"
                    src="{{ asset('berkas/'.$tahunPsb.'/'.$santri->ktp) }}"
                    height="300"
                    width="100%"
                    />
                </div>

                <div class="col-lg-6 col-12">
                    <label>Bukti Transfer</label>
                    <img
                    class="img-fluid rounded mb-3 pt-1"
                    src="{{ asset('berkas/'.$tahunPsb.'/'.$santri->transfer) }}"
                    height="300"
                    width="100%"
                    />
                </div>
              </div>
            </div>
        </div>
      </div>
      <!--/ User Content -->
    </div>
</div>
@endif

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
