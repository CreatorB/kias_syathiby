<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
<div class="container-xxl d-flex h-100">
    <ul class="menu-inner">
    @auth
        @if(auth()->user()->isAdmin() || auth()->user()->isSuperadmin())
        <!-- Admin Menu -->
        <li class="menu-item {{ Route::is('admin::dashboard') ? 'active' : '' }}">
            <a class="menu-link" wire:navigate href="{{ route('admin::dashboard') }}">
            <i class="menu-icon tf-icons ti ti-home"></i>
            <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('admin::verifikasi_transfer') || Route::is('admin::data_santri') || Route::is('admin::pengaturan_psb') || Route::is('admin::users.index') ? 'active' : '' }}">
            <a class="menu-link" wire:navigate href="{{ route('admin::verifikasi_transfer') }}">
            <i class="menu-icon tf-icons ti ti-user-check"></i>
            <div data-i18n="Pendaftaran">Pendaftaran</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ Route::is('admin::verifikasi_transfer') ? 'active' : '' }}">
                    <a class="menu-link" wire:navigate href="{{ route('admin::verifikasi_transfer') }}">
                    <i class="menu-icon tf-icons ti ti-credit-card"></i>
                    <div data-i18n="Verifikasi Transfer">Verifikasi Transfer</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('admin::data_santri') ? 'active' : '' }}">
                    <a class="menu-link" wire:navigate href="{{ route('admin::data_santri') }}">
                    <i class="menu-icon tf-icons ti ti-users"></i>
                    <div data-i18n="Data Santri">Data Santri</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('admin::users.index') ? 'active' : '' }}">
                    <a class="menu-link" wire:navigate href="{{ route('admin::users.index') }}">
                    <i class="menu-icon tf-icons ti ti-user"></i>
                    <div data-i18n="Data Akun">Data Akun</div>
                    </a>
                </li>
                <li class="menu-item {{ Route::is('admin::pengaturan_psb') ? 'active' : '' }}">
                    <a class="menu-link" wire:navigate href="{{ route('admin::pengaturan_psb') }}">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="Pengaturan PSB">Pengaturan PSB</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ Route::is('admin::events.*') ? 'active' : '' }}">
            <a class="menu-link" wire:navigate href="{{ route('admin::events.index') }}">
            <i class="menu-icon tf-icons ti ti-calendar-event"></i>
            <div data-i18n="Events">Events</div>
            </a>
        </li>
        @if(auth()->user()->isSuperadmin())
        <li class="menu-item {{ Route::is('admin::settings.*') ? 'active' : '' }}">
            <a class="menu-link" wire:navigate href="{{ route('admin::settings.permissions') }}">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div data-i18n="Settings">Settings</div>
            </a>
        </li>
        @endif

        @elseif(auth()->user()->canAccessPesertaMenu())
        <!-- Peserta/Santri Menu -->
        <li class="menu-item {{ Route::is('peserta::index') ? 'active' : '' }}">
            <a class="menu-link" wire:navigate href="{{ route('peserta::index') }}">
            <i class="menu-icon tf-icons ti ti-home"></i>
            <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('peserta::events') ? 'active' : '' }}">
            <a class="menu-link" wire:navigate href="{{ route('peserta::events') }}">
            <i class="menu-icon tf-icons ti ti-calendar-event"></i>
            <div data-i18n="Riwayat Event">Riwayat Event</div>
            </a>
        </li>
        @else
        <!-- Regular User Menu -->
        <li class="menu-item {{ Route::is('home') ? 'active' : '' }}">
            <a class="menu-link" wire:navigate href="{{ route('home') }}">
            <i class="menu-icon tf-icons ti ti-home"></i>
            <div data-i18n="Home">Home</div>
            </a>
        </li>
        @endif

        <li class="menu-item {{ Route::is('pengaturan') ? 'active' : '' }}">
            <a class="menu-link" wire:navigate href="{{ route('pengaturan') }}">
            <i class="menu-icon tf-icons ti ti-settings"></i>
            <div data-i18n="Pengaturan">Pengaturan</div>
            </a>
        </li>

        <li class="menu-item">
            <a class="menu-link" href="{{ route('custom.logout') }}">
            <i class="menu-icon tf-icons ti ti-logout"></i>
            <div data-i18n="Logout">Logout</div>
            </a>
        </li>
    @else
        <!-- Guest Menu -->
        <li class="menu-item {{ Route::is('/') ? 'active' : '' }}">
            <a class="menu-link" href="/">
            <i class="menu-icon tf-icons ti ti-home"></i>
            <div data-i18n="Beranda">Beranda</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('psb') ? 'active' : '' }}">
            <a class="menu-link" href="{{ route('psb') }}">
            <i class="menu-icon tf-icons ti ti-info-circle"></i>
            <div data-i18n="Info PSB">Info PSB</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('pilih-program') ? 'active' : '' }}">
            <a class="menu-link" href="/pilih-program">
            <i class="menu-icon tf-icons ti ti-user-plus"></i>
            <div data-i18n="Daftar">Daftar</div>
            </a>
        </li>
        <li class="menu-item {{ Route::is('events.index') ? 'active' : '' }}">
            <a class="menu-link" href="{{ route('events.index') }}">
            <i class="menu-icon tf-icons ti ti-calendar-event"></i>
            <div data-i18n="Events">Events</div>
            </a>
        </li>
    @endauth
    </ul>
</div>
</aside>