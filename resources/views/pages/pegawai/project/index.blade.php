@extends('layout.pegawai.main')
@section('title')
Project || Pegawai
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
            Project
          </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <span class="d-none d-sm-inline">
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
            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
            </a>
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
                            <th>Project Name</th>
                            <th>Ketua Project </th>
                            <th>Kode Project </th>
                            <th>Divisi </th>
                            <th>Status </th>
                            <th>Start Date </th>
                            <th>End Date </th>
                            <th>Action </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $d)
                        <tr>
                            <td>{{$loop->iteration}}</td>
                            <td>{{$d->judul}}</td>
                            <td>
                                @php
                                    $name = \App\Models\User::where('id',$d->kapro_id)->value('name');
                                @endphp
                                {{$name}}
                            </td>
                            <td>{{$d->kode_project}}</td>
                            <td>{{$d->divisi}}</td>
                            <td>{{$d->status == 0 ? 'Nonactive' : ($d->status == 1 ? 'On-Progres' : ($d->status == 2? 'Complete' : 'Unknown'))}}</td>
                            <td>{{$d->start}}</td>
                            <td>{{$d->end}}</td>
                            <td>
                                <a href="{{route('pegawai.project.detail',$d->id)}}" class="btn btn-primary">Detail</a>
                                @if ($d->status == 2)
                                <a href="{{route('pegawai.project.laporan',$d->id)}}" class="btn btn-success">Isi laporan</a>
                                @else
                                @endif
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