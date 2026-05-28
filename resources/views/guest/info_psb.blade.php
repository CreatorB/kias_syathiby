@extends('layouts.landing.page')

@section('content')
@use('\App\Helpers\TanggalHelper', 'TanggalHelper')

<style>
:root {
  --kias-primary: #359090;
  --kias-secondary: #267084;
  --kias-accent: #3a9b94;
  --kias-highlight: #8dc794;
  --kias-light: #f1f1f1;
  --kias-dark: #1a5252;
  --kias-gradient: linear-gradient(135deg, #267084 0%, #359090 100%);
}

/* Navbar Override for PSB Page */
#site-header.header-2 {
  background: #ffffff !important;
  box-shadow: 0 2px 15px rgba(0,0,0,0.1);
  position: sticky;
  top: 0;
  z-index: 1000;
}

#site-header.header-2 .navbar-nav .nav-link {
  color: #1a1a1a !important;
  font-weight: 600;
  font-size: 0.95rem;
  text-transform: none;
}

#site-header.header-2 .navbar-nav .nav-link:hover,
#site-header.header-2 .navbar-nav .nav-link.active {
  color: var(--kias-primary) !important;
}

#site-header.header-2 .navbar-nav .dropdown-toggle::after {
  color: #1a1a1a;
}

#site-header.header-2 .navbar-brand img {
  max-height: 50px;
}

#site-header.header-2 .btn-theme {
  background: var(--kias-primary) !important;
  color: #ffffff !important;
  border: 2px solid var(--kias-primary) !important;
  font-weight: 600;
}

#site-header.header-2 .btn-theme:hover {
  background: var(--kias-secondary) !important;
  border-color: var(--kias-secondary) !important;
  color: #ffffff !important;
}

#site-header.header-2 .navbar-toggler {
  border-color: rgba(0,0,0,0.1);
}

#site-header.header-2 .navbar-toggler span {
  background: #1a1a1a !important;
}

.psb-section {
    padding: 70px 0;
}

.section-title {
    text-align: center;
    margin-bottom: 50px;
}

.section-title h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--kias-dark);
    margin-bottom: 15px;
    position: relative;
    display: inline-block;
}

.section-title h2::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 4px;
    background: var(--kias-gradient);
    border-radius: 2px;
}

.section-title p {
    font-size: 1.1rem;
    color: #6c757d;
    margin-top: 20px;
}

/* Hero Section */
.hero-section {
    background: linear-gradient(135deg, #1a5252 0%, #267084 50%, #359090 100%);
    position: relative;
    overflow: hidden;
    padding: 100px 0 80px;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.08" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,165.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
    background-size: cover;
}

.hero-section::after {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 600px;
    height: 600px;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    border-radius: 50%;
}

.hero-section .hero-content {
    position: relative;
    z-index: 2;
}

.hero-section h1 {
    font-size: 3rem;
    font-weight: 800;
    text-shadow: 3px 3px 6px rgba(0,0,0,0.4);
    margin-bottom: 20px;
    color: #ffffff;
}

.hero-section h2 {
    font-size: 2rem;
    font-weight: 700;
    text-shadow: 2px 2px 5px rgba(0,0,0,0.3);
    margin-bottom: 20px;
    color: #ffffff;
}

.hero-section .lead {
    font-size: 1.25rem;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
    margin-bottom: 30px;
    color: #ffffff;
}

.hero-section p {
    color: #ffffff;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
}

.hero-section .btn-hero {
    padding: 16px 40px;
    font-size: 1.1rem;
    font-weight: 700;
    border-radius: 50px;
    transition: all 0.3s ease;
    text-shadow: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}

.hero-section .btn-light {
    background: #ffffff;
    color: #1a5252;
    border: 3px solid #ffffff;
    font-weight: 700;
}

.hero-section .btn-light:hover {
    background: transparent;
    color: #ffffff;
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

.hero-section .btn-outline-light {
    border: 3px solid #ffffff;
    color: #ffffff;
    background: transparent;
    font-weight: 700;
}

.hero-section .btn-outline-light:hover {
    background: #ffffff;
    color: #1a5252;
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.3);
}

/* Program Cards */
.program-card {
    background: #fff;
    border-radius: 15px;
    padding: 30px;
    margin-bottom: 20px;
    box-shadow: 0 5px 20px rgba(53, 144, 144, 0.15);
    transition: all 0.3s ease;
    border: 1px solid rgba(53, 144, 144, 0.1);
    height: 100%;
}

.program-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(53, 144, 144, 0.25);
    border-color: var(--kias-primary);
}

.program-card .badge {
    font-size: 0.75rem;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 15px;
    display: inline-block;
}

.program-card .badge-tajwid {
    background: var(--kias-primary);
    color: #fff;
}

.program-card .badge-ba {
    background: var(--kias-accent);
    color: #fff;
}

.program-card .badge-takmili {
    background: #f39c12;
    color: #fff;
}

.program-card h4 {
    color: var(--kias-dark);
    font-weight: 700;
    margin-bottom: 15px;
    font-size: 1.3rem;
}

.program-card p {
    color: #6c757d;
    line-height: 1.6;
}

