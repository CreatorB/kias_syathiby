@extends('layouts.landing.page')

@section('content')
    <!--hero section start-->
    <section id="home" class="fullscreen-banner" data-bg-img="{{ asset('landing/images/pattern/03.png') }}">
        <div class="align-center p-0">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <h1 class="mb-4 fw-normal wow fadeInUp" data-wow-duration="2s">Informasi
                            <span class="fw-bold text-uppercase">Penerimaan Santri Baru</span> Tahun Ajaran
                            {{ $psb->tahun_ajaran }}
                        </h1>
                        <p class="lead mb-4 wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.3s">
                            Tersedia program <b>Tajwid Al-Qur'an, Bahasa Arab, Takmili dan Ulum Asy-Syariah</b>, batas akhir
                            pendaftaran <b>{{ \App\Helpers\TanggalHelper::konversiTanggalPenuh($psb->akhir_psb) }}</b>
                        </p>
                        <a class="btn btn-theme wow fadeInUp" data-wow-duration="3s" data-wow-delay="0.5s"
                            href="/pilih-program" data-text="Daftar">
                            <span>S</span><span>a</span><span>n</span><span>t</span><span>r</span><span>i</span>
                            <span> </span><span>B</span><span>a</span><span>r</span><span>u</span>
                        </a>
                        <a class="btn btn-dark wow fadeInUp" data-wow-duration="3s" data-wow-delay="0.5s"
                            href="#pilihProgram" data-text="Info">
                            <span>P</span><span>r</span><span>o</span><span>g</span><span>r</span><span>a</span><span>m</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--hero section end-->


    <!--body content start-->
    <div class="page-content">
        <!--Pilihan Program-->
        <section id="pilihProgram" class="position-relative overflow-hidden wow fadeInUp" data-wow-duration="2s">
            <div class="bg-animation">
                <img class="zoom-fade" src="{{ asset('landing/images/pattern/03.png') }}" alt="">
            </div>
            <div class="container z-index-1">
                <div class="row text-center">
                    <div class="col-lg-8 col-md-10 mx-auto">
                        <div class="section-title">
                            <h2 class="title">Pilihan <span class="text-theme">program pendidikan</span> yang tersedia</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="tab style-2">
                            <!-- Nav tabs -->
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-tab1" data-bs-toggle="tab" href="#tab1-1"
                                        role="tab" aria-selected="true">
                                        <i class="la la-book"></i>
                                        <h5>Tajwid Quran</h5>
                                    </a>
                                    <a class="nav-item nav-link" id="nav-tab2" data-bs-toggle="tab" href="#tab1-2"
                                        role="tab" aria-selected="false">
                                        <i class="la la-book-open"></i>
                                        <h5>Bahasa Arab</h5>
                                    </a>
                                    <a class="nav-item nav-link" id="nav-tab3" data-bs-toggle="tab" href="#tab1-3"
                                        role="tab" aria-selected="false">
                                        <i class="la la-pen-nib"></i>
                                        <h5>Takmili</h5>
                                    </a>
                                    <a class="nav-item nav-link" id="nav-tab4" data-bs-toggle="tab" href="#tab1-4"
                                        role="tab" aria-selected="false">
                                        <i class="la la-school"></i>
                                        <h5>Ulum Syari'ah</h5>
                                    </a>
                                </div>
                            </nav>
                            <!-- Tab panes -->
                            <div class="tab-content" id="nav-tabContent">
                                <div role="tabpanel" class="tab-pane fade show active" id="tab1-1">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="accordion ms-lg-5" id="accordion">
                                                @foreach ($tajwid as $item)
                                                    <div class="accordion-item border-0 mb-4">
                                                        <h2 class="accordion-header" id="heading{{ $item->id }}">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $item->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse{{ $item->id }}">
                                                                {{ $item->nama_program }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{ $item->id }}"
                                                            class="accordion-collapse collapse border-0"
                                                            aria-labelledby="heading{{ $item->id }}"
                                                            data-bs-parent="#accordion">
                                                            <div class="accordion-body">
                                                                Persyaratan : {{ $item->persyaratan }}<br>
                                                                Paket : {{ $item->durasi_belajar }} Tahun<br><br>
                                                                Hari : {{ $item->hari_belajar }}<br>
                                                                Waktu : {{ $item->waktu_belajar }}<br>
                                                                Tempat : {{ $item->tempat_belajar }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab1-2">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="accordion ms-lg-5" id="accordion">
                                                @foreach ($bahasaArab as $item)
                                                    <div class="accordion-item border-0 mb-4">
                                                        <h2 class="accordion-header" id="heading{{ $item->id }}">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $item->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse{{ $item->id }}">
                                                                {{ $item->nama_program }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{ $item->id }}"
                                                            class="accordion-collapse collapse border-0"
                                                            aria-labelledby="heading{{ $item->id }}"
                                                            data-bs-parent="#accordion">
                                                            <div class="accordion-body">
                                                                Persyaratan : {{ $item->persyaratan }}<br>
                                                                Paket : {{ $item->durasi_belajar }} Tahun<br><br>
                                                                Hari : {{ $item->hari_belajar }}<br>
                                                                Waktu : {{ $item->waktu_belajar }}<br>
                                                                Tempat : {{ $item->tempat_belajar }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab1-3">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="accordion ms-lg-5" id="accordion">
                                                @foreach ($takmili as $item)
                                                    <div class="accordion-item border-0 mb-4">
                                                        <h2 class="accordion-header" id="heading{{ $item->id }}">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $item->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse{{ $item->id }}">
                                                                {{ $item->nama_program }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{ $item->id }}"
                                                            class="accordion-collapse collapse border-0"
                                                            aria-labelledby="heading{{ $item->id }}"
                                                            data-bs-parent="#accordion">
                                                            <div class="accordion-body">
                                                                Persyaratan : {{ $item->persyaratan }}<br>
                                                                Paket : {{ $item->durasi_belajar }} Tahun<br><br>
                                                                Hari : {{ $item->hari_belajar }}<br>
                                                                Waktu : {{ $item->waktu_belajar }}<br>
                                                                Tempat : {{ $item->tempat_belajar }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane fade" id="tab1-4">
                                    <div class="row align-items-center">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="accordion ms-lg-5" id="accordion">
                                                @foreach ($syariah as $item)
                                                    <div class="accordion-item border-0 mb-4">
                                                        <h2 class="accordion-header" id="heading{{ $item->id }}">
                                                            <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse"
                                                                data-bs-target="#collapse{{ $item->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="collapse{{ $item->id }}">
                                                                {{ $item->nama_program }}
                                                            </button>
                                                        </h2>
                                                        <div id="collapse{{ $item->id }}"
                                                            class="accordion-collapse collapse border-0"
                                                            aria-labelledby="heading{{ $item->id }}"
                                                            data-bs-parent="#accordion">
                                                            <div class="accordion-body">
                                                                Persyaratan : {{ $item->persyaratan }}<br>
                                                                Paket : {{ $item->durasi_belajar }} Tahun<br><br>
                                                                Hari : {{ $item->hari_belajar }}<br>
                                                                Waktu : {{ $item->waktu_belajar }}<br>
                                                                Tempat : {{ $item->tempat_belajar }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--#Pilihan Program-->

        <!--Agenda PSB-->
        <section class="position-relative wow fadeInUp" data-wow-duration="2s">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-6 col-md-12 image-column right p-0">
                        <img class="img-fluid" src="{{ asset('landing/images/banner/agenda.svg') }}" alt="">
                    </div>
                    <div class="col-xl-5 col-lg-6 col-md-12 me-auto mt-5 mt-lg-0">
                        <div class="accordion" id="accordion2">
                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Waktu Pendaftaran
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse border-0 show"
                                    aria-labelledby="headingOne" data-bs-parent="#accordion">
                                    <div class="accordion-body">Pendaftaran Online/Offline : Dimulai dari
                                        <b>{{ $teknisDaftar->periode }}</b></div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header" id="headingEnam">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseEnam" aria-expanded="false"
                                        aria-controls="collapseEnam">
                                        Teknis Pendaftaran
                                    </button>
                                </h2>
                                <div id="collapseEnam" class="accordion-collapse collapse border-0"
                                    aria-labelledby="headingEnam" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        <ul>
                                            Pendaftaran bisa dilakukan dengan 2 cara, yaitu:<br>
                                            1. <b>Online</b> melalui link <a href="/pilih-program" target="_blank">Daftar
                                                Online</a><br>
                                            2. <b>Offline</b> dengan cara datang langsung ke kantor sekretariat dengan jam
                                            operasional :<br><br>
                                            Hari : <b>{{ $teknisDaftar->hari }}</b><br>
                                            Waktu : <b>{{ $teknisDaftar->waktu }}</b> <br>
                                            Tempat : <b>{{ $teknisDaftar->tempat }}</b><br>
                                            {{ $teknisDaftar->alamat_tempat }}
                                        </ul>
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Pelaksanaan Tes Masuk
                                    </button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse border-0"
                                    aria-labelledby="headingTwo" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        Calon santri yang telah mengisi formulir dan melakukan konfirmasi biaya pendaftaran,
                                        bisa mengikuti tes masuk yang insya allah akan dilaksanakan pada:<br><br>
                                        @foreach ($tesMasuk as $data => $items)
                                            Cabang : {{ $items[0]->cabang->nama }}<br>
                                            @foreach ($items as $item)
                                            Hari : <b>{{ $item->hari }}</b> <br>
                                            Tanggal : <b>{{ $item->tanggal }}</b><br>
                                            Waktu : <b>{{ $item->waktu }}</b><br>
                                            Tempat : <b>{{ $item->tempat }}</b><br>
                                            {{ $item->cabang->nama_cabang }} <br>
                                            @endforeach
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="accordion-item border-0 mb-3">
                                <h2 class="accordion-header" id="headingThree">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseThree" aria-expanded="false"
                                        aria-controls="collapseThree">
                                        Jenis Tes
                                    </button>
                                </h2>
                                <div id="collapseThree" class="accordion-collapse collapse border-0"
                                    aria-labelledby="headingThree" data-bs-parent="#accordion">
                                    <div class="accordion-body">
                                        Setiap program memiliki jenis tes yang berbeda, yaitu:<br><br>
                                        Program Tajwid Al-Quran : <b>Tes Baca Iqra</b><br>
                                        Program Bahasa Arab : <b>Tes Baca Al Qur'an dan Menulis Huruf Hijaiyah</b><br>
                                        Program Takmili : <b>Tes Hiwar dan Kaidah Dasar Bahasa Arab</b><br>
                                        Program Ulum Asy-Syariah : <b>Tes Kemampuan Bahasa Arab Aktif (Baca Kitab)</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    <!--#AGENDA PSB-->

    <!--Persyaratan-->
    <section class="position-relative" data-bg-img="{{ asset('landing/images/bg/02.png') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 image-column p-0">
                    <img class="img-fluid" src="{{ asset('landing/images/banner/berkas.svg') }}" alt="">
                </div>
                <div class="col-lg-5 ms-auto col-md-12 mt-5 mt-lg-0">
                    <div class="section-title mb-4">
                        <div class="title-effect">
                            <div class="bar bar-top"></div>
                            <div class="bar bar-right"></div>
                            <div class="bar bar-bottom"></div>
                            <div class="bar bar-left"></div>
                        </div>
                        <h6>Apa yang harus dipersiapkan?</h6>
                        <h2>Persyaratan</h2>
                    </div>
                    <ul class="list-unstyled list-icon mb-4">
                        <li class="mb-3"><i class="la la-check"></i> Muslim/Muslimah</li>
                        <li class="mb-3"><i class="la la-check"></i> Scan/Photo KTP/KK/Kartu Pelajar</li>
                        <li class="mb-3"><i class="la la-check"></i> Photo ukuran 4x6</li>
                        <li class="mb-3"><i class="la la-check"></i> Mengisi Formulir Pendaftaran</li>
                        <li class="mb-3"><i class="la la-check"></i> Mengikuti Tes Tulis dan Wawancara</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--#Persyaratan-->

    <!--Fasilitas-->
    <section class="position-relative pt-0 wow fadeInUp mt-5" data-wow-duration="2s">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12">
                    <img class="img-fluid w-100" src="{{ asset('landing/images/banner/gedung.webp') }}" alt="">
                </div>
                <div class="col-lg-6 col-md-12 mt-5 mt-lg-0">
                    <div class="section-title mb-4">
                        <div class="title-effect title-effect-2">
                            <div class="ellipse"></div> <i class="la la-info"></i>
                        </div>
                        <h2>Sarana dan Fasilitas</h2>
                    </div>
                    <ul class="list-unstyled list-icon">
                        <li class="mb-3"><i class="la la-check"></i> Masjid Al Barkah</li>
                        <li class="mb-3"><i class="la la-check"></i> Mushola Ma'had Imam Syathiby</li>
                        <li class="mb-3"><i class="la la-check"></i> Perpustakaan Ma'had Imam Syathiby</li>
                        <li class="mb-3"><i class="la la-check"></i> Ruang Kelas Full AC</li>
                        <li><i class="la la-check"></i> Area Parkir Luas</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!--#Fasilitas-->

    <!--Biaya Pendidikan-->
    <section class="position-relative grey-bg bg-effect-2 wow fadeInUp" data-wow-duration="2s">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-8 col-md-12">
                    <div class="section-title">
                        <h2 class="title">Biaya Pendidikan</h2>
                        <p>Biaya terjangkau dengan fasilitas dan kualitas pendidikan yang optimal</p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-4 col-md-12">
                    <div class="price-table style-4">
                        <div class="price-header">
                            <div class="price-value">
                                <h2>{{ number_format($psb->biaya_pendaftaran, 0, ',', '.') }}</h2>
                                <span>Sekali Bayar</span>
                            </div>
                            <h3 class="price-title">Pendaftaran</h3>
                        </div>
                        <div class="price-list">
                            <ul class="list-unstyled">
                                <li><i class="la la-check"></i> Biaya per Program</li>
                                <li><i class="la la-check"></i> Biaya Tes Masuk (Offline)</li>
                                <li><i class="la la-check"></i> Pengembangan Lembaga</li>
                                <li><i class="la la-check"></i> Belum Termasuk Biaya Buku/Kitab</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                    <div class="price-table style-4 active">
                        <canvas id="canvas"></canvas>
                        <div class="price-header">
                            <div class="price-value">
                                <h2>{{ number_format($psb->biaya_spp, 0, ',', '.') }}</h2>
                                <span>per Bulan</span>
                            </div>
                            <h3 class="price-title">SPP Bulanan</h3>
                        </div>
                        <div class="price-list">
                            <ul class="list-unstyled">
                                <li><i class="la la-check"></i> Dibayarkan Paling Lambat Setiap Tanggal 10</li>
                                <li><i class="la la-check"></i> Biaya Pengembangan Lembaga</li>
                                <li><i class="la la-check"></i> Biaya Perawatan Fasilitas Lembaga</li>
                                <li><i class="la la-check"></i> Dibayarkan Sebanyak 12x Dalam 1 Tahun</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 mt-5 mt-lg-0">
                    <div class="price-table style-4">
                        <div class="price-header">
                            <div class="price-value">
                                <h2>{{ number_format($psb->biaya_transkrip, 0, ',', '.') }}</h2>
                                <span>Sekali Bayar</span>
                            </div>
                            <h3 class="price-title">Kelulusan</h3>
                        </div>
                        <div class="price-list">
                            <ul class="list-unstyled">
                                <li><i class="la la-check"></i> Biaya Cetak Ijazah dan Transkrip</li>
                                <li><i class="la la-check"></i> Biaya Mutasi Program :
                                    {{ number_format($psb->biaya_mutasi, 0, ',', '.') }}</li>
                                <li><i class="la la-check"></i> Dibayarkan Apabila Santri Dinyatakan Lulus</li>
                                <li><i class="la la-check"></i> Santri Harus Melunasi Seluruh Biaya SPP Terlebih Dahulu
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--#Biaya Pendidikan-->

    <!--Download Brosur-->
    <section class="position-relative bg-contain bg-pos-l" data-bg-img="{{ asset('landing/images/bg/02.png') }}">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-12 mb-3">
                    <a href="{{ asset('landing/images/PSB-2526-Depan.webp') }}" target="_blank">
                        <img class="img-fluid wow fadeInUp"
                            src="{{ asset('landing/images/psb/PSB-2526-Depan.webp') }}" alt="">
                    </a>
                </div>
                <div class="col-lg-6 col-md-12 mb-3">
                    <a href="{{ asset('landing/images/psb/PSB-2526-Belakang.webp') }}" target="_blank">
                        <img class="img-fluid wow fadeInUp"
                            src="{{ asset('landing/images/psb/PSB-2526-Belakang.webp') }}" alt="">
                    </a>
                </div>
                <div class="col-lg-12 col-12 d-flex justify-content-center">
                    <button class="btn btn-theme wow fadeInUp" onclick="location.href='/download-brosur'">
                        Download Brosur
                    </button>
                </div>
            </div>
        </div>
    </section>
    <!--#Download Brosur-->

    <!--Daftar Sekarang-->
    <div class="subscribe-box mt-3 mb-5 wow fadeInUp" data-wow-duration="2s">
        <div class="container">
            <div class="row subscribe-inner align-items-center">
                <div class="col-md-6 col-sm-12">
                    <h4>Daftar Sekarang!</h4>
                    <p class="lead mb-0">Tunggu apa lagi? ayo segera bergabung bersama kami</p>
                </div>
                <div class="col-md-6 col-sm-12 mt-3 mt-md-0">
                    <a class="btn btn-theme wow fadeInUp" data-wow-duration="3s" data-wow-delay="0.5s"
                        href="/pilih-program" data-text="Daftar">
                        <span>S</span><span>a</span><span>n</span><span>t</span><span>r</span><span>i</span>
                        <span>B</span><span>a</span><span>r</span><span>u</span>
                    </a>
                    <a class="btn btn-dark wow fadeInUp" data-wow-duration="3s" data-wow-delay="0.5s"
                        href="/profil-kias" data-text="Baca Profil">
                        <span>S</span><span>e</span><span>l</span><span>e</span><span>n</span><span>g</span><span>k</span><span>a</span><span>p</span><span>n</span><span>y</span><span>a</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--#Daftar Sekarang-->
    </div>
    <!--body content end-->
@endsection