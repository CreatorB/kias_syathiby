@extends('layouts.landing.page')

@section('content')
<div style="display:flex;position:fixed;inset:0;background:linear-gradient(135deg, #267084 0%, #359090 100%);align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:45px 40px;text-align:center;max-width:440px;width:92%;box-shadow:0 25px 80px rgba(0,0,0,0.3);">
        <div style="width:80px;height:80px;background:linear-gradient(135deg,#267084,#359090);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 25px;">
            <i class="ti ti-lock" style="font-size:2.5rem;color:#fff;"></i>
        </div>
        <h3 style="color:#1a5252;font-weight:800;margin-bottom:10px;">Pendaftaran Manual</h3>
        <p style="color:#6c757d;margin-bottom:25px;font-size:0.95rem;">Masukkan password untuk mengakses halaman pendaftaran manual.</p>

        @if(session('error'))
        <div class="alert alert-danger mb-3">{{ session('error') }}</div>
        @endif

        <form action="{{ route('psb_manual.verify') }}" method="POST">
            @csrf
            <div class="mb-3">
                <input type="password" name="password" class="form-control form-control-lg" placeholder="Masukkan password" autocomplete="current-password" style="text-align:center;font-size:1.1rem;" required>
            </div>
            <button type="submit" class="btn btn-primary w-100 py-2" style="font-size:1rem;">
                <i class="ti ti-check me-2"></i>Verifikasi Password
            </button>
        </form>

        <div class="mt-4 pt-3 border-top">
            <a href="/psb" class="text-muted small">
                <i class="ti ti-arrow-left me-1"></i>Kembali ke pendaftaran biasa
            </a>
        </div>
    </div>
</div>
@endsection