/* Biaya Table */
.biaya-table {
    background: #fff;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(53, 144, 144, 0.2);
}

.biaya-table .table-header {
    background: var(--kias-gradient);
    color: #fff;
    padding: 25px;
    text-align: center;
}

.biaya-table .table-header h3 {
    margin: 0;
    font-size: 1.6rem;
    font-weight: 700;
}

.biaya-table table {
    margin: 0;
}

.biaya-table td {
    padding: 18px 25px;
    border-bottom: 1px solid #f1f1f1;
    font-size: 1rem;
}

.biaya-table tr:last-child td {
    border-bottom: none;
}

.biaya-table tr:hover {
    background: rgba(53, 144, 144, 0.05);
}

.biaya-table .biaya-amount {
    font-weight: 700;
    color: var(--kias-primary);
    text-align: right;
    font-size: 1.1rem;
}

/* Alur Test */
.alur-step {
    display: flex;
    align-items: flex-start;
    margin-bottom: 18px;
    padding: 12px;
    border-radius: 10px;
    transition: background 0.3s ease;
}

.alur-step:hover {
    background: rgba(53, 144, 144, 0.05);
}

.alur-step .step-number {
    background: var(--kias-gradient);
    color: #fff;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
    margin-right: 15px;
    box-shadow: 0 3px 10px rgba(53, 144, 144, 0.3);
}

.alur-step .step-content {
    flex: 1;
    color: #2c3e50;
    font-size: 1rem;
    line-height: 1.5;
}

/* Form Design */
.form-section {
    background: #fff;
    border-radius: 15px;
    padding: 35px;
    margin-bottom: 30px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    border: 1px solid rgba(53, 144, 144, 0.1);
}

.form-section h5 {
    color: var(--kias-primary);
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 3px solid rgba(53, 144, 144, 0.2);
    font-weight: 700;
    font-size: 1.3rem;
}

.form-section h5 i {
    margin-right: 10px;
}

