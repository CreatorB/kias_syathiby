<!DOCTYPE html>
<html lang="en">

<head>

  <!-- meta tags -->
  <meta charset="utf-8">
  <meta name="keywords" content="kias, kursus bahasa arab, belajar ilmu syar'i, manhaj salaf, ma'had syathiby, tahsin, tajwid" />
  <meta name="description" content="Belajar ilmu bahasa arab & syar'i sesuai manhaj salafusholih, bersama asatidzah kompeten dengan mudir 'Aam : Ust. Badru Salam, Lc." />
  <meta name="author" content="IT Syathiby" />

  <!-- Open Graph / Social Media -->
  <meta property="og:type" content="website" />
  <meta property="og:url" content="https://kias.syathiby.id/" />
  <meta property="og:title" content="KIAS - Kursus Ilmu bahasa Arab & Syar'i" />
  <meta property="og:description" content="Belajar ilmu bahasa arab & syar'i sesuai manhaj salafusholih, bersama asatidzah kompeten dengan mudir 'Aam : Ust. Badru Salam, Lc." />
  <meta property="og:image" content="{{ asset('landing/images/logo/takhassus-logo.webp') }}" />

  <!-- Twitter -->
  <meta name="twitter:card" content="summary_large_image" />
  <meta name="twitter:title" content="KIAS - Kursus Ilmu bahasa Arab & Syar'i" />
  <meta name="twitter:description" content="Belajar ilmu bahasa arab & syar'i sesuai manhaj salafusholih, bersama asatidzah kompeten dengan mudir 'Aam : Ust. Badru Salam, Lc." />
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Title -->
  <title>{{ $title }} - KIAS (Kursus Ilmu bahasa Arab & Syar'i)</title>

  <!-- favicon icon -->
  <link rel="shortcut icon" href="{{ asset('landing/images/takhassus-icon.ico') }}" />

  <!-- inject css start -->

  <!--== bootstrap -->
  <link href="{{ asset('landing/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

  <link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@1,400;1,500&display=swap" rel="stylesheet">

  <!--== animate -->
  <link href="{{ asset('landing/css/animate.css') }}" rel="stylesheet" type="text/css" />

  <!--== fontawesome -->
  <link href="{{ asset('landing/css/fontawesome-all.css') }}" rel="stylesheet" type="text/css" />

  <!--== line-awesome -->
  <link href="{{ asset('landing/css/line-awesome.min.css') }}" rel="stylesheet" type="text/css" />

  <!--== magnific-popup -->
  <link href="{{ asset('landing/css/magnific-popup/magnific-popup.css') }}" rel="stylesheet" type="text/css" />

  <!--== owl-carousel -->
  <link href="{{ asset('landing/css/owl-carousel/owl.carousel.css') }}" rel="stylesheet" type="text/css" />

  <!--== base -->
  <link href="{{ asset('landing/css/base.css') }}" rel="stylesheet" type="text/css" />

  <!--== shortcodes -->
  <link href="{{ asset('landing/css/shortcodes.css') }}" rel="stylesheet" type="text/css" />

  <!--== default-theme -->
  <link href="{{ asset('landing/css/style.css') }}" rel="stylesheet" type="text/css" />

  <!--== responsive -->
  <link href="{{ asset('landing/css/responsive.css') }}" rel="stylesheet" type="text/css" />

  <!-- inject css end -->

</head>

<body data-bs-spy="scroll" data-bs-target="#navbarNav">

  <!-- page wrapper start -->

  <div class="page-wrapper">

    <!-- preloader start -->
    <div id="ht-preloader">
      <div class="loader clear-loader">
        <div class="loader-box"></div>
        <div class="loader-box"></div>
        <div class="loader-box"></div>
        <div class="loader-box"></div>
        <div class="loader-wrap-text">
          <div class="text"><span>K</span><span>I</span><span>A</span><span>S</span>
          </div>
        </div>
      </div>
    </div>
    <!-- preloader end -->


    <!--header start-->
    <header id="site-header" class="header header-2">
      <div class="container">
        <div id="header-wrap">
          <div class="row">
            <div class="col-lg-12">
              <!-- Navbar -->
              <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand logo" href="/">
                  <img id="logo-white-img" class="img-fluid" src="{{ asset('landing/images/logo/' . $lembaga->logo) }}"
                    alt="">
                  <img id="logo-img" class="img-fluid sticky-logo"
                    src="{{ asset('landing/images/logo/' . $lembaga->logo) }}" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                  aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span></span>
                  <span></span>
                  <span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                  <!-- Left nav -->
                  <ul class="nav navbar-nav ms-auto">
                    <!-- Home -->
                    <li class="nav-item"> <a class="nav-link" href="#home">Home</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/profil-kias">Profil</a>
                    </li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#"
                        data-bs-toggle="dropdown">Program</a>
                      <ul class="dropdown-menu">
                        <li><a href="/program-tajwid-quran">Tajwid Al-Qur'an</a>
                        </li>
                        <li><a href="/program-bahasa-arab">Bahasa Arab</a>
                        </li>
                        <li><a href="/program-takmili">Takmili</a>
                        </li>
                        <li><a href="/program-ulum-syariah">Ulum Asy-Syariah</a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li><a href="/events"><i class="fas fa-calendar-alt me-1"></i> Events / Daurah</a>
                        </li>
                      </ul>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="#pengajar">Pengajar</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="#fasilitas">Fasilitas</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="#biaya">Biaya</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/panduan-santri">Panduan Santri</a>
                    </li>
                  </ul>
                </div>
                <a class="btn btn-theme btn-sm" href="/psb" data-text="Daftar">
                  <span>S</span><span>a</span><span>n</span><span>t</span><span>r</span><span>i</span>
                </a>
              </nav>
            </div>
          </div>
        </div>
      </div>
    </header>
    <!--header end-->

    @yield('content')

    @include('layouts.landing.partials.footer')

  </div>
  <!-- page wrapper end -->

  <!--== jquery -->
  <script src="{{ asset('landing/js/theme.js') }}"></script>

  <!--== owl-carousel -->
  <script src="{{ asset('landing/js/owl-carousel/owl.carousel.min.js') }}"></script>

  <!--== magnific-popup -->
  <script src="{{ asset('landing/js/magnific-popup/jquery.magnific-popup.min.js') }}"></script>

  <!--== counter -->
  <script src="{{ asset('landing/js/counter/counter.js') }}"></script>

  <!--== countdown -->
  <script src="{{ asset('landing/js/countdown/jquery.countdown.min.js') }}"></script>

  <!--== canvas -->
  <script src="{{ asset('landing/js/canvas.js') }}"></script>

  <!--== confetti -->
  <script src="{{ asset('landing/js/confetti.js') }}"></script>

  <!--== step animation -->
  <script src="{{ asset('landing/js/snap.svg.js') }}"></script>
  <script src="{{ asset('landing/js/step.js') }}"></script>

  <!--== contact-form -->
  <script src="{{ asset('landing/js/contact-form/contact-form.js') }}"></script>

  <!--== wow -->
  <script src="{{ asset('landing/js/wow.min.js') }}"></script>

  <!--== theme-script -->
  <script src="{{ asset('landing/js/theme-script.js') }}"></script>

  <!-- inject js end -->

</body>

</html>