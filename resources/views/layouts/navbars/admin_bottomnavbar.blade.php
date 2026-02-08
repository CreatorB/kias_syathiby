<nav class="p-0 navbar navbar-light bg-light navbar-expand d-lg-none d-xl-none fixed-bottom">
    <ul class="navbar-nav nav-justified w-100">
        <li class="nav-item active">
            <a href="{{ route('admin::dashboard') }}" class="nav-link text-center">
                <i data-feather='home' class="{{ Route::is('admin::dashboard') ? 'text-primary' : '' }}"></i>
                <span class="small d-block {{ Route::is('admin::dashboard') ? 'text-primary' : ''
                    }}"><b>Home</b></span>
            </a>
        </li>
        <li class="nav-item">
            <a wire:navigate href="{{ route('admin::verifikasi_transfer') }}" class="nav-link text-center">
                <i data-feather='edit' class="{{ Route::is('admin::verifikasi_transfer') ? 'text-primary' : ''
                    }}"></i>
                <span class="small d-block {{ Route::is('admin::verifikasi_transfer') ? 'text-primary' : ''
                    }}"><b>Verifikasi</b></span>
            </a>
        </li>
        <li class="nav-item">
            <a wire:navigate href="{{ route('admin::data_santri') }}" class="nav-link text-center">
                <i data-feather='users' class="{{ Route::is('admin::data_santri') ? 'text-primary' : ''
                    }}"></i>
                <span class="small d-block {{ Route::is('admin::data_santri') ? 'text-primary' : ''
                    }}"><b>Santri</b></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link menu-toggle" href="#">
                <i class="ficon" data-feather="menu"></i>
                <span class="small d-block"><b>Menu</b></span>
            </a>
        </li>
    </ul>
</nav>
