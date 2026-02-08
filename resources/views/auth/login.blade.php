
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
  <!-- BEGIN: Head-->
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Takhassus Al Barkah - Sistem Informasi Pendaftaran Santri Baru">
    <meta name="author" content="Takhassus Al Barkah">
    <meta name="theme-color" content="#ffffff"/>
    <title>Halaman Login | Lembaga Pendidikan Takhassus Al Barkah</title>
    <link rel="apple-touch-icon" href="{{ asset('landing/images/takhassus-icon.ico') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('landing/images/takhassus-icon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('template/app-assets/vendors/css/vendors.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/bootstrap-extended.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/colors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/components.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/themes/dark-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/themes/bordered-layout.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/themes/semi-dark-layout.min.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/core/menu/menu-types/vertical-menu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/pages/authentication.css') }}">
    <!-- END: Page CSS-->

  </head>
  <!-- END: Head-->

  <!-- BEGIN: Body-->
  <body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page" style="font-family: Poppins,serif">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
      <div class="content-overlay"></div>
      <div class="header-navbar-shadow"></div>
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
          <div class="auth-wrapper auth-cover">
            <div class="auth-inner row m-0">
              <!-- Brand logo--><a class="brand-logo" href="/">
                <img src="{{ asset('landing/images/logo/takhassus-logo.webp') }}" width="45" height="25">
                <h2 class="brand-text ms-1" style="color:#1277BF">Takhassus Al Barkah</h2></a>
              <!-- /Brand logo-->
              <!-- Left Text-->
              <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                <div class="w-100 d-lg-flex align-items-center justify-content-center px-5">
                    <img class="img-fluid" src="{{ asset('landing/images/banner/quran-banner.webp') }}" alt="Login V2"/></div>
              </div>
              <!-- /Left Text-->
              <!-- Login-->
              <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                  <h2 class="card-title fw-bold mb-1">Takhassus Al Barkah</h2>
                  <p class="card-text mb-2">Sistem Informasi Pendaftaran Santri Baru</p>
                  <!--PESAN GAGAL LOGIN-->
                  @if (\Session::has('flash_message_error'))
                  <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <div class="alert-body">
                        <strong>{!! session('flash_message_error') !!}</strong>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  @endif

                  <form class="auth-login-form mt-2" action="{{ route('login') }}" method="POST">
                    @csrf
                    <div class="mb-1">
                      <label class="form-label" for="username">Username</label>
                      <input class="form-control @error('email') is-invalid @enderror" @if(\Cookie::has('saveuser')) value="{{ \Cookie::get('saveuser') }}" @endif type="text" name="email" tabindex="1"/>
                    </div>

                    <div class="mb-1">
                      <div class="d-flex justify-content-between">
                        <label class="form-label" for="password">Password</label>
                      </div>
                      <div class="input-group input-group-merge form-password-toggle">
                        <input class="form-control form-control-merge @error('password') is-invalid @enderror" @if(\Cookie::has('savepwd')) value="{{ \Cookie::get('savepwd') }}" @endif id="password" type="password" name="password" aria-describedby="login-password" tabindex="2"/>
                        <span class="input-group-text cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-eye"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                        </span>
                      </div>
                    </div>
                    <div class="mb-1">
                      <label><em>Checklist <b>"Simpan Password"</b> untuk masuk kembali tanpa menuliskan Username dan Password   </em></label>
                    </div>
                    <div class="mb-1">
                      <div class="form-check">
                          <input class="form-check-input" id="remember-me" name="simpanpwd" type="checkbox" tabindex="3" @if(\Cookie::has('saveuser')) checked @endif/>
                          <label class="form-check-label" for="remember-me"> Simpan Password</label>
                      </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100" tabindex="4" id="submit">Masuk</button>
                  </form>
                </div>
              </div>
              <!-- /Login-->
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('style/app-assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('style/app-assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('style/app-assets/js/core/app-menu.min.js') }}"></script>
    <script src="{{ asset('style/app-assets/js/core/app.min.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    <script src="{{ asset('style/app-assets/js/scripts/pages/auth-login.js') }}"></script>
    <script src="{{ asset('style/app-assets/js/scripts/forms/form-validation.js') }}"></script>
    <script src="{{ asset('style/app-assets/js/scripts/components/components-alerts.min.js') }}"></script>
    <!-- END: Page JS-->

    <script>
      $('form').submit(function (event) {
          if ($(this).hasClass('submitted')) {
              event.preventDefault();
          }
          else {
              $(this).find(':submit').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> <span class="ms-25 align-middle">Bersiap Masuk...</span>');
              $(this).addClass('submitted');
              document.getElementById("submit").disabled = true;
          }
      });
    </script>

<script type="text/javascript">
    function preventBack() {
       window.history.forward();
    }

    setTimeout("preventBack()", 0);

    window.onunload = function () { null };
 </script>

    <script>
      $(window).on('load',  function(){
        if (feather) {
          feather.replace({ width: 14, height: 14 });
        }
      })
    </script>
  </body>
  <!-- END: Body-->
</html>
