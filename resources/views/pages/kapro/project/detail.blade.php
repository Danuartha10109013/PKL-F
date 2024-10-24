@extends('layout.pegawai.main')
@section('title')
Detail Project || {{$data->judul}}
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
          Detail Project
        </h2>
      </div>
    </div>
  </div>
</div>

<div class="col-auto ms-auto d-print-none d-flex align-items-center position-relative">
  @if ($data->status == 0)
  <a href="#" class="btn btn-primary" style="margin-right: 15px" data-toggle="modal" data-target="#activateModal">Activate</a>
@elseif ($data->status == 1)
  <a href="#" class="btn btn-warning" style="margin-right: 15px" data-toggle="modal" data-target="#progressModal">On Progress</a>
@elseif ($data->status == 2)
  <a class="btn btn-success" style="margin-right: 15px" data-toggle="modal" data-target="#completeModal">Complete</a>
@endif

<!-- Activate Modal -->
<div class="modal fade" id="activateModal" tabindex="-1" role="dialog" aria-labelledby="activateModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="activateModalLabel">Confirm Activation</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to activate this project?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="{{route('kapro.project.activate', $data->id)}}" class="btn btn-primary">Yes, Activate</a>
      </div>
    </div>
  </div>
</div>

<!-- On Progress Modal -->
<div class="modal fade" id="progressModal" tabindex="-1" role="dialog" aria-labelledby="progressModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="progressModalLabel">Confirm Progress</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you want to complete this project?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a href="{{route('kapro.project.complete', $data->id)}}" class="btn btn-success">Yes, Complete</a>
      </div>
    </div>
  </div>
</div>

