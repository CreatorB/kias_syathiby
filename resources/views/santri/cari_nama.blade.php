@extends('layouts.registrasi.main')

@push('pageCss')
<link rel="stylesheet" href="{{ asset('dashboard-assets/assets/vendor/css/pages/page-help-center.css') }}" />
@endpush

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-12">
            <h3 class="text-center mb-2">Anda sudah mendaftar?</h3>
            <p class="text-center px-3 mb-4">Cek status pendaftaran dan revisi berkas anda disini!</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8 col-md-10 col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Cari berdasarkan Kode Registrasi</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="/revisi-berkas" id="form-kode" onsubmit="event.preventDefault(); var kode = this.querySelector('input[name=kode]').value.trim(); if(kode) window.location.href='/revisi-berkas/'+kode;">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text"><i class="ti ti-hash"></i></span>
                            <input type="text" class="form-control" placeholder="Masukkan kode registrasi..." name="kode" required
                                oninvalid="this.setCustomValidity('Kode registrasi tidak boleh kosong!')"
                                oninput="this.setCustomValidity('')" autofocus />
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Atau Cari berdasarkan Nama</h5>
                </div>
                <div class="card-body">
                    @livewire('santri.cari-nama-pendaftar')
                </div>
            </div>
        </div>
    </div>
</div>
@endsection