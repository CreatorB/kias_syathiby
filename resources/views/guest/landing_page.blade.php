@extends('layouts.landing.master')

@section('content')
<!--hero section start-->
<section id="home" class="fullscreen-banner banner p-0" data-bg-img="images/pattern/01.png">
    <div class="hero-bg">
        <img class="img-fluid" src="{{ asset('landing/images/bg/04.png') }}" alt="">
    </div>
    <div class="align-center p-0">
        <div class="container-fluid">
        <div class="row">
            <div class="col-lg-7 col-md-12 img-side">
            <img class="img-fluid" src="{{ asset('landing/images/banner/quran-banner.webp') }}" alt="">
            </div>
        </div>
        </div>
        <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-12 mt-5 mt-lg-0 ms-auto">
            <h1 class="mb-4 fw-normal wow fadeInUp" data-wow-duration="1.5s">Belajar
                <span class="fw-bold text-uppercase">Ilmu Syar'i</span> Sesuai Manhaj Salafusholih</h1>
            <p class="lead mb-4 wow fadeInUp" data-wow-duration="2s" data-wow-delay="0.3s">Bersama Asatidzah Berkompeten Dengan Mudir 'Aam : <b>{{ $lembaga->mudir }}</b></p>
            <a class="btn btn-theme wow fadeInUp" data-wow-duration="3s" data-wow-delay="0.5s" href="/psb" data-text="Daftar"> <span>S</span><span>a</span><span>n</span><span>t</span><span>r</span><span>i</span>
                <span> </span><span>B</span><span>a</span><span>r</span><span>u</span>
            </a>
            <a class="btn btn-dark wow fadeInUp" data-wow-duration="3s" data-wow-delay="0.5s" href="#program" data-text="Info"> <span>P</span><span>r</span><span>o</span><span>f</span><span>i</span><span>l</span>
            </a>
            </div>
        </div>
        </div>
    </div>
    <div class="round-shape"></div>
</section>
<!--hero section end-->


