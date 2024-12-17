@extends('layout.pegawai.main')
@section('title')
Dashboard || Kepala seksi kesejahteraan aparatur
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
                  $pegawai = \App\Models\User::where('role',1)->count();
                  $project = \App\Models\ProjectM::where('kapro_id',Auth::user()->id)->count();
              @endphp
              <div class="h1 ">{{$project}}</div>
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
                  $projectin = \App\Models\ProjectM::where('kapro_id',Auth::user()->id)->where('status',2)->count();
              @endphp
              <div class="h1 ">{{$projectin}}</div>
          </div>
          <!-- Replace with an image that's related to employees, like a team icon or office environment -->
          <img src="{{asset('done.png')}}" alt="Employee Icon" class="img-fluid mx-auto d-block mb-2" style="width: 100px; height: auto;">
      </div>
      
      </div>
      
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
                  <a href="{{route('kapro.project')}}" class="btn btn-primary" rel="noopener">Go To Project</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
    </div>
  </div>

@endsection