@extends('layout.pegawai.main')
@section('title')
Kelola User || Human Capital
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
          Kelola User
        </h2>
      </div>
      <div class="col-auto ms-auto d-print-none d-flex align-items-center position-relative">
        <!-- Search Form -->
        <form action="{{ route('hc.kelola-user') }}" method="GET" class="d-flex justify-content-center mb-0 position-relative">
            <input type="text" id="searchInput" name="search" class="form-control w-100" 
                   placeholder="Search users..." value="{{ request()->query('search') }}">
            
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
            Tambahkan User Baru
        </a>
    </div>
    
    <script>
        document.getElementById('clearSearch').addEventListener('click', function() {
            document.getElementById('searchInput').value = ''; // Clear the input value
            window.location.href = "{{ route('hc.kelola-user') }}"; // Redirect to the base route
        });
    </script>
      </div>
     
    </div>
  </div>
</div>
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
                    <th>User</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($data as $d)
                    
                  <tr>
                    
                    <td>{{$loop->iteration}}</td>
                    <td class="w-1">
                      <span class="avatar avatar-sm" style="background-image: url({{ asset('storage/' . $d->profile) }})"></span>
                    </td>
                    <td class="td-truncate">
                      <div class="text-truncate">
                        {{$d->name}}
                      </div>
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
                      <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-report-edit-{{ $d->id }}">Edit</a>
                      @if ($d->active == 0)
                      <a href="{{route('hc.kelola-user.active',$d->id)}}"><i class="btn btn-warning" >Non Active</i></a>
                      @elseif ($d->active == 1)
                      <a href="{{route('hc.kelola-user.nonactive',$d->id)}}"><i class="btn btn-success">Active</i></a>
                      @endif
                      
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
                                        <form action="{{ route('hc.kelola-user.delete', $d->id) }}" method="POST">
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
                    {{-- //modal --}}
                    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">New user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="{{route('hc.kelola-user.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                              <div class="mb-3">
                                <label class="form-label">No Pegawai</label>
                                <input type="text" class="form-control" name="no_pegawai" value="{{$newNoPegawai}}" placeholder="Your name" readonly>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Your name" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Your Username" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Your email name" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="text" class="form-control" name="posisi" placeholder="Your posisi name" required>
                                @error('posisi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Your password" required>
                                <span>at least 6 char</span>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Confirmation Field -->
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required>
                            </div>
                              <label class="form-label">User type</label>
                              <div class="form-selectgroup-boxes row mb-3">
                                <div class="col-lg-4">
                                  <label class="form-selectgroup-item mb-2">
                                    <input type="radio" name="role" value="0" class="form-selectgroup-input" required >
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Human Capital</span>
                                      </span>
                                    </span>
                                  </label>
                                  <label class="form-selectgroup-item">
                                    <input type="radio" name="role" value="1" class="form-selectgroup-input" required>
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Pegawai</span>
                                      </span>
                                    </span>
                                  </label>
                                </div>

                                <div class="col-lg-4">
                                  <label class="form-selectgroup-item">
                                    <input type="radio" name="role" value="4" class="form-selectgroup-input" required>
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Pusat</span>
                                      </span>
                                    </span>
                                  </label>
                                </div>

                                <div class="col-lg-4">
                                  <label class="form-selectgroup-item mb-2">
                                    <input type="radio" name="role" value="2" class="form-selectgroup-input" required>
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Ketua Project</span>
                                      </span>
                                    </span>
                                  </label>
                                  <label class="form-selectgroup-item">
                                    <input type="radio" name="role" value="3" class="form-selectgroup-input" required>
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Manajer HC</span>
                                      </span>
                                    </span>
                                  </label>
                                </div>

                              </div>
                              <div class="row">
                                <div class="col-lg-8">
                                  <div class="mb-3">
                                    <label class="form-label">Avatar</label>
                                    <div class="input-group input-group-flat">
                                      <span class="input-group-text">
                                      </span>
                                      <input type="file" class="form-control ps-0" name="avatar"  value="report-01" autocomplete="off">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                      <option value="" selected disabled>-- Pilih Status User -- </option>
                                      <option name="status" value="1">Active</option>
                                      <option name="status" value="0">Non Active</option>
                                    </select>
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
                                Create new User
                              </button>
                            </div>
                                  
                        </form>
                        </div>
                      </div>
                    </div>

                    <!-- Modal for Editing User -->
                    <div class="modal modal-blur fade" id="modal-report-edit-{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="{{ route('hc.kelola-user.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                              <!-- Name Field -->
                              <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $d->name }}" placeholder="Your name" required>
                              </div>

                              <!-- Username Field -->
                              <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ $d->username }}" placeholder="Your Username" required>
                              </div>

                              <!-- Email Field -->
                              <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $d->email }}" placeholder="Your email" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">posisi</label>
                                <input type="text" class="form-control" name="posisi" value="{{ $d->posisi }}" placeholder="Your posisi" required>
                              </div>

                              <!-- New Password Field -->
                              <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Your new password">
                                <span>At least 6 characters</span>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>

                              <!-- Password Confirmation Field -->
                              <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>

                              <!-- Avatar Field with Preview -->
                              <div class="row">
                                <div class="col-lg-8">
                                  <div class="mb-3">
                                    <label class="form-label">Avatar</label>
                                    <input type="file" class="form-control" name="avatar" id="avatarInput-{{ $d->id }}" accept="image/*" onchange="previewAvatar(event, '{{ $d->id }}')">
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <label class="form-label">Avatar Preview</label>
                                  <img id="avatarPreview-{{ $d->id }}" src="{{ $d->profile ? asset('storage/' . $d->profile) : 'default-avatar.png' }}" alt="Avatar Preview" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                              </div>
                            </div>

                            <div class="modal-footer">
                              <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                              <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <script>
                      function previewAvatar(event, id) {
                        const input = event.target;
                        const preview = document.getElementById('avatarPreview-' + id);

                        if (input.files && input.files[0]) {
                          const reader = new FileReader();
                          reader.onload = function (e) {
                            preview.src = e.target.result;  // Set the preview image to the selected file
                          };
                          reader.readAsDataURL(input.files[0]);  // Read the selected file as a data URL
                        }
                      }
                    </script>
                    @endforeach
                  
                </tbody>
              </table>

              @else
              <table class="table table-vcenter">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>User</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($hasil as $d)
                    
                  <tr>
                    
                    <td>{{$loop->iteration}}</td>
                    <td class="w-1">
                      <span class="avatar avatar-sm" style="background-image: url({{ asset('storage/' . $d->profile) }})"></span>
                    </td>
                    <td class="td-truncate">
                      <div class="text-truncate">
                        {{$d->name}}
                      </div>
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
                      <a href="" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-report-edit-{{ $d->id }}">Edit</a>
                      @if ($d->active == 0)
                      <a href="{{route('hc.kelola-user.active',$d->id)}}"><i class="btn btn-warning" >Non Active</i></a>
                      @elseif ($d->active == 1)
                      <a href="{{route('hc.kelola-user.nonactive',$d->id)}}"><i class="btn btn-success">Active</i></a>
                      @endif
                      
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
                                        <form action="{{ route('hc.kelola-user.delete', $d->id) }}" method="POST">
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
                    {{-- //modal --}}
                    <div class="modal modal-blur fade" id="modal-report" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">New user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="{{route('hc.kelola-user.store')}}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                              <div class="mb-3">
                                <label class="form-label">No Pegawai</label>
                                <input type="text" class="form-control" name="no_pegawai" value="{{$newNoPegawai}}" placeholder="Your name" readonly>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" placeholder="Your name" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" placeholder="Your Username" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" placeholder="Your email name" required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="text" class="form-control" name="posisi" placeholder="Your posisi name" required>
                                @error('posisi')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Your password" required>
                                <span>at least 6 char</span>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Password Confirmation Field -->
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password" required>
                            </div>
                              <label class="form-label">User type</label>
                              <div class="form-selectgroup-boxes row mb-3">
                                <div class="col-lg-4">
                                  <label class="form-selectgroup-item mb-2">
                                    <input type="radio" name="role" value="0" class="form-selectgroup-input" required >
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Human Capital</span>
                                      </span>
                                    </span>
                                  </label>
                                  <label class="form-selectgroup-item">
                                    <input type="radio" name="role" value="1" class="form-selectgroup-input" required>
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Pegawai</span>
                                      </span>
                                    </span>
                                  </label>
                                </div>

                                <div class="col-lg-4">
                                  <label class="form-selectgroup-item">
                                    <input type="radio" name="role" value="4" class="form-selectgroup-input" required>
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Pusat</span>
                                      </span>
                                    </span>
                                  </label>
                                </div>

                                <div class="col-lg-4">
                                  <label class="form-selectgroup-item mb-2">
                                    <input type="radio" name="role" value="2" class="form-selectgroup-input" required>
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Ketua Project</span>
                                      </span>
                                    </span>
                                  </label>
                                  <label class="form-selectgroup-item">
                                    <input type="radio" name="role" value="3" class="form-selectgroup-input" required>
                                    <span class="form-selectgroup-label d-flex align-items-center p-3">
                                      <span class="me-3">
                                        <span class="form-selectgroup-check"></span>
                                      </span>
                                      <span class="form-selectgroup-label-content">
                                        <span class="form-selectgroup-title strong mb-1">Manajer HC</span>
                                      </span>
                                    </span>
                                  </label>
                                </div>

                              </div>
                              <div class="row">
                                <div class="col-lg-8">
                                  <div class="mb-3">
                                    <label class="form-label">Avatar</label>
                                    <div class="input-group input-group-flat">
                                      <span class="input-group-text">
                                      </span>
                                      <input type="file" class="form-control ps-0" name="avatar"  value="report-01" autocomplete="off">
                                    </div>
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <div class="mb-3">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select">
                                      <option value="" selected disabled>-- Pilih Status User -- </option>
                                      <option name="status" value="1">Active</option>
                                      <option name="status" value="0">Non Active</option>
                                    </select>
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
                                Create new User
                              </button>
                            </div>
                                  
                        </form>
                        </div>
                      </div>
                    </div>

                    <!-- Modal for Editing User -->
                    <div class="modal modal-blur fade" id="modal-report-edit-{{ $d->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit user</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                          </div>
                          <form action="{{ route('hc.kelola-user.update', $d->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                              <!-- Name Field -->
                              <div class="mb-3">
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" name="name" value="{{ $d->name }}" placeholder="Your name" required>
                              </div>

                              <!-- Username Field -->
                              <div class="mb-3">
                                <label class="form-label">Username</label>
                                <input type="text" class="form-control" name="username" value="{{ $d->username }}" placeholder="Your Username" required>
                              </div>

                              <!-- Email Field -->
                              <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" name="email" value="{{ $d->email }}" placeholder="Your email" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Posisi</label>
                                <input type="text" class="form-control" name="posisi" value="{{ $d->posisi }}" placeholder="Your posisi" required>
                              </div>

                              <!-- New Password Field -->
                              <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" class="form-control" name="password" placeholder="Your new password">
                                <span>At least 6 characters</span>
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>

                              <!-- Password Confirmation Field -->
                              <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <input type="password" class="form-control" name="password_confirmation" placeholder="Confirm your password">
                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                              </div>

                              <!-- Avatar Field with Preview -->
                              <div class="row">
                                <div class="col-lg-8">
                                  <div class="mb-3">
                                    <label class="form-label">Avatar</label>
                                    <input type="file" class="form-control" name="avatar" id="avatarInput-{{ $d->id }}" accept="image/*" onchange="previewAvatar(event, '{{ $d->id }}')">
                                  </div>
                                </div>
                                <div class="col-lg-4">
                                  <label class="form-label">Avatar Preview</label>
                                  <img id="avatarPreview-{{ $d->id }}" src="{{ $d->profile ? asset('storage/' . $d->profile) : 'default-avatar.png' }}" alt="Avatar Preview" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                              </div>
                            </div>

                            <div class="modal-footer">
                              <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Cancel</a>
                              <button type="submit" class="btn btn-primary">Update User</button>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>

                    <script>
                      function previewAvatar(event, id) {
                        const input = event.target;
                        const preview = document.getElementById('avatarPreview-' + id);

                        if (input.files && input.files[0]) {
                          const reader = new FileReader();
                          reader.onload = function (e) {
                            preview.src = e.target.result;  // Set the preview image to the selected file
                          };
                          reader.readAsDataURL(input.files[0]);  // Read the selected file as a data URL
                        }
                      }
                    </script>
                    @endforeach
                  
                </tbody>
              </table>
              @endif

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
                  <div class="subheader">Total User</div>   
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
                  <div class="subheader">Total Pegawai</div>   
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
                  <div class="subheader">Total Human Capital</div>   
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
                  <div class="subheader">Total Kepala Project</div>   
                </div>
                <div class="h1 mt-2">{{$counthc}}</div>
                
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="subheader">Total Manajer HC</div>   
                </div>
                <div class="h1 mt-2">{{$countmhc}}</div>
                
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <div class="d-flex align-items-center">
                  <div class="subheader">Total Pusat</div>   
                </div>
                <div class="h1 mt-2">{{$countpusat}}</div>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





@endsection