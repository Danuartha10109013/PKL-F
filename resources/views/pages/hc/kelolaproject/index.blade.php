@extends('layout.pegawai.main')
@section('title')
Kelola Project || Human Capital
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
          Kelola Project
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
        <a href="{{route('hc.kelola-project.add')}}" class="btn btn-primary d-none d-sm-inline-block ms-3" data-bs-toggle="modal" data-bs-target="#modal-report">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M12 5l0 14" />
                <path d="M5 12l14 0" />
            </svg>
            Tambahkan Project Baru
        </a>
    </div>
    <script>
      document.getElementById('clearSearch').addEventListener('click', function() {
          document.getElementById('searchInput').value = ''; // Clear the input value
          window.location.href = "{{ route('hc.kelola-project') }}"; // Redirect to the base route
      });
  </script>
   
   <div class="page-body">
    <div class="container-xl">
      <div class="row row-cards">
        <div class="col-md-9">
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
                                      @elseif($d->status == 1)
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
                                        <a href="{{route('hc.project.detail',$d->id)}}" class="btn btn-success">Detail</a>

                                        <!-- Delete button triggers modal -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $d->id }}">
                                            Delete
                                        </button>
                            
                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal{{ $d->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $d->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $d->id }}">Confirm Delete</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete {{ $d->name }}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                        <form action="{{ route('hc.kelola-project.delete', $d->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                            @foreach ($hasil as $d)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td class="w-1">{{$d->judul}}</td>
                                    <td class="text-nowrap">{{$d->kode_project}}</td>
                                    <td>{{$d->divisi}}</td>
                                    <td class="text-nowrap">
                                      @if ($d->status == 0)
                                          <a href="" class="text-red">Nonactive</a>
                                      @elseif($d->status == 1)
                                          <a href="" class="text-success">Aktif</a>
                                      @elseif($d->status == 5)
                                          <a href="" class="text-orange">Pemeliharaan</a>
                                      @elseif($d->status == 2)
                                          <a href="" class="text-green">Complete</a>
                                      @endif
                                  </td>
                                  
                                    <td class="text-nowrap text-secondary">{{$d->kategori}}</td>
                                    <td class="text-nowrap">
                                        <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modal-edit-report-{{ $d->id }}">Edit</a>
                                        <a href="{{route('hc.kelola-project.detail',$d->id)}}" class="btn btn-success">Detail</a>
                                        <!-- Delete button triggers modal -->
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $d->id }}">
                                          Delete
                                      </button>
                          
                                      <!-- Modal -->
                                      <div class="modal fade" id="deleteModal{{ $d->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $d->id }}" aria-hidden="true">
                                          <div class="modal-dialog">
                                              <div class="modal-content">
                                                  <div class="modal-header">
                                                      <h5 class="modal-title" id="deleteModalLabel{{ $d->id }}">Confirm Delete</h5>
                                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                  </div>
                                                  <div class="modal-body">
                                                      Are you sure you want to delete {{ $d->name }}?
                                                  </div>
                                                  <div class="modal-footer">
                                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                      <form action="{{ route('hc.kelola-project.delete', $d->id) }}" method="POST">
                                                          @csrf
                                                          @method('DELETE')
                                                          <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                      </form>
                                                  </div>
                                              </div>
                                          </div>
                                      </div>
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
                                  @method('PUT') <!-- Use PUT for updating a resource -->
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
                                        <input type="text" class="form-control" name="divisi" placeholder="Isi Dept Operation" value="{{ old('divisi', $d->divisi) }}">
                                    </div>
                                
                                    <div class="mb-3">
                                        <label class="form-label">Kode Unit Kerja</label>
                                        <input type="text" class="form-control" name="kode_uk" placeholder="Isi Kode Unit Kerja" value="{{ old('kode_uk', $d->kode_uk) }}">
                                    </div>
                                
                                    <div class="mb-3">
                                        <label class="form-label">Unit Kerja</label>
                                        <input type="text" class="form-control" name="unit_kerja" placeholder="Isi Unit Kerja" value="{{ old('unit_kerja', $d->unit_kerja) }}">
                                    </div>
                                
                                    <div class="mb-3">
                                        <label class="form-label">Gaji</label>
                                        <input type="number" class="form-control" name="gaji" placeholder="Isi Gaji" value="{{ old('gaji', $d->gaji) }}">
                                    </div>
                                
                                    <div class="mb-3">
                                      <label class="form-label">Pilih Ketua Project</label>
                                      
                                      <select class="form-control" name="kapro" id="kapro" required>
                                          <option value="" disabled selected>Pilih Ketua Project</option> <!-- Optional placeholder -->
                                          @foreach ($datakapro as $kaproin)
                                              <option value="{{ $kaproin->id }}" {{ old('kapro_id', $d->kapro_id) == $kaproin->id ? 'selected' : '' }}>
                                                  {{ $kaproin->name }}
                                              </option>
                                          @endforeach
                                      </select>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Start Date</label>
                                        <input type="date" class="form-control" name="start" placeholder="Pilih Tanggal Mulai" value="{{ old('start', $d->start) }}">
                                    </div>
                                
                                    <div class="mb-3">
                                        <label class="form-label">End Date</label>
                                        <input type="date" class="form-control" name="end" placeholder="Pilih Tanggal Selesai" value="{{ old('end', $d->end) }}">
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
        <div class="col-md-3">
          <div class="row ">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="subheader">Total Project</div>   
                  </div>
                  <div class="h1 mt-2">{{$count}}</div>
     
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="subheader">Total Project Inactive</div>   
                  </div>
                  <div class="h1  mt-2">{{$countpegawai}}</div>
                  
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="subheader">Total Project On Progres</div>   
                  </div>
                  <div class="h1  mt-2">{{$counthc}}</div>
                  
                </div>
              </div>
            </div>
          </div>
          <div class="row mt-3">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center">
                    <div class="subheader">Total Project Completed</div>   
                  </div>
                  <div class="h1 mt-2">{{$countkapro}}</div>
                  
                </div>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </div>
   </div>
   
   <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">New Project</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="{{route('hc.kelola-project.store')}}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="modal-body">
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Kode Project</label>
                  <input type="text" class="form-control" name="kode_project" placeholder="Isi Sub Judul" >
                </div>
                <div class="mb-3">
                  <label class="form-label">Judul</label>
                  <input type="text" class="form-control" name="judul" placeholder="Isi Judul" required>
                  @error('judul')
                      <span class="text-danger">{{ $message }}</span>
                  @enderror
                </div>
                <div class="mb-3">
                  <label class="form-label">Kategori</label>
                  <select type="text" class="form-control" name="kategori" placeholder="Isi Dept Operasi">
                    <option value="" selected disabled>--Pilih Kategori--</option>
                    <option value="Besar" >Besar</option>
                    <option value="Kecil" >Kecil</option>
                    <option value="Mega D&B" >Mega D&B</option>
                    <option value="Mega Non D&B" >Mega Non D&B</option>
                    <option value="Menengah" >Menengah</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Dept Operasi</label>
                  <select type="text" class="form-control" name="divisi" placeholder="Isi Dept Operasi">
                    <option value="" selected disabled>--Pilih Departemen--</option>
                    <option value="HSR Departement" >HSR Departement</option>
                    <option value="Operation 1 Deaprtemen" >Operation 1 Deaprtemen</option>
                    <option value="Operation 2 Deaprtemen" >Operation 2 Deaprtemen</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label class="form-label">Deskripsi (optional)</label>
                  <textarea class="form-control" name="deskripsi" placeholder="Isi Deskripsi"></textarea>
                </div>   
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Kode Unit kerja</label>
                  <input type="text" class="form-control" name="kode_uk" placeholder="Isi Kode Unit kerja"></input>
                </div>   
                <div class="mb-3">
                  <label class="form-label"> Unit kerja</label>
                  <input type="text" class="form-control" name="unit_kerja" placeholder="Isi Unit kerja"></input>
                </div>  
                <div class="mb-3">
                  <label class="form-label">Status project</label>
                  <select type="text" class="form-control" name="statusin" placeholder="Isi Dept Operasi">
                    <option value="" selected disabled>--Pilih Status--</option>
                    <option value="Proyek JO" >Proyek JO</option>
                    <option value="Proyek Non JO" >Proyek Non JO</option>
                  </select>
                </div> 
                <div class="mb-3">
                  <label class="form-label">Strategic Business Unit</label>
                  <select type="text" class="form-control" name="sbu" placeholder="Isi Dept Operasi">
                    <option value="" selected disabled>--Pilih SBU--</option>
                    <option value="AIRPORT" >AIRPORT</option>
                    <option value="BENDUNGAN" >BENDUNGAN</option>
                    <option value="JALAN & JEMBATAN" >JALAN & JEMBATAN</option>
                    <option value="RAILWAY" >RAILWAY</option>
                    <option value="WATER INFRASTRUCTURE" >WATER INFRASTRUCTURE</option>
                    <option value="Proyek Non JO" >Proyek Non JO</option>
                  </select>
                </div> 
                 
                <div class="mb-3">
                  <label class="form-label">Pilih KasieKA</label>
                  <select class="form-control" name="kapro" id="kapro" required>
                    @foreach ($datakapro as $kaproin)
                      <option value="" selected disabled>--Pilih KasieKA--</option>
                      <option value="{{$kaproin->id}}">{{$kaproin->name}}</option>
                    @endforeach
                  </select>
                </div>
              </div>
            </div>
              
            
            <div class="row">
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Date Start</label>
                <input type="date" class="form-control" name="start" ></input>
              </div>   
            </div>  
            <div class="col-md-6">
              <div class="mb-3">
                <label class="form-label">Date End</label>
                <input type="date" class="form-control" name="end" ></input>
              </div>   
            </div>  
            </div> 
            
            
            
          </div>
          
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <button type="submit" href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
              Create new Project
            </button>
          </div>
                
      </form>
      </div>
    </div>
  </div>

@endsection