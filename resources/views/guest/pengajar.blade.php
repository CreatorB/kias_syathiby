@extends('layouts.landing.page')

@section('content')
<!--Judul Halaman-->
<section class="page-title overflow-hidden position-relative" data-bg-color="#fbf3ed">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-7 col-md-12">
          <h1 class="title"><span>T</span>enaga Pengajar</h1>
          <p>Asatidzah berkompeten dan berpengalaman di KIAS Syathiby</p>
        </div>
        <div class="col-lg-5 col-md-12 text-lg-end mt-3 mt-lg-0">
          <nav aria-label="breadcrumb" class="page-breadcrumb">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="/">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Pengajar</li>
            </ol>
          </nav>
        </div>
      </div>
    </div>
    <div class="page-title-pattern"><img class="img-fluid" src="{{ asset('landing/images/bg/11.png') }}" alt=""></div>
</section>
<!--#Judul Halaman-->

<style>
:root {
  --kias-primary: #359090;
  --kias-dark: #1a5252;
  --kias-gradient: linear-gradient(135deg, #267084 0%, #359090 100%);
}

.pengajar-card {
    background: #fff;
    border-radius: 14px;
    padding: 22px 18px;
    text-align: center;
    box-shadow: 0 4px 18px rgba(53, 144, 144, 0.12);
    border: 1px solid rgba(53, 144, 144, 0.1);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
}

.pengajar-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(53, 144, 144, 0.22);
    border-color: var(--kias-primary);
}

.pengajar-card .nomor {
    position: absolute;
    top: 12px;
    left: 14px;
    width: 26px;
    height: 26px;
    background: var(--kias-gradient);
    color: #fff;
    border-radius: 50%;
    font-size: 0.75rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    line-height: 1;
}

.pengajar-card .avatar {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(53, 144, 144, 0.25);
    margin-bottom: 12px;
}

.pengajar-card .nama {
    font-size: 0.95rem;
    font-weight: 700;
    color: var(--kias-dark);
    line-height: 1.4;
    margin: 0;
}

.pengajar-card .gelar {
    font-size: 0.82rem;
    color: #6c757d;
    margin-top: 2px;
}

.ustadzah .avatar {
    border-color: rgba(200, 100, 150, 0.3);
}

.ustadzah .nama {
    color: #6b3a6b;
}

.section-tagline {
    background: var(--kias-gradient);
    color: #fff;
    border-radius: 14px;
    padding: 30px 40px;
    text-align: center;
    margin-top: 50px;
}

.section-tagline p {
    font-size: 1.1rem;
    font-style: italic;
    margin: 0;
    opacity: 0.95;
}
</style>

<!--Page Content-->
<section class="py-5">
    <div class="container">

        <div class="row text-center mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="section-title">
                    <h2 class="title">Tenaga Pengajar <span class="text-theme">KIAS Syathiby</span></h2>
                    <p>Program Terstruktur & Komprehensif dengan Pengajar Kompeten & Berpengalaman</p>
                </div>
            </div>
        </div>

        @php
        $pengajarList = [
            ['no' => 1,  'nama' => 'Ust. Dr. Muhammad Yasir, M.A.',        'ustadzah' => false],
            ['no' => 2,  'nama' => 'Ust. Cecep Nurrohman, B.A., M.A.',     'ustadzah' => false],
            ['no' => 3,  'nama' => 'Ust. Dr. Cecep Rahmat, Lc., M.Ag',     'ustadzah' => false],
            ['no' => 4,  'nama' => 'Ust. Zahir Al-Minangkabawi',            'ustadzah' => false],
            ['no' => 5,  'nama' => 'Ust. Irham Maulana, B.A., M.H.',       'ustadzah' => false],
            ['no' => 6,  'nama' => 'Ust. Derma Permana, B.A.',              'ustadzah' => false],
            ['no' => 7,  'nama' => 'Ust. Jufri, B.A.',                      'ustadzah' => false],
            ['no' => 8,  'nama' => 'Ust. Andi Setio, S.Pd.I',              'ustadzah' => false],
            ['no' => 9,  'nama' => 'Ust. Muhammad Irfandi, B.A., M.A.',    'ustadzah' => false],
            ['no' => 10, 'nama' => 'Ust. M. Azhar Hajid',                   'ustadzah' => false],
            ['no' => 11, 'nama' => 'Ust. Muhammad Alan, B.A.',              'ustadzah' => false],
            ['no' => 12, 'nama' => 'Ust. Rahmat H. Bachtiar, B.A., M.Pd.', 'ustadzah' => false],
            ['no' => 13, 'nama' => 'Ust. Rifki',                             'ustadzah' => false],
            ['no' => 14, 'nama' => 'Ust. Adnan Maulana',                    'ustadzah' => false],
            ['no' => 15, 'nama' => 'Usth. Ummu Rifah, B.A.',               'ustadzah' => true],
            ['no' => 16, 'nama' => 'Usth. Rifah',                           'ustadzah' => true],
            ['no' => 17, 'nama' => 'Ust. Yusuf',                            'ustadzah' => false],
        ];
        @endphp

        <div class="row g-3 g-md-4">
            @foreach($pengajarList as $p)
            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                <div class="pengajar-card {{ $p['ustadzah'] ? 'ustadzah' : '' }}">
                    <span class="nomor">{{ $p['no'] }}</span>
                    <img class="avatar" src="{{ asset('landing/images/banner/avatar.webp') }}" alt="{{ $p['nama'] }}">
                    <p class="nama">{{ $p['nama'] }}</p>
                </div>
            </div>
            @endforeach
        </div>

        <div class="section-tagline mt-5">
            <p>"Memahami Ilmu Syar'i Untuk Membangun Generasi Umat Islam yang Terbaik"</p>
        </div>

    </div>
</section>
<!--#Page Content-->
@endsection
