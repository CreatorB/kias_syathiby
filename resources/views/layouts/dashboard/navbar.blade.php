<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
  <div class="container-xxl">
    <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
      <a href="index.html" class="app-brand-link gap-2">
        <img src="{{ asset('landing/images/logo/takhassus-logo.webp') }}" width="60" height="30">
        <span class="app-brand-text demo menu-text fw-bold">KIAS</span>
      </a>

      <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-xl-none">
        <i class="ti ti-x ti-sm align-middle"></i>
      </a>
    </div>

    <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
      <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
        <i class="ti ti-menu-2 ti-sm"></i>
      </a>
    </div>

    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
      <ul class="navbar-nav flex-row align-items-center ms-auto">
        <!-- User -->
        <li class="nav-item navbar-dropdown dropdown-user dropdown">
          <div class="d-flex align-items-center gap-2">
            <!-- Name and Role (Always Visible) -->
            <div class="flex-grow-1 text-end me-2" style="display: block !important; color: #5d596c !important;">
              <span class="fw-semibold d-block"
                style="font-size: 0.875rem; line-height: 1.2;">{{ Auth::user()->nama_lengkap ?? Auth::user()->name ?? 'User' }}</span>
              @php
                $roleId = Auth::user()->role_id;
                $role = DB::table('roles')->where('id', $roleId)->first();
                $namaRole = $role->nama_role ?? 'User';
              @endphp
              <small class="text-muted d-block" style="font-size: 0.75rem; line-height: 1.2;">{{ $namaRole }}</small>
            </div>

            <!-- Avatar Dropdown -->
            <a class="nav-link dropdown-toggle hide-arrow p-0" href="javascript:void(0);" data-bs-toggle="dropdown">
              <div class="avatar avatar-online">
                <img src="{{ asset('dashboard-assets/assets/img/avatars/' . (Auth::user()->gender == 'Perempuan' ? 'user-akhwat.png' : 'user-ikhwan.png')) }}" alt
                  class="h-auto rounded-circle" />
              </div>
            </a>
          </div>
          <ul class="dropdown-menu dropdown-menu-end">
            <li>
              <a class="dropdown-item" href="{{ route('pengaturan') }}">
                <div class="d-flex">
                  <div class="flex-shrink-0 me-3">
                      <div class="avatar avatar-online">
                      <img src="{{ asset('dashboard-assets/assets/img/avatars/' . (Auth::user()->gender == 'Perempuan' ? 'user-akhwat.png' : 'user-ikhwan.png')) }}" alt
                        class="h-auto rounded-circle" />
                    </div>
                  </div>
                  <div class="flex-grow-1">
                    <span class="fw-semibold d-block">{{ Auth::user()->nama ?? Auth::user()->name }}</span>
                    @php
                      $roleId = Auth::user()->role_id;
                      $role = DB::table('roles')
                        ->where('id', $roleId)
                        ->first();
                $namaRole = $role->nama_role ?? 'Peserta';
                    @endphp
                    <small class="text-muted">{{ $namaRole }}</small>
                  </div>
                </div>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="{{ route('pengaturan') }}">
                <i class="ti ti-settings me-2 ti-sm"></i>
                <span class="align-middle">Pengaturan</span>
              </a>
            </li>
            <li>
              <div class="dropdown-divider"></div>
            </li>
            <li>
              <a class="dropdown-item" href="/logout">
                <i class="ti ti-logout me-2 ti-sm"></i>
                <span class="align-middle">Keluar</span>
              </a>
            </li>
          </ul>
        </li>
        <!--/ User -->
      </ul>
    </div>
  </div>
</nav>