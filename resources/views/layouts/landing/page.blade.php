<!DOCTYPE html>
<html lang="en">
<head>

<!-- meta tags -->
<meta charset="utf-8">
<meta name="keywords" content="bootstrap 5, premium, multipurpose, sass, scss, saas, software" />
<meta name="description" content="HTML5 Template" />
<meta name="author" content="www.themeht.com" />
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Title -->
<title>{{ $title }} - Lembaga Pendidikan Takhassus Al Barkah</title>

<!-- favicon icon -->
<link rel="shortcut icon" href="{{ asset('landing/images/takhassus-icon.ico') }}" />

<!-- inject css start -->

<!--== bootstrap -->
<link href="{{ asset('landing/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />

<link href="https://fonts.googleapis.com/css?family=Ubuntu:300,300i,400,400i,500,500i,700,700i" rel="stylesheet">

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

<body class="home-2" data-bs-spy="scroll" data-bs-target="#navbarNav">

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
        <div class="text"><span>T</span><span>A</span><span>K</span><span>H</span><span>A</span><span>S</span><span>S</span><span>U</span><span>S</span>
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
                <img id="logo-white-img" class="img-fluid" src="{{ asset('landing/images/logo/'.$lembaga->logo) }}" alt="">
                <img id="logo-img" class="img-fluid sticky-logo" src="{{ asset('landing/images/logo/'.$lembaga->logo) }}" alt="">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation"> <span></span>
                <span></span>
                <span></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Left nav -->
                <ul class="nav navbar-nav ms-auto">
                    <!-- Home -->
                    <li class="nav-item"> <a class="nav-link" href="/">Home</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/profil-takhassus-al-barkah">Profil</a>
                    </li>
                    <li class="nav-item dropdown"> <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Program</a>
                        <ul class="dropdown-menu">
                            <li><a href="/program-tajwid-quran">Tajwid Al-Qur'an</a>
                            </li>
                            <li><a href="/program-bahasa-arab">Bahasa Arab</a>
                            </li>
                            <li><a href="/program-takmili">Takmili</a>
                            </li>
                            <li><a href="/program-ulum-syariah">Ulum Asy-Syariah</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/#pengajar">Pengajar</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/#fasilitas">Fasilitas</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/#biaya">Biaya</a>
                    </li>
                    <li class="nav-item"> <a class="nav-link" href="/panduan-santri">Panduan Santri</a>
                    </li>
                </ul>
                </div>
                @if ($title == 'Informasi Penerimaan Santri Baru')
                <a class="btn btn-theme btn-sm" href="/pilih-program" data-text="Daftar">
                    <span>S</span><span>a</span><span>n</span><span>t</span><span>r</span><span>i</span>
                </a>
                @else
                <a class="btn btn-theme btn-sm" href="/psb" data-text="Daftar">
                    <span>S</span><span>a</span><span>n</span><span>t</span><span>r</span><span>i</span>
                </a>
                @endif
            </nav>
            </div>
        </div>
        </div>
    </div>
    </header>
    <!--header end-->

    @yield('content')

    <!--footer start-->
    <footer class="footer position-relative" data-bg-img="{{ asset('landing/images/bg/05.png') }}">
        <div class="secondary-footer">
          <div class="container">
            <div class="copyright">
              <div class="row align-items-center">
                <div class="col-lg-6 col-md-12"> <span>© Copyright 2023 - <a href="https://takhassusalbarkah.id">Takhassus Al Barkah</a></span>
                </div>
                <div class="col-lg-6 col-md-12 text-lg-end mt-3 mt-lg-0">
                  <div class="footer-social">
                    <ul class="list-inline">
                      <li class="me-2"><a href="https://api.whatsapp.com/send?phone=628111516756" target="_blank"><i class="fab fa-whatsapp"></i> 0811-1516-756</a>
                      </li>
                      <li class="me-2"><a href="https://www.instagram.com/takhassus_albarkah/" target="_blank"><i class="fab fa-instagram"></i>takhassus_albarkah</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </footer>
    <!--footer end-->

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
