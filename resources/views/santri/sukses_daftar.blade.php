@extends('layouts.registrasi.main')

@push('vendorCss')
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/libs/toastr/toastr.css') }}" />
@endpush

@section('content')
<div class="authentication-wrapper authentication-basic">
    <div class="authentication-inner py-4">
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center mb-4 mt-2">
            <a href="/" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">
                <img src="{{ asset('landing/images/logo/'.$lembaga->logo) }}" alt="" width="32" height="22">
              </span>
              <span class="app-brand-text demo text-body fw-bold ms-1">LPTA</span>
            </a>
          </div>
          <!-- /Logo -->
            @if ($berhasil == 1)
                <h4 class="mb-1 pt-2">Alhamdulillah, Pendaftaran Berhasil!</h4>
                <p class="mb-1">
                    Selamat! <b>"{{ $namaLengkap }}"</b> anda telah resmi menjadi Calon Santri Takhassus Al Barkah.
                    Untuk informasi selanjutnya kami akan menghubungi anda via Whatsapp <br><br>
                    Berikut <b>Kode Registrasi</b> anda :
                </p>

                <div class="row">
                    <div class="col-md-4 col-sm-12 pe-0 mb-md-0 mb-2">
                    <input class="form-control" id="clipboard-example" type="text" value="{{ $kodeRegistrasi }}" />
                    </div>
                    <div class="col-md-4 col-sm-12">
                    <button
                        class="clipboard-btn btn btn-success me-2"
                        data-clipboard-action="copy"
                        data-clipboard-target="#clipboard-example"
                    >
                    <span class="ti-xs ti ti-copy me-1"></span>
                        Salid Kode
                    </button>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12 mt-3">
                        <p>
                            Mohon untuk menyimpan dengan baik <b>Kode Registrasi</b> anda! Kode tersebut bisa digunakan untuk
                            melakukan pengecekan data status pendaftaran anda.
                        </p>
                    </div>
                    <div class="col-lg-4 col-12 d-flex">
                        <button type="button" class="btn btn-primary" onclick="location.href='/pilih-program'">
                            <span class="ti-xs ti ti-arrow-back-up me-1"></span>
                            Kembali
                        </button>
                    </div>
                </div>
            @else
            <div class="alert alert-danger" role="alert">
                Anda belum mendaftar, silahkan isi formulir terlebih dahulu!
            </div>
            @endif
        </div>
      </div>
      <!-- Register Card -->
    </div>
</div>
@endsection

@push('vendorScript')
<script src="{{ asset('dashboard/assets/vendor/libs/clipboard/clipboard.js') }}"></script>
<script src="{{ asset('dashboard/assets/vendor/libs/toastr/toastr.js') }}"></script>
@endpush

@push('pageScript')
<script src="{{ asset('dashboard/assets/js/extended-ui-misc-clipboardjs.js') }}"></script>
@endpush
