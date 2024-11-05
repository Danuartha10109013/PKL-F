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
                <th>Project Name</th>
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
                  $pn = \App\Models\ProjectM::where('id',$d->project_id)->value('judul');
                @endphp
                {{$pn == null ? 'Project Unavailable' : $pn}}
              </td>
              <td>{{$d->awal_kontrak}}</td>
              <td>{{$d->akhir_kontrak}}</td>
              <td>{{$d->periode}}</td>
              <td>
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