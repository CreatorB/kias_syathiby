<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    @include('layouts.sidebars.brand')
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" style="font-family: Poppins, serif">

            <!-- Dashboard -->
            <li class="nav-item {{ Route::is('peserta::index') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('peserta::index') }}">
                    <i data-feather="home"></i>
                    <span class="menu-title text-truncate">Dashboard</span>
                </a>
            </li>

            <!-- MANAJEMEN EVENT -->
            <li class="navigation-header">
                <span data-i18n="Events">MANAJEMEN EVENT</span>
                <i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item {{ Route::is('peserta::events') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('peserta::events') }}">
                    <i data-feather="calendar"></i>
                    <span class="menu-title text-truncate">Riwayat Event</span>
                </a>
            </li>

        </ul>
    </div>
</div>
<!-- END: Main Menu-->