.form-label {
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-control, .form-select {
    border: 2px solid #e9ecef;
    border-radius: 10px;
    padding: 12px 15px;
    font-size: 1rem;
    transition: all 0.3s ease;
}

.form-control:focus, .form-select:focus {
    border-color: var(--kias-primary);
    box-shadow: 0 0 0 0.2rem rgba(53, 144, 144, 0.25);
    outline: none;
}

.form-control.is-invalid {
    border-color: #dc3545;
}

.form-control.is-invalid:focus {
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
}

.invalid-feedback {
    font-size: 0.85rem;
    margin-top: 5px;
}

textarea.form-control {
    resize: vertical;
    min-height: 100px;
}

.form-check-input {
    width: 20px;
    height: 20px;
    border: 2px solid #dee2e6;
    cursor: pointer;
}

.form-check-input:checked {
    background-color: var(--kias-primary);
    border-color: var(--kias-primary);
}

.form-check-label {
    font-weight: 500;
    color: #2c3e50;
    margin-left: 8px;
    cursor: pointer;
}

.form-check-inline .form-check-input {
    margin-right: 8px;
}

.agreement-checkbox {
    display: flex;
    align-items: flex-start;
    gap: 15px;
    padding: 25px;
    background: linear-gradient(135deg, #fff9e6 0%, #fff3cd 100%);
    border-radius: 12px;
    border: 2px solid #ffc107;
    box-shadow: 0 3px 10px rgba(255, 193, 7, 0.2);
}

.agreement-checkbox input {
    margin-top: 4px;
    width: 22px;
    height: 22px;
    cursor: pointer;
}

.agreement-checkbox label {
    cursor: pointer;
    line-height: 1.6;
    color: #856404;
    font-size: 0.95rem;
}

/* Payment Section */
.payment-info {
    background: #fff;
    border-radius: 15px;
    padding: 40px;
    box-shadow: 0 10px 30px rgba(53, 144, 144, 0.15);
    border: 1px solid rgba(53, 144, 144, 0.1);
}

.payment-info .bank-details {
    background: linear-gradient(135deg, rgba(53, 144, 144, 0.05) 0%, rgba(38, 112, 132, 0.05) 100%);
    border-radius: 12px;
    padding: 30px;
    text-align: center;
    margin: 25px 0;
    border: 2px dashed var(--kias-primary);
}

.payment-info .bank-details h4 {
    color: var(--kias-primary);
    margin-bottom: 20px;
    font-weight: 700;
}

.payment-info .bank-details .account-number {
    font-size: 2.2rem;
    font-weight: 800;
    color: var(--kias-dark);
    margin: 15px 0;
    letter-spacing: 2px;
    background: linear-gradient(135deg, var(--kias-primary), var(--kias-dark));
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.payment-info .bank-details p {
    font-size: 1.1rem;
    color: #6c757d;
    margin: 8px 0;
}

/* CTA Section */
.cta-section {
    background: var(--kias-gradient);
    color: #fff;
    padding: 80px 0;
    text-align: center;
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -10%;
    width: 500px;
    height: 500px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.cta-section::after {
    content: '';
    position: absolute;
    bottom: -30%;
    left: -5%;
    width: 400px;
    height: 400px;
    background: rgba(255,255,255,0.05);
    border-radius: 50%;
}

.cta-section h2 {
    font-size: 2.8rem;
    font-weight: 800;
    margin-bottom: 20px;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
    position: relative;
}

.cta-section .lead {
    font-size: 1.3rem;
    margin-bottom: 35px;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
    position: relative;
}

.cta-section .btn-light {
    padding: 18px 50px;
    font-size: 1.2rem;
    font-weight: 700;
    border-radius: 50px;
    background: #fff;
    color: var(--kias-primary);
    border: 3px solid #fff;
    transition: all 0.3s ease;
    position: relative;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.cta-section .btn-light:hover {
    background: transparent;
    color: #fff;
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.3);
}

/* Info Box */
.info-box {
    background: linear-gradient(135deg, rgba(53, 144, 144, 0.08) 0%, rgba(38, 112, 132, 0.08) 100%);
    border-left: 5px solid var(--kias-primary);
    padding: 25px;
    margin: 25px 0;
    border-radius: 10px;
}

.info-box h5 {
    color: var(--kias-primary);
    margin-bottom: 15px;
    font-weight: 700;
}

.info-box ul {
    margin: 0;
    padding-left: 20px;
}

.info-box li {
    color: #2c3e50;
    margin-bottom: 8px;
    line-height: 1.6;
}

/* Buttons */
.btn-primary {
    background: var(--kias-primary);
    border-color: var(--kias-primary);
    padding: 12px 30px;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: var(--kias-secondary);
    border-color: var(--kias-secondary);
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(53, 144, 144, 0.4);
}

.btn-primary:active {
    transform: translateY(0);
}

/* Cards */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    overflow: hidden;
}

.card-header {
    border-radius: 15px 15px 0 0 !important;
    font-weight: 700;
    padding: 18px 25px;
}

.card-header.bg-primary {
    background: var(--kias-gradient) !important;
}

.card-header.bg-success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
}

.card-header.bg-warning {
    background: linear-gradient(135deg, #f39c12 0%, #f1c40f 100%) !important;
}

/* Table */
.table {
    margin-bottom: 0;
}

.table-bordered {
    border-radius: 10px;
    overflow: hidden;
}

.table-bordered thead {
    background: rgba(53, 144, 144, 0.1);
}

/* Responsive */
@media (max-width: 768px) {
    .hero-section h1 {
        font-size: 2rem;
    }

    .hero-section h2 {
        font-size: 1.5rem;
    }

    .section-title h2 {
        font-size: 2rem;
    }

    .cta-section h2 {
        font-size: 2rem;
    }

    .form-section {
        padding: 25px 20px;
    }
}
</style>

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-10 hero-content">
                <h1 class="display-4">Penerimaan Santri Baru</h1>
                <h2>Tahun Ajaran {{ $psb->tahun_ajaran ?? '2026/2027' }}</h2>
                <p class="lead">Tersedia program <strong>Tajwid Al-Qur'an, Bahasa Arab Reguler, dan Bahasa Arab Takmili</strong></p>
                @if($psb && $psb->akhir_psb)
                <p class="mb-4"><i class="ti ti-calendar me-2"></i>Batas akhir pendaftaran: <strong>{{ TanggalHelper::konversiTanggalPenuh($psb->akhir_psb) }}</strong></p>
                @endif
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="#program" class="btn btn-light btn-hero">
                        <i class="ti ti-book me-2"></i>Lihat Program
                    </a>
                    <a href="#pendaftaran" class="btn btn-outline-light btn-hero" style="color: white !important; border-color: white !important;">
                        <i class="ti ti-edit me-2"></i>Daftar Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Program Section -->
<section id="program" class="psb-section">
    <div class="container">
        <div class="section-title">
            <h2>Program Pendidikan</h2>
            <p>Pilih program yang sesuai dengan kebutuhan Anda</p>
        </div>

        <div class="row g-4">
            @if($tajwid && $tajwid->count() > 0)
            @foreach($tajwid as $program)
            <div class="col-md-6 col-lg-4">
                <div class="program-card">
                    <span class="badge badge-tajwid">Tajwid Al-Qur'an</span>
                    <h4>{{ str_replace('Al-Barkah ', '', $program->nama_program) }}</h4>
                    <p class="mb-0"><strong>Persyaratan:</strong><br>{{ $program->persyaratan ?? 'Belajar Membaca dan Menulis Al-Qur\'an' }}</p>
                </div>
            </div>
            @endforeach
            @endif

            @if($bahasaArab && $bahasaArab->count() > 0)
            @foreach($bahasaArab as $program)
            <div class="col-md-6 col-lg-4">
                <div class="program-card">
                    <span class="badge badge-ba">Bahasa Arab Reguler</span>
                    <h4>{{ str_replace('Al-Barkah ', '', $program->nama_program) }}</h4>
                    <p class="mb-0"><strong>Persyaratan:</strong><br>{{ $program->persyaratan ?? 'Program belajar bahasa Arab intensif' }}</p>
                </div>
            </div>
            @endforeach
            @endif

            @if($takmili && $takmili->count() > 0)
            @foreach($takmili as $program)
            <div class="col-md-6 col-lg-4">
                <div class="program-card">
                    <span class="badge badge-takmili">Bahasa Arab Takmili</span>
                    <h4>{{ str_replace('Al-Barkah ', '', $program->nama_program) }}</h4>
                    <p class="mb-0"><strong>Persyaratan:</strong><br>{{ $program->persyaratan ?? 'Program pendalaman bahasa Arab' }}</p>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>

<!-- Biaya Section -->
<section id="biaya" class="psb-section" style="background: linear-gradient(135deg, rgba(53, 144, 144, 0.05) 0%, rgba(38, 112, 132, 0.05) 100%);">
    <div class="container">
        <div class="section-title">
            <h2>Biaya Pendidikan</h2>
            <p>Investasi ilmu yang barokah, inshaAllah</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="biaya-table">
                    <div class="table-header">
                        <h3><i class="ti ti-currency-dollar me-2"></i>Rincian Biaya</h3>
                    </div>
                    <table class="table">
                        <tr>
                            <td>Biaya Pendaftaran</td>
                            <td class="biaya-amount">Rp 150.000</td>
                        </tr>
                        <tr>
                            <td>Sarana Prasarana</td>
                            <td class="biaya-amount">Rp 300.000</td>
                        </tr>
                        <tr>
                            <td>Kuliah Perdana</td>
                            <td class="biaya-amount">Rp 250.000</td>
                        </tr>
                        <tr>
                            <td>SPP Bulanan</td>
                            <td class="biaya-amount">Rp 250.000</td>
                        </tr>
                    </table>
                </div>

                <div class="info-box mt-4">
                    <h5><i class="ti ti-info-circle me-2"></i>Catatan Biaya</h5>
                    <ul class="mb-0">
                        <li>Biaya Pendaftaran dibayarkan sekali di awal</li>
                        <li>Biaya Sarana Prasarana untuk fasilitas belajar</li>
                        <li>Biaya Kuliah Perdana dibayarkan saat mulai kuliah</li>
                        <li>SPP Bulanan dibayarkan setiap bulan</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Alur Test Section -->
<section id="alur-test" class="psb-section">
    <div class="container">
        <div class="section-title">
            <h2>Alur Test Calon Santri</h2>
            <p>Tahapan seleksi penerimaan santri baru</p>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0" style="color: white;"><i class="ti ti-calendar me-2"></i>Alur Test - Sabtu, 22 Agustus 2026</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alur-step">
                            <div class="step-number">1</div>
                            <div class="step-content">Membawa F2 (Formulir Pendaftaran)</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">2</div>
                            <div class="step-content">Menyerahkan F2 ke Panitia</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">3</div>
                            <div class="step-content">Memasuki ruang Test</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">4</div>
                            <div class="step-content">Menunggu panggilan</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">5</div>
                            <div class="step-content">Melaksanakan Tes Lisan dan Tulis</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">6</div>
                            <div class="step-content">Mengambil F2 dari Panitia Tes Lisan & Tulis</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">7</div>
                            <div class="step-content">Menyerahkan F2 ke Panitia</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">8</div>
                            <div class="step-content">Mengambil F2 dari Panitia</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">9</div>
                            <div class="step-content"><strong>Melihat Pengumuman - 29 Agustus 2026</strong></div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">10</div>
                            <div class="step-content"><strong>Bayar Daftar Ulang dan SPP - 5 September 2026</strong></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0" style="color: white;"><i class="ti ti-check-circle me-2"></i>Pelaksanaan Tes</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="form-check mb-3 p-3 bg-light rounded">
                            <input class="form-check-input" type="checkbox" id="tesTulis" checked disabled>
                            <label class="form-check-label" for="tesTulis">
                                <strong>Mengikuti Tes Tulis</strong>
                            </label>
                        </div>
                        <div class="form-check mb-3 p-3 bg-light rounded">
                            <input class="form-check-input" type="checkbox" id="tesWawancara" checked disabled>
                            <label class="form-check-label" for="tesWawancara">
                                <strong>Tes Wawancara</strong>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0" style="color: white;"><i class="ti ti-school me-2"></i>Alur Kuliah Perdana</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="alur-step">
                            <div class="step-number">1</div>
                            <div class="step-content">Menukar F2 di Kantor</div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">2</div>
                            <div class="step-content">Membayar Uang Sarana Prasarana dan Maintenance <strong>Rp 300.000</strong></div>
                        </div>
                        <div class="alur-step">
                            <div class="step-number">3</div>
                            <div class="step-content">Membayar Uang Kuliah Sept. <strong>Rp 250.000</strong></div>
                        </div>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3 text-primary">Jadwal Kuliah Perdana:</h6>
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead class="table-light">
                                    <tr>
                                        <th>Program</th>
                                        <th>Tanggal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><strong>Tajwid Al-Qur'an</strong></td>
                                        <td>Sabtu, 5 Sept 2026</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bahasa Arab Reguler</strong></td>
                                        <td>Sabtu, 5 Sept 2026</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Bahasa Arab Takmili</strong></td>
                                        <td>Sabtu, 5 Sept 2026</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Pendaftaran Form Section -->
<section id="pendaftaran" class="psb-section" style="background: linear-gradient(135deg, rgba(53, 144, 144, 0.05) 0%, rgba(38, 112, 132, 0.05) 100%);">
    <div class="container">
        <div class="section-title">
            <h2>Formulir Pendaftaran</h2>
            <p>Isi formulir pendaftaran dengan data yang benar</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                <form action="{{ route('psb.register') }}" method="POST" enctype="multipart/form-data" id="registrationForm" novalidate>
                    @csrf

                    <!-- Data Diri -->
                    <div class="form-section">
                        <h5><i class="ti ti-user me-2"></i>Data Diri</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required minlength="3" placeholder="Masukkan nama lengkap">
                                @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_l" value="L" {{ old('jenis_kelamin') == 'L' ? 'checked' : '' }} required>
                                        <label class="form-check-label" for="jk_l">Laki-laki (Ikhwan)</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="jenis_kelamin" id="jk_p" value="P" {{ old('jenis_kelamin') == 'P' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="jk_p">Perempuan (Akhwat)</label>
                                    </div>
                                </div>
                                @error('jenis_kelamin')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK (16 digit) <span class="text-danger">*</span></label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" maxlength="16" required placeholder="Contoh: 3201234567890123">
                                @error('nik')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NISN (10 digit) <span class="text-danger">*</span></label>
                                <input type="text" name="nisn" class="form-control @error('nisn') is-invalid @enderror" value="{{ old('nisn') }}" maxlength="10" required placeholder="Contoh: 0012345678">
                                @error('nisn')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir') }}" required placeholder="Kota/Kabupaten">
                                @error('tempat_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir') }}" required>
                                @error('tanggal_lahir')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat Lengkap <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror" rows="3" required minlength="10" placeholder="Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kabupaten">{{ old('alamat') }}</textarea>
                                @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required placeholder="Contoh: nama.anda@gmail.com">
                                <small class="text-muted d-block mt-1">Email akan digunakan untuk login dan menerima notifikasi</small>
                                @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">No. HP (Aktif)</label>
                                <input type="tel" name="no_hp" class="form-control" value="{{ old('no_hp') }}" placeholder="08xxxxxxxxxx">
                                <small class="text-muted d-block mt-1">Contoh: 089619060672</small>
                            </div>
                        </div>
                    </div>

                    <!-- Data Orang Tua/Wali -->
                    <div class="form-section">
                        <h5><i class="ti ti-users me-2"></i>Data Orang Tua/Wali <small class="text-muted">(Minimal salah satu harus diisi)</small></h5>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}" placeholder="Nama lengkap ayah">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">No. HP Ayah</label>
                                <input type="tel" name="no_hp_ayah" class="form-control" value="{{ old('no_hp_ayah') }}" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nama Ibu</label>
                                <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}" placeholder="Nama lengkap ibu">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">No. HP Ibu</label>
                                <input type="tel" name="no_hp_ibu" class="form-control" value="{{ old('no_hp_ibu') }}" placeholder="08xxxxxxxxxx">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Nama Wali</label>
                                <input type="text" name="nama_wali" class="form-control" value="{{ old('nama_wali') }}" placeholder="Nama lengkap wali">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">No. HP Wali</label>
                                <input type="tel" name="no_hp_wali" class="form-control" value="{{ old('no_hp_wali') }}" placeholder="08xxxxxxxxxx">
                            </div>
                        </div>
                        @error('nama_ayah')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        @error('no_hp_ayah')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        @error('no_hp_ibu')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        @error('no_hp_wali')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Program -->
                    <div class="form-section">
                        <h5><i class="ti ti-book me-2"></i>Program Pilihan</h5>
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Pilih Program <span class="text-danger">*</span></label>
                                <select name="program_id" class="form-select @error('program_id') is-invalid @enderror" required>
                                    <option value="">-- Pilih Program --</option>
                                    @foreach($programs as $program)
                                    <option value="{{ $program->id }}" {{ old('program_id') == $program->id ? 'selected' : '' }}>
                                        @php
                                            $nama = str_replace('Al-Barkah ', '', $program->nama_program);
                                            $map = [
                                                'Tajwidul Quran' => 'Tajwid Al-Qur\'an',
                                                'BA Reguler' => 'Bahasa Arab Reguler',
                                                'BA Takmili' => 'Bahasa Arab Takmili',
                                                'BA TAKMILI' => 'Bahasa Arab Takmili',
                                            ];
                                            echo $map[$nama] ?? $nama;
                                        @endphp
                                    </option>
                                    @endforeach
                                </select>
                                @error('program_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Upload Dokumen -->
                    <div class="form-section">
                        <h5><i class="ti ti-upload me-2"></i>Upload Dokumen</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">KTP / Kartu Identitas <span class="text-danger">*</span></label>
                                <input type="file" name="ktp" class="form-control @error('ktp') is-invalid @enderror" accept="image/*,.pdf" required>
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, PDF. Maks: 2MB</small>
                                @error('ktp')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto 4x6 <span class="text-danger">*</span></label>
                                <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror" accept="image/*" required>
                                <small class="text-muted d-block mt-1">Format: JPG, PNG. Maks: 2MB</small>
                                @error('foto')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ijazah SMA/Sederajat <span class="text-danger">*</span></label>
                                <input type="file" name="ijazah" class="form-control @error('ijazah') is-invalid @enderror" accept="image/*,.pdf" required>
                                <small class="text-muted d-block mt-1">Format: JPG, PNG, PDF. Maks: 5MB</small>
                                @error('ijazah')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Bukti Pembayaran <span class="text-danger">*</span></label>
                                <input type="file" name="bukti_pembayaran" class="form-control @error('bukti_pembayaran') is-invalid @enderror" accept="image/*" required>
                                <small class="text-muted d-block mt-1">Format: JPG, PNG. Maks: 2MB</small>
                                @error('bukti_pembayaran')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Persetujuan -->
                    <div class="form-section">
                        <div class="agreement-checkbox">
                            <input type="checkbox" name="agreement" id="agreement" required>
                            <label for="agreement">
                                <strong>Saya menyatakan bahwa:</strong><br>
                                1. Data yang saya isi adalah benar dan dapat dipertanggungjawabkan.<br>
                                2. Saya telah membaca dan menyetujui syarat dan ketentuan pendaftaran.<br>
                                3. Saya memahami bahwa pendaftaran belum pasti diterima sebelum proses verifikasi selesai.
                            </label>
                        </div>
                        @error('agreement')
                        <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info mt-4">
                        <h6 class="alert-heading"><i class="ti ti-info-circle me-2"></i>Informasi Login</h6>
                        <hr class="my-2">
                        <p class="mb-1"><strong>Email Login:</strong> Email yang Anda isi di formulir</p>
                        <p class="mb-0"><strong>Password:</strong> Nomor Peserta (Kode Registrasi) yang akan Anda terima setelah pendaftaran berhasil</p>
                        <p class="mb-0"><strong>Group WhatsApp:</strong> Peserta diharap segera masuk link group WhatsApp di dashboard yang akan muncul setelah pembayaran dikonfirmasi oleh admin</p>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary btn-lg px-5">
                            <i class="ti ti-send me-2"></i>Kirim Pendaftaran
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<!-- Pembayaran Section -->
<section id="pembayaran" class="psb-section">
    <div class="container">
        <div class="section-title">
            <h2>Informasi Pembayaran</h2>
            <p>Lakukan pembayaran biaya pendaftaran</p>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="payment-info">
                    <div class="text-center mb-4">
                        <h4 class="fw-bold text-primary">Biaya Pendaftaran</h4>
                        <h2 class="text-primary fw-bold display-6">Rp 150.000</h2>
                    </div>

                    <div class="bank-details">
                        <h4><i class="ti ti-building-bank me-2"></i>Transfer ke Rekening</h4>
                        <p class="mb-2">Bank : <strong>BSI (Bank Syariah Indonesia)</strong></p>
                        <div class="account-number">756 2929 007</div>
                        <p class="mb-0">Atas Nama : <strong>Yayasan Cahaya Sunnah</strong></p>
                    </div>

                    <div class="alert alert-info mb-0">
                        <h6 class="alert-heading"><i class="ti ti-info-circle me-2"></i>Cara Pembayaran</h6>
                        <hr class="my-2">
                        <ol class="mb-0">
                            <li>Transfer sesuai nominal biaya pendaftaran (<strong>Rp 150.000</strong>)</li>
                            <li>Simpan bukti transfer dengan baik</li>
                            <li>Upload bukti pembayaran di formulir pendaftaran</li>
                            <li>Pendaftaran akan diverifikasi dalam 1x24 jam kerja</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <h2 style="color: white;">Siap Menjadi Bagian dari KIAS Syathiby?</h2>
                <p class="lead mb-4">Segera daftarkan diri Anda dan raih ilmu yang barokah, inshaAllah</p>
                <a href="#pendaftaran" class="btn btn-light btn-lg px-5">
                    <i class="ti ti-user-plus me-2"></i>Daftar Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Loading Overlay -->
<div id="loadingOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.65);z-index:9999;align-items:center;justify-content:center;flex-direction:column;">
    <div style="text-align:center;color:#fff;">
        <div class="spinner-border mb-3" style="width:3.5rem;height:3.5rem;color:#8dc794;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <h5 style="font-weight:700;margin-bottom:8px;">Sedang Memproses Pendaftaran...</h5>
        <p style="color:rgba(255,255,255,0.75);font-size:0.9rem;margin:0;">Mohon tunggu, jangan tutup halaman ini</p>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.65);z-index:9999;align-items:center;justify-content:center;">
    <div style="background:#fff;border-radius:20px;padding:50px 40px;text-align:center;max-width:480px;width:92%;box-shadow:0 20px 60px rgba(0,0,0,0.3);">
        <div style="width:80px;height:80px;background:linear-gradient(135deg,#28a745,#20c997);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;">
            <i class="ti ti-check" style="font-size:2.5rem;color:#fff;"></i>
        </div>
        <h3 style="color:#1a5252;font-weight:800;margin-bottom:8px;">Pendaftaran Berhasil!</h3>
        <p style="color:#6c757d;margin-bottom:20px;">Selamat! Data pendaftaran Anda telah berhasil disimpan dan sedang menunggu verifikasi.</p>
        <div style="background:linear-gradient(135deg,rgba(53,144,144,0.1),rgba(38,112,132,0.1));border-radius:12px;padding:20px;margin-bottom:20px;border:2px solid rgba(53,144,144,0.3);">
            <p style="color:#6c757d;margin-bottom:6px;font-size:0.85rem;">Nomor Peserta Anda:</p>
            <div id="kodeRegistrasi" style="color:#1a5252;font-weight:800;font-size:1.9rem;letter-spacing:3px;"></div>
        </div>
        <p style="color:#6c757d;font-size:0.85rem;margin-bottom:20px;">Simpan nomor ini — digunakan sebagai <strong>password login</strong> ke dashboard peserta.</p>
        <p style="color:#adb5bd;font-size:0.82rem;">Mengalihkan ke dashboard dalam <strong id="countdown" style="color:#359090;">5</strong> detik...</p>
    </div>
</div>
@endsection

@push('pageJS')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(function(anchor) {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });

    // Scroll to first server-side error on page load
    const firstError = document.querySelector('.is-invalid');
    if (firstError) {
        scrollToElement(firstError);
        setTimeout(function() { firstError.focus(); }, 300);
    }

    const form = document.getElementById('registrationForm');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        clearErrors();

        const errorFields = [];

        // Nama
        const nama = form.querySelector('[name="nama"]');
        if (!nama.value.trim()) {
            addError(nama, 'Nama lengkap harus diisi');
            errorFields.push(nama);
        } else if (nama.value.trim().length < 3) {
            addError(nama, 'Nama minimal 3 karakter');
            errorFields.push(nama);
        }

        // Jenis Kelamin
        if (!form.querySelector('[name="jenis_kelamin"]:checked')) {
            const jkWrap = form.querySelector('#jk_l').closest('.d-flex');
            addErrorAfter(jkWrap, 'Jenis kelamin harus dipilih', 'err_jk');
            errorFields.push(form.querySelector('#jk_l'));
        }

        // NIK
        const nik = form.querySelector('[name="nik"]');
        if (!nik.value.trim()) {
            addError(nik, 'NIK harus diisi');
            errorFields.push(nik);
        } else if (nik.value.trim().length !== 16) {
            addError(nik, 'NIK harus tepat 16 digit');
            errorFields.push(nik);
        }

        // NISN
        const nisn = form.querySelector('[name="nisn"]');
        if (!nisn.value.trim()) {
            addError(nisn, 'NISN harus diisi');
            errorFields.push(nisn);
        } else if (nisn.value.trim().length !== 10) {
            addError(nisn, 'NISN harus tepat 10 digit');
            errorFields.push(nisn);
        }

        // Tempat Lahir
        const tempatLahir = form.querySelector('[name="tempat_lahir"]');
        if (!tempatLahir.value.trim()) {
            addError(tempatLahir, 'Tempat lahir harus diisi');
            errorFields.push(tempatLahir);
        }

        // Tanggal Lahir
        const tanggalLahir = form.querySelector('[name="tanggal_lahir"]');
        if (!tanggalLahir.value) {
            addError(tanggalLahir, 'Tanggal lahir harus diisi');
            errorFields.push(tanggalLahir);
        } else if (new Date(tanggalLahir.value) >= new Date()) {
            addError(tanggalLahir, 'Tanggal lahir harus sebelum hari ini');
            errorFields.push(tanggalLahir);
        }

        // Alamat
        const alamat = form.querySelector('[name="alamat"]');
        if (!alamat.value.trim()) {
            addError(alamat, 'Alamat lengkap harus diisi');
            errorFields.push(alamat);
        } else if (alamat.value.trim().length < 10) {
            addError(alamat, 'Alamat minimal 10 karakter');
            errorFields.push(alamat);
        }

        // Email
        const email = form.querySelector('[name="email"]');
        if (!email.value.trim()) {
            addError(email, 'Email harus diisi');
            errorFields.push(email);
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
            addError(email, 'Format email tidak valid');
            errorFields.push(email);
        }

        // Orang Tua / Wali
        const namaAyah = form.querySelector('[name="nama_ayah"]').value.trim();
        const noHpAyah = form.querySelector('[name="no_hp_ayah"]').value.trim();
        const namaIbu  = form.querySelector('[name="nama_ibu"]').value.trim();
        const noHpIbu  = form.querySelector('[name="no_hp_ibu"]').value.trim();
        const namaWali = form.querySelector('[name="nama_wali"]').value.trim();
        const noHpWali = form.querySelector('[name="no_hp_wali"]').value.trim();

        if (!namaAyah && !namaIbu && !namaWali) {
            const namaAyahInput = form.querySelector('[name="nama_ayah"]');
            addError(namaAyahInput, 'Minimal salah satu data orang tua/wali harus diisi');
            errorFields.push(namaAyahInput);
        } else {
            if (namaAyah && !noHpAyah) {
                const f = form.querySelector('[name="no_hp_ayah"]');
                addError(f, 'No. HP Ayah harus diisi karena Nama Ayah sudah terisi');
                errorFields.push(f);
            }
            if (namaIbu && !noHpIbu) {
                const f = form.querySelector('[name="no_hp_ibu"]');
                addError(f, 'No. HP Ibu harus diisi karena Nama Ibu sudah terisi');
                errorFields.push(f);
            }
            if (namaWali && !noHpWali) {
                const f = form.querySelector('[name="no_hp_wali"]');
                addError(f, 'No. HP Wali harus diisi karena Nama Wali sudah terisi');
                errorFields.push(f);
            }
        }

        // Program
        const programId = form.querySelector('[name="program_id"]');
        if (!programId.value) {
            addError(programId, 'Program harus dipilih');
            errorFields.push(programId);
        }

        // File uploads
        const ktp = form.querySelector('[name="ktp"]');
        if (!ktp.files || !ktp.files.length) {
            addError(ktp, 'KTP / kartu identitas harus diupload');
            errorFields.push(ktp);
        }

        const foto = form.querySelector('[name="foto"]');
        if (!foto.files || !foto.files.length) {
            addError(foto, 'Foto harus diupload');
            errorFields.push(foto);
        }

        const ijazah = form.querySelector('[name="ijazah"]');
        if (!ijazah.files || !ijazah.files.length) {
            addError(ijazah, 'Ijazah harus diupload');
            errorFields.push(ijazah);
        }

        const bukti = form.querySelector('[name="bukti_pembayaran"]');
        if (!bukti.files || !bukti.files.length) {
            addError(bukti, 'Bukti pembayaran harus diupload');
            errorFields.push(bukti);
        }

        // Agreement
        const agreement = document.getElementById('agreement');
        if (!agreement.checked) {
            addErrorAfter(agreement.closest('.agreement-checkbox'), 'Anda harus menyetujui syarat dan ketentuan', 'err_agreement');
            errorFields.push(agreement);
        }

        if (errorFields.length > 0) {
            scrollToElement(errorFields[0]);
            errorFields[0].focus();
            return;
        }

        // All client-side checks passed — submit via AJAX
        showLoading();

        fetch(form.action, {
            method: 'POST',
            body: new FormData(form),
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function(response) {
            return response.json().then(function(data) {
                return { status: response.status, data: data };
            });
        })
        .then(function(result) {
            hideLoading();

            if (result.status === 200 && result.data.success) {
                showSuccess(result.data.kode, result.data.redirect);
                return;
            }

            // Server-side validation errors (422)
            if (result.status === 422 && result.data.errors) {
                clearErrors();
                const serverErrors = [];
                Object.keys(result.data.errors).forEach(function(field) {
                    const input = form.querySelector('[name="' + field + '"]');
                    if (input) {
                        addError(input, result.data.errors[field][0]);
                        serverErrors.push(input);
                    }
                });
                if (serverErrors.length > 0) scrollToElement(serverErrors[0]);
                return;
            }

            // Other server errors
            showServerError(result.data.message || 'Terjadi kesalahan. Silakan coba lagi.');
        })
        .catch(function() {
            hideLoading();
            showServerError('Koneksi gagal. Silakan periksa koneksi internet Anda dan coba lagi.');
        });
    });
});

function showLoading() {
    const el = document.getElementById('loadingOverlay');
    el.style.display = 'flex';
}

function hideLoading() {
    const el = document.getElementById('loadingOverlay');
    el.style.display = 'none';
}

function showSuccess(kode, redirectUrl) {
    document.getElementById('kodeRegistrasi').textContent = kode;
    document.getElementById('successModal').style.display = 'flex';

    let count = 5;
    const countEl = document.getElementById('countdown');
    const timer = setInterval(function() {
        count--;
        countEl.textContent = count;
        if (count <= 0) {
            clearInterval(timer);
            window.location.href = redirectUrl;
        }
    }, 1000);
}

function showServerError(message) {
    const existing = document.getElementById('server-error-alert');
    if (existing) existing.remove();

    const alert = document.createElement('div');
    alert.id = 'server-error-alert';
    alert.className = 'alert alert-danger alert-dismissible fade show';
    alert.setAttribute('role', 'alert');
    alert.innerHTML = '<strong>Gagal!</strong> ' + message +
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';

    const formSection = document.getElementById('pendaftaran');
    if (formSection) {
        formSection.insertAdjacentElement('beforebegin', alert);
        scrollToElement(alert);
    }
}

function addError(input, message) {
    input.classList.add('is-invalid');
    const existing = input.parentElement.querySelector('.client-error');
    if (existing) existing.remove();
    const div = document.createElement('div');
    div.className = 'invalid-feedback client-error d-block';
    div.textContent = message;
    input.insertAdjacentElement('afterend', div);
}

function addErrorAfter(element, message, id) {
    const existing = document.getElementById(id);
    if (existing) existing.remove();
    const div = document.createElement('div');
    div.id = id;
    div.className = 'text-danger small mt-1 client-error';
    div.textContent = message;
    element.insertAdjacentElement('afterend', div);
}

function clearErrors() {
    document.querySelectorAll('.client-error').forEach(function(el) { el.remove(); });
    document.querySelectorAll('.is-invalid').forEach(function(el) { el.classList.remove('is-invalid'); });
}

function scrollToElement(element) {
    if (!element) return;
    const top = element.getBoundingClientRect().top + window.pageYOffset - 100;
    window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
}
</script>
@endpush
