<div class="container-xl">
  <ul class="navbar-nav">
    @php
      $role = Auth::user()->role;
      $dashboardRoute = '';
      
      switch ($role) {
          case 0:
              $dashboardRoute = 'hc.dashboard';
              break;
          case 1:
              $dashboardRoute = 'pegawai.dashboard';
              break;
          case 2:
              $dashboardRoute = 'kapro.dashboard';
              break;
          case 3:
              $dashboardRoute = 'manajerhc.dashboard';
              break;
          case 4:
              $dashboardRoute = 'pusat.dashboard';
              break;
      }
    @endphp
    
    <!-- Menu Dashboard -->
    <li class="nav-item {{ Route::currentRouteName() == $dashboardRoute ? 'active' : '' }}">
      <a class="nav-link" href="{{ route($dashboardRoute) }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-home"></i>
        </span>
        <span class="nav-link-title">
          Home
        </span>
      </a>
    </li>
    
    <!-- Menu Kelola User -->
    <li class="nav-item {{ Route::currentRouteName() == 'hc.kelola-user' ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('hc.kelola-user') }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-user"></i>
        </span>
        <span class="nav-link-title">
         Kelola User
        </span>
      </a>
    </li>
    
    <!-- Menu Kelola Kontrak -->
    <li class="nav-item {{ Route::currentRouteName() == 'pusat.kelola-kontrak' ? 'active' : '' }}">
      <a class="nav-link" href="">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-book"></i>
        </span>
        <span class="nav-link-title">
         Kelola Kontrak
        </span>
      </a>
    </li>

    <!-- Menu Kelola Project -->
    <li class="nav-item {{ Route::currentRouteName() == 'pusat.kelola-project' ? 'active' : '' }}">
      <a class="nav-link" href="">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-current-location"></i>
        </span>
        <span class="nav-link-title">
         Kelola Project
        </span>
      </a>
    </li>

    <!-- Menu Kelola Gaji -->
    <li class="nav-item {{ Route::currentRouteName() == 'pusat.kelola-gaji' ? 'active' : '' }}">
      <a class="nav-link" href="">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-cash"></i>
        </span>
        <span class="nav-link-title">
         Kelola Gaji
        </span>
      </a>
    </li>
    
  </ul>
  <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
  </div>
</div>
