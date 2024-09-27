@extends('layout.pegawai.main')
@section('title')
Kelola Gaji || Human Capital
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
          Kelola Gaji
        </h2>
      </div>
      <div class="col-auto ms-auto d-print-none d-flex align-items-center position-relative">
        <!-- Search Form -->
        <form action="{{ route('hc.kelola-user') }}" method="GET" class="d-flex justify-content-center mb-0 position-relative">
            <input type="text" id="searchInput" name="search" class="form-control w-100" 
                   placeholder="Search gaji..." value="{{ request()->query('search') }}">
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
        <a href="{{route('hc.kelola-user.add')}}" class="btn btn-primary d-none d-sm-inline-block ms-3" data-bs-toggle="modal" data-bs-target="#modal-report">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Tambahkan Project Baru
        </a>
    </div>
   

@endsection