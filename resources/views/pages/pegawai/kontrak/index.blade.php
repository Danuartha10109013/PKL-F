@extends('layout.pegawai.main')
@section('title')
Kontrak || Pegawai
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
            Kontrak
          </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <!-- Search Form -->
            <form action="{{ route('hc.kelola-project') }}" method="GET" class="d-flex justify-content-center mb-0 position-relative">
              <input type="text" id="searchInput" name="search" class="form-control w-100" 
                    placeholder="Search project..." value="{{ request()->query('search') }}">
              <!-- Clear 'X' Button outside the input -->
              @if(request()->query('search'))
                  <button type="button" id="clearSearch" class="btn btn-light position-absolute" 
                          style="right: 90px; top: 50%; transform: translateY(-50%); z-index: 2;">
                      &times;
                  </button>
              @endif
      
              <button type="submit" class="btn btn-primary ms-2">Search</button>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
  <div class="container-xl">
    <div class="card">
        <div class="container">
            <div class="table-responsive">
                <table class="table table-vcenter">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Awal Kontrak</th>
                            <th>Akhir Kontrak </th>
                            <th>Periode </th>
                            <th>Duration </th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$d->awal_kontrak}}</td>
                            <td>{{$d->akhir_kontrak}}</td>
                            <td>{{$d->periode}}</td>
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
                            <td>
                                <a href="" class="btn btn-warning">Print</a>
                                <a href="" class="btn btn-primary">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
  </div>
  </div>
@endsection