<!--body content start-->
<div class="page-content">
    <!--Program-->
    <section id="program" class="service position-relative bg-effect overflow-hidden wow fadeInUp" data-wow-duration="2s">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-8 col-md-12 mx-auto">
                    <div class="section-title">
                    <div class="title-effect title-effect-2">
                        <div class="ellipse"></div> <i class="la la-cubes"></i>
                    </div>
                    <h2 class="title">Program Pendidikan</h2>
                    <p>Kami menyediakan program yang lengkap, mulai dari tingkat pemula sampai lanjutan</p>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-5 col-md-12 order-lg-12 image-column right">
                <div class="blink-img">
                    <img class="img-fluid blinkblink" src="{{ asset('landing/images/pattern/04.png') }}" alt="">
                </div>
                <img class="img-fluid z-index-1 w-100" src="{{ asset('landing/images/banner/pilih-program.webp') }}" alt="">
                </div>
                <div class="col-lg-6 col-md-12 mt-5 mt-lg-0 order-lg-1">
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                    <a href="/program-tajwid-quran" class="text-secondary">
                        <div class="featured-item style-3">
                            <div class="featured-icon">
                            <i class="la la-book"></i>
                            </div>
                            <div class="featured-title">
                            <h5>Tajwid Al-Qur'an</h5>
                            </div>
                            <div class="featured-desc">
                            <p>Untuk anda yang ingin belajar membaca dan menulis Al Qur'an dengan baik dan benar</p>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-lg-6 col-md-6 mt-4">
                    <a href="/program-bahasa-arab" class="text-secondary">
                        <div class="featured-item style-3">
                            <div class="featured-icon">
                            <i class="la la-book-open"></i>
                            </div>
                            <div class="featured-title">
                            <h5>Bahasa Arab</h5>
                            </div>
                            <div class="featured-desc">
                            <p>Belajar bahasa arab dengan fokus pada kemampuan membaca dan mendengar</p>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-lg-6 col-md-6 mt-3 mt-md-0">
                    <a href="/program-takmili" class="text-secondary">
                        <div class="featured-item style-3">
                            <div class="featured-icon">
                            <i class="la la-pen-nib"></i>
                            </div>
                            <div class="featured-title">
                            <h5>Takmili</h5>
                            </div>
                            <div class="featured-desc">
                            <p>Program lanjutan untuk penyempurnaan kemampuan bahasa arab</p>
                            </div>
                        </div>
                    </a>
                    </div>
                    <div class="col-lg-6 col-md-6 mt-4">
                    <a href="/program-ulum-syariah" class="text-secondary">
                        <div class="featured-item style-3">
                            <div class="featured-icon">
                            <i class="la la-school"></i>
                            </div>
                            <div class="featured-title">
                            <h5>Ulum Asy-Syariah</h5>
                            </div>
                            <div class="featured-desc">
                            <p>Belajar berbagai disiplin ilmu syar'i dengan membaca kitab berbahasa arab</p>
                            </div>
                        </div>
                    </a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <!--#Program-->

    <!--Pengajar-->
    <section id="pengajar" class="position-relative overflow-hidden pb-2 wow fadeInUp" data-wow-duration="2s">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="section-title">
                    <h2 class="title">Asatidzah pengajar <span class="text-theme">berkompeten dan berkualitas</span> sesuai bidangnya</h2>
                    </div>
                </div>
            </div>
            <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="owl-carousel no-pb" data-dots="false" data-items="3" data-md-items="2" data-sm-items="1" data-autoplay="true">
                @foreach ($pengajar as $item)
                    <div class="item">
                        <div class="team-member style-3">
                        <div class="team-images">
                            <img class="img-fluid rounded box-shadow" src="{{ asset('landing/images/banner/avatar.webp') }}" alt="">
                            <a class="team-link" href="/pengajar"><i class="la la-external-link"></i></a>
                        </div>
                        <div class="team-description"> <span>{{ $item->posisi }}</span>
                            <h5>{{ $item->nama }}</h5>
                            <div class="social-icons social-colored circle team-social-icon">
                            </div>
                        </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
            </div>
        </div>
    </section>
    <!--#Pengajar-->

    <!--Fasilitas-->
    <section id="fasilitas" class="position-relative pt-0 wow fadeInUp" data-wow-duration="2s">
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
    <section id="biaya" class="position-relative grey-bg bg-effect-2 wow fadeInUp" data-wow-duration="2s">
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
                    <h2>{{ number_format($psb->biaya_pendaftaran,0,',','.') }}</h2>
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
                    <h2>{{ number_format($psb->biaya_spp,0,',','.') }}</h2>
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
                    <h2>{{ number_format($psb->biaya_transkrip,0,',','.') }}</h2>
                    <span>Sekali Bayar</span>
                  </div>
                  <h3 class="price-title">Kelulusan</h3>
                </div>
                <div class="price-list">
                  <ul class="list-unstyled">
                    <li><i class="la la-check"></i> Biaya Cetak Ijazah dan Transkrip</li>
                    <li><i class="la la-check"></i> Biaya Mutasi Program : {{ number_format($psb->biaya_mutasi,0,',','.') }}</li>
                    <li><i class="la la-check"></i> Dibayarkan Apabila Santri Dinyatakan Lulus</li>
                    <li><i class="la la-check"></i> Santri Harus Melunasi Seluruh Biaya SPP Terlebih Dahulu</li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
    </section>
    <!--#Biaya Pendidikan-->

    <!--Mengapa LPTA-->
    <section class="p-0 text-center wow fadeInUp mt-5" data-wow-duration="2s">
        <div class="container">
            <div class="row text-center">
                <div class="col-lg-8 col-md-10 mx-auto">
                    <div class="section-title">
                    <h2 class="title">Mengapa Harus Belajar Di <span class="text-theme">Takhassus Al Barkah?</span></h2>
                    </div>
                </div>
            </div>
            <div class="row md-mt-0">
                <div class="col-md-12">
                <div class="owl-carousel" data-dots="true" data-items="3" data-lg-items="3" data-md-items="2" data-sm-items="1" data-autoplay="true">
                    <div class="item">
                        <div class="featured-item style-2">
                            <div class="featured-icon">
                            <i class="flaticon-data"></i>
                                <span class="rotateme"></span>
                            </div>
                            <div class="featured-title">
                            <h5>Kurikulum Unik</h5>
                            </div>
                            <div class="featured-desc">
                            <p>Fokus pada potensi, perkembangan dan kepentingan para santri dan lingkungan nya</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="featured-item style-2">
                            <div class="featured-icon">
                            <i class="flaticon-collaboration"></i>
                            <span class="rotateme"></span>
                            </div>
                            <div class="featured-title">
                            <h5>Untuk Siapa Saja</h5>
                            </div>
                            <div class="featured-desc">
                            <p>Kami menerima semua santri mulai dari usia SMP sampai usia lanjut</p>
                            </div>
                        </div>
                    </div>
                    <div class="item">
                        <div class="featured-item style-2">
                            <div class="featured-icon">
                            <i class="flaticon-objective"></i>
                            <span class="rotateme"></span>
                            </div>
                            <div class="featured-title">
                            <h5>Lingkungan Sunnah</h5>
                            </div>
                            <div class="featured-desc">
                            <p>Pendidikan yang bersifat tashfiyah dan tarbiyah, suasana yang saling menerima dan akrab sesuai sunnah</p>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </section>
    <!--#Mengapa LPTA-->

    <!--Daftar Sekarang-->
    <div class="subscribe-box mt-3 mb-5 wow fadeInUp" data-wow-duration="2s">
        <div class="container">
            <div class="row subscribe-inner align-items-center">
            <div class="col-md-6 col-sm-12">
                <h4>Daftar Sekarang!</h4>
                <p class="lead mb-0">Tunggu apa lagi? ayo segera bergabung bersama kami</p>
            </div>
            <div class="col-md-6 col-sm-12 mt-3 mt-md-0">
                <a class="btn btn-theme wow fadeInUp" data-wow-duration="3s" data-wow-delay="0.5s" href="/psb" data-text="Daftar">
                    <span>S</span><span>a</span><span>n</span><span>t</span><span>r</span><span>i</span>
                    <span>B</span><span>a</span><span>r</span><span>u</span>
                </a>
                <a class="btn btn-dark wow fadeInUp" data-wow-duration="3s" data-wow-delay="0.5s" href="/profil-takhassus-al-barkah" data-text="Baca Profil">
                    <span>S</span><span>e</span><span>l</span><span>e</span><span>n</span><span>g</span><span>k</span><span>a</span><span>p</span><span>n</span><span>y</span><span>a</span>
                </a>
            </div>
            </div>
        </div>
    </div>
    <!--#Daftar Sekarang-->

    <section id="kontak" class="contact-info p-0 z-index-1">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-4 col-md-12">
              <a href="https://takhassusalbarkah.id" target="_blank">
              <div class="contact-media"> <i class="flaticon-paper-plane"></i><span>Website</span>
                <p>https://takhassusalbarkah.id</p>
              </div>
              </a>
            </div>
            <div class="col-lg-4 col-md-6 mt-5 mt-lg-0">
              <div class="contact-media"> <i class="flaticon-email"></i><span>Email</span>takhassusalbarkah@gmail.com
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mt-5 mt-lg-0">
              <a href="https://api.whatsapp.com/send?phone=628111516756">
              <div class="contact-media"> <i class="flaticon-social-media"></i><span>Whatsapp</span>0811-1516-756
              </div>
              </a>
            </div>
          </div>
        </div>
      </section>

      <section class="overflow-hidden p-0 custom-mt-5 z-index-0">
        <div class="container-fluid p-0">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="map iframe-h-2">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.9897975071876!2d106.95983527416803!3d-6.395315662549102!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69948a9e3056b3%3A0x88fed5dbb38dd881!2sLembaga%20Pendidikan%20Takhassus%20Al-Barkah!5e0!3m2!1sen!2sid!4v1682567922105!5m2!1sen!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
              </div>
            </div>
          </div>
        </div>
    </section>
</div>
<!--body content end-->
@endsection
