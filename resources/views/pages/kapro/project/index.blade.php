@extends('layout.pegawai.main')
@section('title')
Kelola Project || Kepala seksi kesejahteraan aparatur
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
          Kelola project
        </h2>
      </div>
      <div class="col-auto ms-auto d-print-none d-flex align-items-center position-relative">
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
    
        <!-- Tambahkan Pegawai Baru Button -->
        {{-- <a href="{{route('hc.kelola-project.add')}}" class="btn btn-primary d-none d-sm-inline-block ms-3" data-bs-toggle="modal" data-bs-target="#modal-report">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Tambahkan Project Baru
        </a> --}}
    </div>
    <div class="page-body">
        <div class="container-xl">
          <div class="row row-cards">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        @if ($hasil == null)
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kode Project</th>
                                        <th>Divisi</th>
                                        <th>Status</th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td class="w-1">{{$d->judul}}</td>
                                            <td class="text-nowrap">{{$d->kode_project}}</td>
                                            <td>{{$d->divisi}}</td>
                                            <td class="text-nowrap">
                                                @if ($d->status == 0)
                                                    <a href="" class="text-red">Nonactive</a>
                                                @elseif ($d->status == 1)
                                                    <a href="" class="text-success">Aktif</a>
                                                @elseif($d->status == 5)
                                                    <a href="" class="text-orange">Pemeliharaan</a>
                                                @elseif($d->status == 2)
                                                    <a href="" class="text-green">Complete</a>
                                                @endif
                                            </td>
                                            <td class="text-nowrap text-secondary">{{$d->kategori}}</td>
                                            <td class="text-nowrap">
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-edit-report-{{ $d->id }}">Edit</a>
                                                <a href="{{route('kapro.project.detail',$d->id)}}" class="btn btn-success">Detail</a>
                                                @if ($d->status == 2)
                                                <a href="{{route('kapro.project.laporan.isi',$d->id)}}" class="btn btn-gray">Isi Laporan</a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <table class="table table-vcenter">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Judul</th>
                                        <th>Kode Project</th>
                                        <th>Divisi</th>
                                        <th>Status</th>
                                        <th>Kategori</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $d)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td class="w-1">{{$d->judul}}</td>
                                            <td class="text-nowrap">{{$d->kode_project}}</td>
                                            <td>{{$d->divisi}}</td>
                                            <td class="text-nowrap">
                                                @if ($d->status == 0)
                                                    <a href="" class="text-red">Nonactive</a>
                                                @elseif ($d->status == 1)
                                                    <a href="" class="text-success">Aktif</a>
                                                @elseif($d->status == 5)
                                                    <a href="" class="text-orange">Pemeliharaan</a>
                                                @elseif($d->status == 2)
                                                    <a href="" class="text-green">Complete</a>
                                                @endif
                                            </td>
                                            <td class="text-nowrap text-secondary">{{$data->kategori}}</td>
                                            <td class="text-nowrap">
                                                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-edit-report-{{ $d->id }}">Edit</a>
                                                <a href="{{route('kapro.project.detail',$d->id)}}" class="btn btn-success">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    
                        <!-- Modals for Editing Projects -->
                        @foreach ($data as $d)
                            <div class="modal modal-blur fade" id="modal-edit-report-{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Project</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{ route('hc.kelola-project.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Judul</label>
                                                    <input type="text" class="form-control" name="judul" value="{{ old('judul', $d->judul) }}" placeholder="Isi Judul" required>
                                                    @error('judul')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Kode Project</label>
                                                    <input type="text" class="form-control" name="kode_project" value="{{ old('kode_project', $d->kode_project) }}" placeholder="Isi Sub Judul">
                                                </div>
                    
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi (optional)</label>
                                                    <textarea class="form-control" name="deskripsi" placeholder="Isi Deskripsi">{{ old('deskripsi', $d->deskripsi) }}</textarea>
                                                </div>
                    
                                                <div class="mb-3">
                                                    <label class="form-label">Dept Operation</label>
                                                    <input type="text" class="form-control" name="divisi" value="{{ old('divisi', $d->divisi) }}">
                                                </div>
                    
                                                <div class="mb-3">
                                                    <label class="form-label">Kode Unit Kerja</label>
                                                    <input type="text" class="form-control" name="kode_uk" value="{{ old('kode_uk', $d->kode_uk) }}">
                                                </div>
                    
                                                <div class="mb-3">
                                                    <label class="form-label">Unit Kerja</label>
                                                    <input type="text" class="form-control" name="unit_kerja" value="{{ old('unit_kerja', $d->unit_kerja) }}">
                                                </div>
                    
                                               
                    
                                                <div class="mb-3">
                                                    <label class="form-label">Start Date</label>
                                                    <input type="date" class="form-control" name="start" value="{{ old('start', $d->start) }}">
                                                </div>
                    
                                                <div class="mb-3">
                                                    <label class="form-label">End Date</label>
                                                    <input type="date" class="form-control" name="end" value="{{ old('end', $d->end) }}">
                                                </div>
                                            </div>
                    
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                                    Cancel
                                                </a>
                                                <button type="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg>
                                                    Update Project
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                  <style>
                    
                    .pagination p{
                      display: none;
                    }
                    .pagination .flex span:nth-child(1){
                      display: none;
                    }
      
                  </style>
                  <div class="d-flex justify-content-center">
                    <div class="pagination" style="padding: 15px 0;">
                        {{ $data->links() }}
                    </div>
                </div>
                
                </div>
              </div>
            </div>
            
          </div>
        </div>
       </div>
    </div>
  </div>
</div>
@endsection