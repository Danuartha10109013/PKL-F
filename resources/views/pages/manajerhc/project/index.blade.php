@extends('layout.pegawai.main')
@section('title')
Laporan Project || Manajer HC
@endsection
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <!-- Page pre-title -->
          <div class="page-pretitle">
            Overview
          </div>
          <h2 class="page-title">
            Laporan Project
          </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <span class="d-none d-sm-inline">
              
            </span>
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Page body -->
  <div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            @foreach ($data as $d)
            <div class="col-sm-6 col-lg-4">
                <a href="{{ route('manajerhc.project.detail', $d->id) }}" class="text-decoration-none">
                    <div class="card shadow-sm" style="border-radius: 15px; transition: transform 0.3s; cursor: pointer;">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><strong>{{ $d->judul }}</strong></h5>
                            <p class="text-muted mb-1"><small>{{ $d->kode_project }}</small></p>
                            <p class="mb-2">
                                <strong>Division:</strong> {{ $d->divisi }}<br>
                                <strong>Start:</strong> {{ $d->start ? $d->start : 'N/A' }}<br>
                                <strong>End:</strong> {{ $d->end ? $d->end : 'N/A' }}
                            </p>
                            <span class="badge bg-{{ $d->status == 2 ? 'success' : ($d->status == 0 ? 'secondary' : ($d->status == 5 ? 'warning' : ($d->status == 1 ? 'primary' : 'dark'))) }}" style="color: white;">
                                {{ $d->status == 2 ? 'Complete' : ($d->status == 0 ? 'Nonactive' : ($d->status == 5 ? 'Pemeliharaan' : ($d->status == 1 ? 'Active' : 'Undefined'))) }}
                            </span>
                            
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .card:hover {
        transform: scale(1.05);
    }
</style>

</div>
@endsection