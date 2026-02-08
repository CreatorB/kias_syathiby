<!DOCTYPE html>
<html lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description" content="Sistem Informasi Pendaftaran Santri Baru">
    <meta name="author" content="Takhassus Al Barkah">
    <title>{{ $title ?? 'Home' }} - Takhassus Al Barkah | Sistem Informasi Penerimaan Santri Baru</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('landing/images/takhassus-icon.ico') }}">
    <link href="https://fonts.googleapis.com/css?family=Poppins:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/vendors/css/vendors.main.css') }}">
    @stack('vendorCss')
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('style/app-assets/css/themes/semi-dark-layout.css') }}">
    <!-- BEGIN: Page CSS-->

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('style/app-assets/css/core/menu/menu-types/vertical-menu.css') }}">
    @stack('pageCss')
    <!-- END: Page CSS-->

    <link rel="stylesheet" type="text/css" href="{{ asset('style/assets/css/style.css') }}">
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern navbar-floating footer-static" data-open="click"
    data-menu="vertical-menu-modern" data-col="">
    @php
        $user = DB::table('users')
            ->join('roles', 'users.role_id', 'roles.id')
            ->where('users.email', Auth::user()->email)
            ->first();
        $fullname = $user->nama;
        $nama = explode(' ', $fullname);
        $nama_depan = $nama[0];
        if (isset($nama[1])) {
            $nama_belakang = $nama[1];
        } else {
            $nama_belakang = "";
        }

        $level = $user->nama_role;
    @endphp

    {{-- Begin: Header --}}
    @include('layouts.navbars.admin_navbar')
    {{-- END: Sidebar --}}

    {{-- Begin: Sidebar --}}
    @include('layouts.sidebars.admin_sidebar')
    {{-- END: Sidebar --}}

    <!-- BEGIN: Bottom Navbar -->
    @include('layouts.navbars.admin_bottomnavbar')
    <!-- END: Bottom Navbar -->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @isset($breadcrumb)
                {{ $breadcrumb }}
            @endisset

            {{ $slot ?? '' }}
            @yield('content')
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @include('layouts.footer')

    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('style/app-assets/vendors/js/vendors.min.js') }}" data-navigate-once></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    @stack('vendorJS')
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('style/app-assets/js/core/app-menu.js') }}" data-navigate-once></script>
    <script src="{{ asset('style/app-assets/js/core/app.js') }}" data-navigate-once></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    @stack('pageJS')
    <!-- END: Page JS-->

    <script>
        document.addEventListener('livewire:navigated', () => {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>

</body>
<!-- END: Body-->

</html>