<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    @include('layouts.sidebars.brand')
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" style="font-family: Poppins, serif">
            <li class="nav-item {{ Route::is('admin::dashboard') ? 'active' : '' }}">
                <a class="d-flex align-items-center" href="{{ route('admin::dashboard') }}"><i data-feather="home"></i>
                    <span class="menu-title text-truncate">Dashboard</span>
                </a>
            </li>
            <!--MANAJEMEN JURNAL PEMBELAJARAN-->
            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">PENERIMAAN SANTRI</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item">
                <a class="d-flex align-items-center" href="#"><i data-feather="edit"></i>
                    <span class="menu-title text-truncate">Pendaftaran</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Route::is('admin::verifikasi_transfer') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" wire:navigate href="{{ route('admin::verifikasi_transfer') }}"><i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Verifikasi Transfer</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('admin::data_santri') || Route::is('admin::detail_pendaftar') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" wire:navigate href="{{ route('admin::data_santri') }}"><i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Data Santri</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!--MANAJEMEN EVENTS-->
            <li class="navigation-header"><span data-i18n="Events">MANAJEMEN EVENTS</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item {{ Route::is('admin::events.*') ? 'open' : '' }}">
                <a class="d-flex align-items-center" href="#"><i data-feather="calendar"></i>
                    <span class="menu-title text-truncate">Events</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Route::is('admin::events.index') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" wire:navigate href="{{ route('admin::events.index') }}"><i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Daftar Event</span>
                        </a>
                    </li>
                    <li class="{{ Route::is('admin::events.create') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" wire:navigate href="{{ route('admin::events.create') }}"><i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Tambah Event</span>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Superadmin Only Settings --}}
            @if(auth()->user()->isSuperadmin())
            <li class="navigation-header"><span data-i18n="Settings">PENGATURAN</span><i data-feather="more-horizontal"></i>
            </li>
            <li class="nav-item {{ Route::is('admin::settings.*') ? 'open' : '' }}">
                <a class="d-flex align-items-center" href="#"><i data-feather="settings"></i>
                    <span class="menu-title text-truncate">Settings</span>
                </a>
                <ul class="menu-content">
                    <li class="{{ Route::is('admin::settings.permissions') ? 'active' : '' }}">
                        <a class="d-flex align-items-center" wire:navigate href="{{ route('admin::settings.permissions') }}"><i data-feather="circle"></i>
                            <span class="menu-item text-truncate">Hak Akses</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </div>
</div>
<!-- END: Main Menu-->
