@extends('layouts.registrasi.main')

@push('pageCss')
<link rel="stylesheet" href="{{ asset('dashboard/assets/vendor/css/pages/page-help-center.css') }}" />
@endpush

@section('content')
<div class="help-center-header rounded d-flex flex-column justify-content-center align-items-center bg-help-center">
    <h3 class="text-center"> Lihat Detail Data Santri </h3>
    <p class="text-center px-3 mb-2">Untuk melihat detail data, masukan <b class="text-primary">Kode Registrasi</b> anda di bawah ini</p>
    <form method="GET" action="/detail-nama">
        <input type="text" class="form-control"
        placeholder="Kode registrasi"
        name="kodeRegistrasi"
        required
        oninvalid="this.setCustomValidity('Kode registrasi tidak boleh kosong!')"
        oninput="this.setCustomValidity('')"
        autofocus/>
        <p class="text-center mt-3">
            <button class="btn btn-primary" type="submit">Lihat Detail</button>
        </p>
    </form>
    <button class="btn btn-secondary" onclick="location.href='/pilih-program'">Kembali</button>
</div>
@endsection
