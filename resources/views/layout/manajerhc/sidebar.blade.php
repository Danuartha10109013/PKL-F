<div class="container-xl">
    <ul class="navbar-nav">
      <li class="nav-item active">
        @php
          $role = Auth::user()->role
        @endphp
        @if ($role == 0)       
          <a class="nav-link" href="{{route('hc.dashboard')}}" >       
        @elseif($role == 1)       
          <a class="nav-link" href="{{route('pegawai.dashboard')}}" >      
        @elseif($role == 2)      
          <a class="nav-link" href="{{route('kapro.dashboard')}}" >        
        @elseif($role == 3)
          <a class="nav-link" href="{{route('manajerhc.dashboard')}}" >       
        @elseif($role == 4)
        <a class="nav-link" href="{{route('pusat.dashboard')}}" >
        @endif
          <span class="nav-link-icon d-md-none d-lg-inline-block">
            <i class="ti ti-home"></i>
          </span>
          <span class="nav-link-title">
            Home
          </span>
        </a>
      </li>
      {{-- <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
          <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/package -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" /><path d="M12 12l8 -4.5" /><path d="M12 12l0 9" /><path d="M12 12l-8 -4.5" /><path d="M16 5.25l-8 4.5" /></svg>
          </span>
          <span class="nav-link-title">
            Interface
          </span>
        </a>
        <div class="dropdown-menu">
          <div class="dropdown-menu-columns">
            <div class="dropdown-menu-column">
              <a class="dropdown-item" href="{{asset('vendor')}}/alerts.html">
                Alerts
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/accordion.html">
                Accordion
              </a>
              <div class="dropend">
                <a class="dropdown-item dropdown-toggle" href="#sidebar-authentication" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                  Authentication
                </a>
                <div class="dropdown-menu">
                  <a href="{{asset('vendor')}}/sign-in.html" class="dropdown-item">
                    Sign in
                  </a>
                  <a href="{{asset('vendor')}}/sign-in-link.html" class="dropdown-item">
                    Sign in link
                  </a>
                  <a href="{{asset('vendor')}}/sign-in-illustration.html" class="dropdown-item">
                    Sign in with illustration
                  </a>
                  <a href="{{asset('vendor')}}/sign-in-cover.html" class="dropdown-item">
                    Sign in with cover
                  </a>
                  <a href="{{asset('vendor')}}/sign-up.html" class="dropdown-item">
                    Sign up
                  </a>
                  <a href="{{asset('vendor')}}/forgot-password.html" class="dropdown-item">
                    Forgot password
                  </a>
                  <a href="{{asset('vendor')}}/terms-of-service.html" class="dropdown-item">
                    Terms of service
                  </a>
                  <a href="{{asset('vendor')}}/auth-lock.html" class="dropdown-item">
                    Lock screen
                  </a>
                  <a href="{{asset('vendor')}}/2-step-verification.html" class="dropdown-item">
                    2 step verification
                  </a>
                  <a href="{{asset('vendor')}}/2-step-verification-code.html" class="dropdown-item">
                    2 step verification code
                  </a>
                </div>
              </div>
              <a class="dropdown-item" href="{{asset('vendor')}}/blank.html">
                Blank page
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/badges.html">
                Badges
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/buttons.html">
                Buttons
              </a>
              <div class="dropend">
                <a class="dropdown-item dropdown-toggle" href="#sidebar-cards" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                  Cards
                  <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                </a>
                <div class="dropdown-menu">
                  <a href="{{asset('vendor')}}/cards.html" class="dropdown-item">
                    Sample cards
                  </a>
                  <a href="{{asset('vendor')}}/card-actions.html" class="dropdown-item">
                    Card actions
                    <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
                  </a>
                  <a href="{{asset('vendor')}}/cards-masonry.html" class="dropdown-item">
                    Cards Masonry
                  </a>
                </div>
              </div>
              <a class="dropdown-item" href="{{asset('vendor')}}/carousel.html">
                Carousel
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/charts.html">
                Charts
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/colors.html">
                Colors
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/colorpicker.html">
                Color picker
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/datagrid.html">
                Data grid
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/datatables.html">
                Datatables
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/dropdowns.html">
                Dropdowns
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/dropzone.html">
                Dropzone
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <div class="dropend">
                <a class="dropdown-item dropdown-toggle" href="#sidebar-error" data-bs-toggle="dropdown" data-bs-auto-close="outside" role="button" aria-expanded="false" >
                  Error pages
                </a>
                <div class="dropdown-menu">
                  <a href="{{asset('vendor')}}/error-404.html" class="dropdown-item">
                    404 page
                  </a>
                  <a href="{{asset('vendor')}}/error-500.html" class="dropdown-item">
                    500 page
                  </a>
                  <a href="{{asset('vendor')}}/error-maintenance.html" class="dropdown-item">
                    Maintenance page
                  </a>
                </div>
              </div>
              <a class="dropdown-item" href="{{asset('vendor')}}/flags.html">
                Flags
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/inline-player.html">
                Inline player
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
            </div>
            <div class="dropdown-menu-column">
              <a class="dropdown-item" href="{{asset('vendor')}}/lightbox.html">
                Lightbox
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/lists.html">
                Lists
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/modals.html">
                Modal
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/maps.html">
                Map
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/map-fullsize.html">
                Map fullsize
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/maps-vector.html">
                Map vector
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/markdown.html">
                Markdown
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/navigation.html">
                Navigation
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/offcanvas.html">
                Offcanvas
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/pagination.html">
                <!-- Download SVG icon from http://tabler-icons.io/i/pie-chart -->
                Pagination
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/placeholder.html">
                Placeholder
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/steps.html">
                Steps
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/stars-rating.html">
                Stars rating
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/tabs.html">
                Tabs
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/tags.html">
                Tags
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/tables.html">
                Tables
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/typography.html">
                Typography
              </a>
              <a class="dropdown-item" href="{{asset('vendor')}}/tinymce.html">
                TinyMCE
                <span class="badge badge-sm bg-green-lt text-uppercase ms-auto">New</span>
              </a>
            </div>
          </div>
        </div>
      </li> --}}

      {{-- <li class="nav-item">
        <a class="nav-link" href="{{asset('vendor')}}/form-elements.html" >
          <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 11l3 3l8 -8" /><path d="M20 12v6a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h9" /></svg>
          </span>
          <span class="nav-link-title">
            Absensi
          </span>
        </a>
      </li> --}}
      
      <li class="nav-item">
        <a class="nav-link" href="{{route('pusat.dashboard')}}" >
          <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 28 28"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-script"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M17 20h-11a3 3 0 0 1 0 -6h11a3 3 0 0 0 0 6h1a3 3 0 0 0 3 -3v-11a2 2 0 0 0 -2 -2h-10a2 2 0 0 0 -2 2v8" /></svg>  
          </span>
          <span class="nav-link-title">
           Laporan Project
          </span>
        </a>
      </li>
      
       <li class="nav-item">
        <a class="nav-link" href="{{route('pusat.dashboard')}}" >
          <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
            <i class="ti ti-book"></i>
          </span>
          <span class="nav-link-title">
           Laporan Kontrak Pegawai   
          </span>
        </a>
      </li>
      
      <li class="nav-item">
       <a class="nav-link" href="{{route('pusat.dashboard')}}" >
         <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
           <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 28 28"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-clipboard-data"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" /><path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" /><path d="M9 17v-4" /><path d="M12 17v-1" /><path d="M15 17v-2" /><path d="M12 17v-1" /></svg>
         </span>
         <span class="nav-link-title">
          Laporan gaji Pegawai   
         </span>
       </a>
     </li>
    </ul>
    <div class="my-2 my-md-0 flex-grow-1 flex-md-grow-0 order-first order-md-last">
      {{-- <form action="{{asset('vendor')}}/" method="get" autocomplete="off" novalidate>
        <div class="input-icon">
          <span class="input-icon-addon">
            <!-- Download SVG icon from http://tabler-icons.io/i/search -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
          </span>
          <input type="text" value="" class="form-control" placeholder="Search…" aria-label="Search in website">
        </div>
      </form> --}}
    </div>
  </div>