<!-- Complete Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" role="dialog" aria-labelledby="completeModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="completeModalLabel">Project Complete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        This project is already complete.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


  <!-- Button to trigger modal -->
  @if ($data->status == 0)
  <button type="button" class="btn btn-secondary" style="margin-right: 20px" data-bs-toggle="modal" data-bs-target="#addUserModal">
    Add More User
  </button>
    @else
  @endif
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
                <p><strong>Deskripsi:</strong> {{$data->deskripsi}}</p>
              </div>
              <div class="col-md-6">
                <p><strong>Dept Operation:</strong> {{$data->divisi}}</p>
                <p><strong>Kode Unit Kerja:</strong> {{$data->kode_uk}}</p>
                <p><strong>Unit Kerja:</strong> {{$data->unit_kerja}}</p>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <p><strong>Gaji:</strong> Rp. {{ number_format($data->gaji, 0, ',', '.') }} ,00</p>
              </div>
              <div class="col-md-6">
                <p><strong>Start Date:</strong> {{ \Carbon\Carbon::parse($data->start)->format('d M Y') }}</p>
                <p><strong>End Date:</strong> {{ \Carbon\Carbon::parse($data->end)->format('d M Y') }}</p>
              </div>
            </div>

            <!-- Users List -->
            <div id="users-list" class="mt-4">
              <h4>Pegawai yang terlibat</h4>
              <table class="table table-vcenter">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                    @if ($data->status == 2)
                    <th>Total Nilai</th>
                    @else
                    @endif
                  </tr>
                </thead>
                <tbody>
                  @php
                      // Decode JSON array from pegawai_id
                      $pegawai_ids = json_decode($data->pegawai_id, true);

                      // Check if pegawai_ids is valid array
                      if (is_array($pegawai_ids) && count($pegawai_ids) > 0) {
                          // Retrieve users involved using whereIn to handle array of IDs
                          $user_terlibat = \App\Models\User::whereIn('id', $pegawai_ids)->get();
                      } else {
                          $user_terlibat = collect(); // Use empty collection if no users are involved
                      }
                  @endphp

                  @if($user_terlibat->isEmpty())
                    <tr>
                      <td colspan="6" class="text-center">No users assigned to this project yet.</td>
                    </tr>
                  @else
                    @foreach ($user_terlibat as $d)
                      <tr>
                        <td>{{$loop->iteration}}</td>
                        <td class="w-1">
                          <span class="avatar avatar-sm" style="background-image: url({{ asset('storage/' . $d->profile) }})"></span>
                        </td>
                        <td class="w-1">
                            {{$d->name}}
                        </td>
                        <td>
                          {{$d->username}}
                        </td>
                        <td class="text-nowrap text-secondary">
                          @if ($d->role == 0)
                            Human Capital
                          @elseif ($d->role == 1)
                            Pegawai
                          @elseif ($d->role == 2)
                            Ketua Project
                          @elseif ($d->role == 3)
                            Manajer HC
                          @elseif ($d->role == 4)
                            Pusat
                          @endif
                        </td>
                        <td class="text-nowrap">

                          @php
                          $project = $data->id;
                          $ids = \App\Models\PenilaianM::where('user_id', $d->id)->where('project_id',$project)->count();
                          $total = \App\Models\PenilaianM::where('user_id', $d->id)->where('project_id',$project)->value('total');
                          // dd($project);
                          @endphp
                   
                        
                   @if ($ids == 1 && $data->id == $project)
                      Sudah DIniliai
                      @elseif ($data->status == 2)
                      <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#nilaiModal{{ $d->id }}">
                        Beri Nilai
                      </button>
                      @else
                          @endif

                            <!-- Modal for scoring -->
                            <div class="modal fade" id="nilaiModal{{ $d->id }}" tabindex="-1" aria-labelledby="nilaiModalLabel{{ $d->id }}" aria-hidden="true">
                              <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-header">
                                          <h5 class="modal-title" id="nilaiModalLabel{{ $d->id }}">Beri Nilai untuk {{ $d->name }}</h5>
                                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                      </div>
                                      <div class="modal-body">
                                          <form action="{{route('kapro.project.nilaiUser',$d->id)}}" method="POST">
                                              @csrf
                                              <!-- Hasil Kerja (35%) -->
                                              <div class="mb-3">
                                                  <label for="hasilKerja{{ $d->id }}" class="form-label">Hasil Kerja (35%)</label>
                                                  <input type="number" name="hasil_kerja" class="form-control" id="hasilKerja{{ $d->id }}" max="100" min="0" required>
                                              </div>

                                              <!-- Kualitas Kerja (40%) -->
                                              <div class="mb-3">
                                                  <label for="kualitasKerja{{ $d->id }}" class="form-label">Kualitas Kerja (40%)</label>
                                                  <input type="number" name="kualitas_kerja" class="form-control" id="kualitasKerja{{ $d->id }}" max="100" min="0" required>
                                              </div>

                                              <!-- Kepatuhan SOP (25%) -->
                                              <div class="mb-3">
                                                  <label for="kepatuhanSOP{{ $d->id }}" class="form-label">Kepatuhan SOP (25%)</label>
                                                  <input type="number" name="kepatuhan_sop" class="form-control" id="kepatuhanSOP{{ $d->id }}" max="100" min="0" required>
                                              </div>

                                              <div class="mb-3">
                                                  <label for="kepatuhanSOP{{ $d->id }}" class="form-label">Keterangan</label>
                                                  <input type="text" name="keterangan" class="form-control" id="kepatuhanSOP{{ $d->id }}" max="100" min="0" >
                                              </div>

                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                  <button type="submit" class="btn btn-primary">Submit</button>
                                              </div>

                                              <input type="text" name="project_id" value="{{$data->id}}" hidden>
                                              <input type="text" name="user_id" value="{{$d->id}}" hidden>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                            </div>

                          @if ($data->status == 0)
                            
                            <!-- Delete button triggers modal -->
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal{{ $d->id }}">
                                Delete
                            </button>

                            @else
                            @endif
                
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
                                            <form action="{{ route('kapro.project.delete.user', $d->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        @if ($data->status == 2)
                        <td>
                          @if ($ids == 1 && $data->id == $project)
                          {{$total}}
                          @else
                            Belum diberi nilai
                          @endif
                        </td>
                        @else
                        @endif
                      </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addUserModalLabel">Add User to Project</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('kapro.project.addUser')}}">
          @csrf
          <div class="mb-3">
            <input type="text" name="project_id" value="{{$data->id}}" hidden>
            <label for="user_id" class="form-label">Select Existing User:</label>
            <select class="form-select" name="user_id" required>
              <option value="">Choose a user...</option>
              @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Add User</button>
          </div>
        </form>
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
