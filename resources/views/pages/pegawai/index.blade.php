@extends('layout.pegawai.main')
@section('title')
Dashboard || Pegawai
@endsection
@section('content')

<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Overview
        </div>
        <h2 class="page-title">
          Dashboard
        </h2>
      </div>
      
    </div>
  </div>
</div>
<!-- Page body -->
<div class="page-body">
<div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
              <div class="subheader">Total Pegawai</div>
              @php
                  $pegawai = \App\Models\User::where('role',1)->count();
                  $project = \App\Models\ProjectM::all()->count();
              @endphp
              <div class="h1 ">{{$pegawai}}</div>
          </div>
          <!-- Replace with an image that's related to employees, like a team icon or office environment -->
          <img src="{{asset('division.png')}}" alt="Employee Icon" class="img-fluid mx-auto d-block mb-2" style="width: 100px; height: auto;">
      </div>
      
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="subheader">Your Project</div>
            @php
                $pegawai = \App\Models\User::where('role', 1)->count();
            
                $pegawai_ids = \App\Models\ProjectM::pluck('pegawai_id');
                $decoded_ids = $pegawai_ids->map(function ($item) {
                    return $item ? json_decode($item) : []; // Ensure null is converted to an empty array
                });
            
                $user_id = Auth::user()->id;
            
                // Filter arrays that contain the user ID and count them
                $count = $decoded_ids->filter(function ($ids) use ($user_id) {
                    return is_array($ids) && in_array($user_id, $ids); // Check if $ids is an array
                })->count();
            @endphp
            <div class="h1 ">{{ $count ?? 0 }}</div>
            
          </div>
          <!-- Replace with an image that's related to employees, like a team icon or office environment -->
          <img src="{{asset('project.png')}}" alt="Employee Icon" class="img-fluid mx-auto d-block mb-2" style="width: 100px; height: auto;">
      </div>
      
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
              <div class="subheader">Total Ketua Project</div>
              @php
                  $pegawai = \App\Models\User::where('role',1)->count();
                  $kapro = \App\Models\User::where('role',2)->count();
                  $project = \App\Models\ProjectM::all()->count();
              @endphp
              <div class="h1 ">{{$kapro}}</div>
          </div>
          <!-- Replace with an image that's related to employees, like a team icon or office environment -->
          <img src="{{asset('manager.png')}}" alt="Employee Icon" class="img-fluid mx-auto d-block mb-2" style="width: 100px; height: auto;">
      </div>
      
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
              <div class="subheader">Total Project Done</div>
              @php
                $pegawai_idsin = \App\Models\ProjectM::where('status', 2)->pluck('pegawai_id');
                $decoded_idsin = $pegawai_idsin->map(function ($item) {
                    return $item ? json_decode($item) : []; // Pastikan null diubah menjadi array kosong
                });

                $user_idin = Auth::user()->id;

                // Filter arrays that contain the user ID and count them
                $countin = $decoded_idsin->filter(function ($idsin) use ($user_idin) {
                    return is_array($idsin) && in_array($user_idin, $idsin); // Periksa jika $idsin adalah array
                })->count();
            @endphp
            <div class="h1 ">{{ $countin ?? 0 }}</div>

          </div>
          <!-- Replace with an image that's related to employees, like a team icon or office environment -->
          <img src="{{asset('done.png')}}" alt="Employee Icon" class="img-fluid mx-auto d-block mb-2" style="width: 100px; height: auto;">
      </div>
      
      </div>

      
      <!-- Chart User -->
      <div class="col-6">
        <div class="card">
            <div class="card-body">
                <div class="subheader text-center">Tren User</div>
                @php
                    $t_hc = \App\Models\User::where('role', 0)->count();
                    $t_pegawai = \App\Models\User::where('role', 1)->count();
                    $t_kasieka = \App\Models\User::where('role', 2)->count();
                    $t_manajerhc = \App\Models\User::where('role', 3)->count();
                @endphp

                <!-- Wrapper untuk posisi center -->
                <div class="d-flex justify-content-center align-items-center">
                    <canvas id="userPieChart" class="pie-chart" width="400" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Project -->
    <div class="col-6">
      <div class="card">
          <div class="card-body">
              <div class="subheader text-center">Tren Project</div>
              @php
                  $pegawai_ids = \App\Models\ProjectM::pluck('pegawai_id');
                  $decoded_ids = $pegawai_ids->map(function ($item) {
                      return $item ? json_decode($item) : []; // Handle null and decode
                  });
  
                  $user_id = Auth::user()->id;
  
                  // Count the projects for each status for the logged-in user
                  $p_done = $decoded_ids->filter(function ($ids, $index) use ($user_id) {
                      return in_array($user_id, $ids) && \App\Models\ProjectM::where('id', $index + 1)->value('status') == 2;
                  })->count();
  
                  $p_nonactive = $decoded_ids->filter(function ($ids, $index) use ($user_id) {
                      return in_array($user_id, $ids) && \App\Models\ProjectM::where('id', $index + 1)->value('status') == 0;
                  })->count();
  
                  $p_pemeliharaan = $decoded_ids->filter(function ($ids, $index) use ($user_id) {
                      return in_array($user_id, $ids) && \App\Models\ProjectM::where('id', $index + 1)->value('status') == 5;
                  })->count();
  
                  $p_active = $decoded_ids->filter(function ($ids, $index) use ($user_id) {
                      return in_array($user_id, $ids) && \App\Models\ProjectM::where('id', $index + 1)->value('status') == 1;
                  })->count();
              @endphp
  
              <div class="d-flex justify-content-center align-items-center">
                  <canvas id="projectPieChart" class="pie-chart" width="400" height="400"></canvas>
              </div>
          </div>
      </div>
  </div>

