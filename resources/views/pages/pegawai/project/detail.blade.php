@extends('layout.pegawai.main')
@section('title')
Detail Project || {{$data->judul}}
@endsection

@section('content')
<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col-md-10">
        <!-- Page pre-title -->
        <div class="page-pretitle">
          Overview
        </div>
        <h2 class="page-title">
          Detail Project
        </h2>
      </div>
      <div class="col-md-2">
        @if (Auth::user()->role == 1)
            @if ($data->status == 0)
            <a href="#" class="btn btn-primary" style="margin-right: 15px" data-toggle="modal" data-target="#activateModal">Activate</a>
            @elseif ($data->status == 1 || $data->status == 5)
            @if ($data->status == 1)
            <a href="#" class="btn btn-success" style="margin-right: 15px" data-toggle="modal" data-target="#progressModal">Aktif</a>
            @else
            <a href="#" class="btn btn-warning" style="margin-right: 15px" data-toggle="modal" data-target="#progressModal">Pemeliharaan</a>
            @endif
            @elseif ($data->status == 2)
            <a class="btn btn-success" style="margin-right: 15px" data-toggle="modal" data-target="#completeModal">Complete</a>
            @endif
        @else
        @endif 
      </div>
    </div>
  </div>
</div>


<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <!-- Project Information -->
            <h3 class="mb-4">Project Information</h3>
            <div class="row">
              <div class="col-md-6">
                <p><strong>Judul:</strong> {{$data->judul}}</p>
                <p><strong>Kode Project:</strong> {{$data->kode_project}}</p>
                <p><strong>Kategori:</strong> {{$data->kategori}}</p>
                <p><strong>Status:</strong> {{$data->statusin}}</p>
                <p><strong>SBU:</strong> {{$data->sbu}}</p>
                <p><strong>Deskripsi:</strong> {{$data->deskripsi}}</p>
              </div>
              <div class="col-md-6">
                <p><strong>Dept Operation:</strong> {{$data->divisi}}</p>
                <p><strong>Kode Unit Kerja:</strong> {{$data->kode_uk}}</p>
                <p><strong>Unit Kerja:</strong> {{$data->unit_kerja}}</p>
                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($data->start)->format('d M Y') }}</p>
                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($data->end)->format('d M Y') }}</p>
                <p> 
                @php
                    $nilai = \App\Models\PenilaianM::where('project_id',$data->id)->where('user_id',Auth::user()->id)->value('total');
                    $keterangan = \App\Models\PenilaianM::where('project_id',$data->id)->where('user_id',Auth::user()->id)->value('keterangan');
                @endphp
                <div class="btn btn-primary">
                    <strong>Total Nilai:</strong>
                    @if ($nilai)
                    {{$nilai}}
                    @else
                    Belum di nilai
                    @endif
                </div>

                </p>
                @if ($keterangan)
                <p><strong>Keterangan Nilai:</strong> {{$keterangan}}</p>
                @else
                <p><strong>Keterangan Nilai:</strong> Not available</p>
                @endif

                 
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<!-- jQuery dan Bootstrap JS -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Include Bootstrap JS for Modal functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
