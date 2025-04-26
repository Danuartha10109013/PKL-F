<div class="container-xl">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3">
      <a target="_blank" href="https://www.wika.co.id/">
        <img src="{{asset('tr_wika.png')}}" width="110" height="32" alt="Tabler" class="navbar-brand-image"> PT. Wijaya Karya
      </a>
    </h1>
    <div class="navbar-nav flex-row order-md-last">
      <div class="nav-item d-none d-md-flex me-3">
        <div class="btn-list">
          @if (Auth::user()->role == 1)
            
          <div class="dropdown">
            <button class="btn btn-clear position-relative" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                🔔 
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="notif-count">
                    {{ \App\Models\NotifM::where('user_id', Auth::id())->where('status', 0)->count() }}
                </span>
            </button>
        
            <div class="dropdown-menu dropdown-menu-end p-2" style="width: 320px;" id="notif-list">
                @php
                    $notifs = \App\Models\NotifM::where('user_id', Auth::id())
                                ->where('status', '!=', 2)
                                ->orderBy('created_at', 'desc')
                                ->get();
                @endphp
        
                @if($notifs->count() > 0)
                    <div class="d-flex align-items-center mb-2">
                        <input type="checkbox" id="select-all" class="form-check-input me-2">
                        <label for="select-all" class="form-check-label">Pilih Semua</label>
                    </div>
        
                    <div id="notif-items" style="max-height: 300px; overflow-y: auto;">
                        @foreach($notifs as $notif)
                            <div class="d-flex align-items-start border-bottom py-2">
                                <input type="checkbox" class="form-check-input me-2 notif-checkbox" value="{{ $notif->id }}">
                                <div class="flex-grow-1">
                                    <div class="fw-bold">{{ $notif->title }}</div>
                                    <div class="small text-muted">{{ $notif->value }}</div>
                                    @if($notif->status == 0)
                                        <span class="badge bg-warning">Baru</span>
                                    @else
                                        <span class="badge bg-success">Dibaca</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
        
                    <div class="d-flex justify-content-between align-items-center mt-2">
                        <button class="btn btn-sm btn-success flex-grow-1 me-1" id="mark-selected">Tandai Dibaca</button>
                        <button class="btn btn-sm btn-danger flex-grow-1 ms-1" id="clear-selected">Hapus Notifikasi</button>
                    </div>
                @else
                    <div class="text-center text-muted">Tidak ada notifikasi.</div>
                @endif
            </div>
          </div>
        @endif

        
        </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
          // Ceklis Semua
          document.getElementById('select-all').addEventListener('change', function() {
              const checked = this.checked;
              document.querySelectorAll('.notif-checkbox').forEach(cb => cb.checked = checked);
          });
      
          // Mark Selected
          document.getElementById('mark-selected').addEventListener('click', function() {
              const ids = getSelectedIds();
              if (ids.length > 0) {
                  fetch('/notif/mark-selected', {
                      method: 'POST',
                      headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}',
                          'Content-Type': 'application/json'
                      },
                      body: JSON.stringify({ ids: ids })
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          removeSelected();
                          updateNotifCount(-ids.length);
                      }
                  });
              }
          });
      
          // Clear Selected
          document.getElementById('clear-selected').addEventListener('click', function() {
              const ids = getSelectedIds();
              if (ids.length > 0) {
                  fetch('/notif/clear-selected', {
                      method: 'POST',
                      headers: {
                          'X-CSRF-TOKEN': '{{ csrf_token() }}',
                          'Content-Type': 'application/json'
                      },
                      body: JSON.stringify({ ids: ids })
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          removeSelected();
                          updateNotifCount(-ids.length);
                      }
                  });
              }
          });
      
          // Helper
          function getSelectedIds() {
              const selected = [];
              document.querySelectorAll('.notif-checkbox:checked').forEach(cb => {
                  selected.push(cb.value);
              });
              return selected;
          }
      
          function removeSelected() {
              document.querySelectorAll('.notif-checkbox:checked').forEach(cb => {
                  cb.closest('.d-flex').remove();
              });
          }
      
          function updateNotifCount(change) {
              const badge = document.getElementById('notif-count');
              let current = parseInt(badge.innerText) || 0;
              current += change;
              badge.innerText = Math.max(0, current);
          }
      });
      </script>
      
      
          
      <div class="d-none d-md-flex">
        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
     data-bs-placement="bottom">
          <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
        </a>
        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
     data-bs-placement="bottom">
          <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
        </a>
        <div class="nav-item dropdown d-none d-md-flex me-3">
          
        </div>
      </div>
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm" style="background-image: url('{{ asset('storage/' . Auth::user()->profile) }}')"></span>
          <div class="d-none d-xl-block ps-2">
            <div>{{Auth::user()->name}}</div>
            <div class="mt-1 small text-secondary">{{Auth::user()->no_pegawai}}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="{{route('profile',Auth::user()->id)}}" class="dropdown-item">Profile</a>
         
          <div class="dropdown-divider"></div>
          <a href="{{route('logout')}}" class="dropdown-item">Logout</a>
        </div>
      </div>
    </div>
  </div>