<!-- Tambahkan Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Pie Chart
    const userCtx = document.getElementById('userPieChart').getContext('2d');
    const userPieChart = new Chart(userCtx, {
        type: 'pie',
        data: {
            labels: ['Human Capital', 'Pegawai', 'Kasieka', 'Manajer HC'],
            datasets: [{
                label: 'User Roles',
                data: [{{$t_hc}}, {{$t_pegawai}}, {{$t_kasieka}}, {{$t_manajerhc}}],
                backgroundColor: [
                    '#007bff', // Human Capital - Blue
                    '#28a745', // Pegawai - Green
                    '#ffc107', // Kasieka - Yellow
                    '#dc3545'  // Manajer HC - Red
                ],
                borderColor: ['#ffffff', '#ffffff', '#ffffff', '#ffffff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw || 0;
                            return `${context.label}: ${value} users`;
                        }
                    }
                }
            }
        }
    });

    // Project Pie Chart
    const projectCtx = document.getElementById('projectPieChart').getContext('2d');
    const projectPieChart = new Chart(projectCtx, {
        type: 'pie',
        data: {
            labels: ['Done', 'Non-Active', 'Pemeliharaan', 'Active'],
            datasets: [{
                label: 'Projects',
                data: [{{$p_done}}, {{$p_nonactive}}, {{$p_pemeliharaan}}, {{$p_active}}],
                backgroundColor: [
                    '#28a745', // Done - Green
                    '#6c757d', // Non-Active - Gray
                    '#ffc107', // Pemeliharaan - Yellow
                    '#007bff'  // Active - Blue
                ],
                borderColor: ['#ffffff', '#ffffff', '#ffffff', '#ffffff'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: false,
            plugins: {
                legend: {
                    position: 'top'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.raw || 0;
                            return `${context.label}: ${value} projects`;
                        }
                    }
                }
            }
        }
    });
</script>
      
      <div class="col-12">
        <div class="card card-md">
          <div class="card-stamp card-stamp-lg">
            <div class="card-stamp-icon bg-primary">
              <!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 11a7 7 0 0 1 14 0v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-7" /><path d="M10 10l.01 0" /><path d="M14 10l.01 0" /><path d="M10 14a3.5 3.5 0 0 0 4 0" /></svg>
            </div>
          </div>
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-10">
                <h3 class="h1">Project</h3>
                <div class="markdown text-secondary">
                  Project in PT. Wijaya Karya 
                </div>
                <div class="mt-3">
                  <a href="{{route('pegawai.project')}}" class="btn btn-primary" rel="noopener">Go To Project</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

@endsection