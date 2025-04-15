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
    <li class="nav-item {{ Route::currentRouteName() == 'manajerhc.project' ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('manajerhc.project') }}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-file-description"></i>
        </span>
        <span class="nav-link-title">
         Laporan Project
        </span>
      </a>
    </li>
    
    <!-- Menu Kelola Kontrak -->
    <li class="nav-item {{ Route::currentRouteName() == 'manajerhc.kontrak' ? 'active' : '' }}">
      <a class="nav-link" href="{{route('manajerhc.kontrak')}}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-book"></i>
        </span>
        <span class="nav-link-title">
         Laporan Kontrak
        </span>
      </a>
    </li>

    <li class="nav-item {{ Route::currentRouteName() == 'manajerhc.history-kontrak' ? 'active' : '' }}">
      <a class="nav-link" href="{{route('manajerhc.history-kontrak')}}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-history"></i>
        </span>
        <span class="nav-link-title">
         Laporan Perpanjangan Kontrak
        </span>
      </a>
    </li>
    <li class="nav-item {{ Route::currentRouteName() == 'manajerhc.perpanjang' ? 'active' : '' }}">
      <a class="nav-link" href="{{route('manajerhc.perpanjang')}}">
        <span class="nav-link-icon d-md-none d-lg-inline-block">
          <i class="ti ti-file-signal"></i>
        </span>
        <span class="nav-link-title">
         Perpanjang Kontrak
        </span>
      </a>
    </li>
    
  </ul>
  <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
  </div>
</div>
