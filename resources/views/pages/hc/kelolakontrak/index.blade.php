@extends('layout.pegawai.main')
@section('title')
Kelola Kontrak || Human Capital
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
          Kelola Kontrak
        </h2>
      </div>
      <div class="col-auto ms-auto d-print-none d-flex align-items-center position-relative">
        <!-- Search Form -->
        <form action="{{ route('hc.kelola-user') }}" method="GET" class="d-flex justify-content-center mb-0 position-relative">
            <input type="text" id="searchInput" name="search" class="form-control w-100" 
                   placeholder="Search kontrak..." value="{{ request()->query('search') }}">
            <!-- Clear 'X' Button outside the input -->
            @if(request()->query('search'))
                <button type="button" id="clearSearch" class="btn btn-light position-absolute" 
                        style="right: 90px; top: 50%; transform: translateY(-50%); z-index: 2;">
                    &times;
                </button>
            @endif
    
            <button type="submit" class="btn btn-primary ms-2">Search</button>
        </form>
    
        <!-- Tambahkan Pegawai Baru Button -->
        <a href="{{route('hc.kelola-user.add')}}" class="btn btn-success d-none d-sm-inline-block ms-3" data-bs-toggle="modal" data-bs-target="#modal-report">
            
            Get All Kontrak
        </a>
    </div>
   <div class="card">
    <div class="container mt-3">
      <table class="table table-vcenter">
        <thead>
            <tr>
                <th>No</th>
                <th>Pegawai</th>
                <th>Duration</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Periode</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
          <tbody>
            @foreach ($data as $d)
            <tr>
              <td>{{$loop->iteration}}</td>
              <td>
                @php
                  $name = \App\Models\User::where('id',$d->user_id)->value('name');
                @endphp
                {{$name}}
              </td>
              
              <td>
                @php
                    $today = \Carbon\Carbon::now();
                    $endDate = \Carbon\Carbon::parse($d->akhir_kontrak);
                    $remainingDays = ceil($endDate->diffInDays($today, false)); // Round up to the nearest whole number
                @endphp
                @if ($remainingDays < 0)
                {{ abs($remainingDays) }} hari 
                @else
                <p class="text-danger">Kontrak Selesai</p>
                @endif
              </td>
              <td>{{ $d->awal_kontrak }}</td>
              <td>{{ $d->akhir_kontrak }}</td>
              
            
              <td>{{$d->periode}}</td>
              <td> 
                @if ($remainingDays < 0)
                
                @else
                <!-- Trigger Button -->
                <a href="javascript:void(0)" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#perpanjangModal-{{ $d->id }}">
                  <i class=""></i> Perpanjang
                </a>

                <!-- Modal Structure -->
                <div class="modal fade" id="perpanjangModal-{{ $d->id }}" tabindex="-1" aria-labelledby="perpanjangModalLabel-{{ $d->id }}" aria-hidden="true">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <h5 class="modal-title" id="perpanjangModalLabel-{{ $d->id }}">Perpanjang User</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="{{ route('hc.kelola-user.perpanjang', $d->id) }}" method="POST">
                              @csrf
                              <div class="modal-body">
                                  <!-- Start Date Input (Default to Today) -->
                                  <div class="mb-3">
                                      <label for="startDate" class="form-label">Start Date</label>
                                      <input type="date" name="start_date" id="startDate" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}" required>
                                  </div>

                                  <!-- End Date Input (User Selected) -->
                                  <div class="mb-3">
                                      <label for="endDate" class="form-label">End Date</label>
                                      <input type="date" name="end_date" id="endDate" class="form-control" required>
                                  </div>
                              </div>
                              <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-success">Save Changes</button>
                              </div>
                          </form>
                      </div>
                  </div>
                </div>
                @endif
                <a href="" class="btn btn-primary"><i class=""></i>Show</a>
                <a href="" class="btn btn-warning">Print</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      {{ $data->links() }}

    </div>
  </div>
  <style>
              
    .pagination p{
      display: none;
    }
    .pagination .flex span:nth-child(1){
      display: none;
    }

  </style>

@endsection