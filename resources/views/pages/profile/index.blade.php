@extends('layout.pegawai.main')
@section('title')
Dashboard || Pegawai
@endsection
@section('content')
<div class="page-wrapper">
    <!-- Page header -->
    <div class="page-header d-print-none">
      <div class="container-xl">
        <div class="row g-2 align-items-center">
          <div class="col">
            <h2 class="page-title">
              Account Settings
            </h2>
          </div>
        </div>
      </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
      <div class="container-xl">
        <div class="card">
          <div class="row g-0">
            <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
              @csrf
              @method('PUT')
            <div class="col-12 col-md-12 d-flex flex-column">
              <div class="card-body">
                <h2 class="mb-4">My Account</h2>
                
                <!-- Flash message for success -->
                @if(session('success'))
                  <div class="alert alert-success">
                      {{ session('success') }}
                  </div>
                @endif
                
                <!-- Flash message for errors -->
                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
                @endif
                
                <h3 class="card-title">Profile Details</h3>
                <div class="row align-items-center">
                  <div class="col-auto">
                    <!-- Preview Avatar -->
                    <span class="avatar avatar-xl" id="avatar-preview" style="background-image: url('{{ asset('storage/' . $data->profile) }}')"></span>
                  </div>
                
                  <div class="col-auto">
                    <style>
                      .custom-file-input {
                          display: none;
                      }
                      .custom-button {
                          display: inline-block;
                          padding: 8px 15px;
                          color: black;
                          border-radius: 4px;
                          cursor: pointer;
                      }
                    </style>
                    <label class="custom-button" for="profile">Change Avatar</label>
                    <input type="file" id="profile" name="profile" class="custom-file-input" onchange="previewImage(event)">
                  </div>
                </div>
                
                <h3 class="card-title mt-4">Personal Details</h3>
                <div class="row g-3">
                  <div class="col-md">
                    <div class="form-label">Full Name</div>
                    <input type="text" class="form-control" name="name" value="{{$data->name}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">No KTP</div>
                    <input type="text" class="form-control" name="no_ktp" value="{{$data->no_ktp}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Nomor Pegawai</div>
                    <input type="text" class="form-control" value="{{$data->no_pegawai}}" readonly>
                  </div>
                  <div class="col-md">
                    <div class="form-label">Role</div>
                    <input type="text" class="form-control" value="{{ $data->role == 0 ? 'Admin' : ($data->role == 1 ? 'Pegawai' : 'Manager') }}" readonly>
                  </div>
                  <div class="col-md">
                    <div class="form-label">Posisi</div>
                    <input type="text" class="form-control" name="posisi" value="{{$data->posisi}}">
                  </div>
                  
                </div>

                <h3 class="card-title mt-4">Birth Details</h3>
                <div class="row g-3">
                  <div class="col-md">
                    <div class="form-label">Gender</div>
                    <input type="text" class="form-control" name="gender" value="{{$data->gender}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Tempat Lahir</div>
                    <input type="text" class="form-control" name="tempat_lahir" value="{{$data->tempat_lahir}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Tanggal Lahir</div>
                    <input type="date" class="form-control" name="tanggal_lahir" value="{{$data->tanggal_lahir}}">
                  </div>
                </div>

                <h3 class="card-title mt-4">Contact Details</h3>
                <div class="row g-3">
                  <div class="col-md">
                    <div class="form-label">Phone</div>
                    <input type="text" class="form-control" name="phone" value="{{$data->phone}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Personal Number</div>
                    <input type="text" class="form-control" name="personel_number" value="{{$data->personel_number}}">
                  </div>
                  
                </div>

                <h3 class="card-title mt-4">Address Details</h3>
                <div class="row g-3">
                  <div class="col-md">
                    <div class="form-label">Alamat</div>
                    <input type="text" class="form-control" name="alamat" value="{{$data->alamat}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">RT</div>
                    <input type="text" class="form-control" name="rt" value="{{$data->rt}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">RW</div>
                    <input type="text" class="form-control" name="rw" value="{{$data->rw}}">
                  </div>
                </div>

                <div class="row g-3 mt-3">
                  <div class="col-md">
                    <div class="form-label">Kelurahan</div>
                    <input type="text" class="form-control" name="kelurahan" value="{{$data->kelurahan}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Kecamatan</div>
                    <input type="text" class="form-control" name="kecamatan" value="{{$data->kecamatan}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Kota</div>
                    <input type="text" class="form-control" name="kota" value="{{$data->kota}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Provinsi</div>
                    <input type="text" class="form-control" name="provinsi" value="{{$data->provinsi}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Kode Pos</div>
                    <input type="text" class="form-control" name="kode_pos" value="{{$data->kode_pos}}">
                  </div>
                </div>

                <h3 class="card-title mt-4">Assurance Details</h3>
                <div class="row g-3">
                  <div class="col-md">
                    <div class="form-label">No BPJS</div>
                    <input type="text" class="form-control" name="no_bpjs" value="{{$data->no_bpjs}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">No BPJSTK</div>
                    <input type="text" class="form-control" name="no_bpjstk" value="{{$data->no_bpjstk}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Lokasi BPJS</div>
                    <input type="text" class="form-control" name="lokasi_bpjs" value="{{$data->lokasi_bpjs}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Terdaftar BPJSTK</div>
                    <input type="text" class="form-control" name="terdaftar_bpjstk" value="{{$data->terdaftar_bpjstk}}">
                  </div>
                </div>

                <h3 class="card-title mt-4">Other Details</h3>
                <div class="row g-3">
                  <div class="col-md">
                    <div class="form-label">Agama</div>
                    <input type="text" class="form-control" name="agama" value="{{$data->agama}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Status Kawin</div>
                    <input type="text" class="form-control" name="kawin" value="{{$data->kawin}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Tanggungan</div>
                    <input type="text" class="form-control" name="tanggungan" value="{{$data->tanggungan}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">NPWP</div>
                    <input type="text" class="form-control" name="npwp" value="{{$data->npwp}}">
                  </div>
                </div>

                <h3 class="card-title mt-4">Email</h3>
                <p class="card-subtitle">This contact will be shown to others publicly, so choose it carefully.</p>
                <div>
                  <div class="row g-2">
                    <div class="col-auto">
                      <input type="text" class="form-control w-auto" name="email" value="{{$data->email}}">
                    </div>
                  </div>
                </div>
                
                <h3 class="card-title mt-4">Username</h3>
                <p class="card-subtitle">This is your username for login</p>
                <div>
                  <div class="row g-2">
                    <div class="col-auto">
                      <input type="text" class="form-control w-auto" name="username" value="{{$data->username}}">
                    </div>
                  </div>
                </div>

                <h3 class="card-title mt-4">Password</h3>
                <div>
                  <input class="form-control" type="password" name="password" placeholder="New Password here ..">
                </div>

                <input type="hidden" value="{{$data->id}}" name="user_id">
              </div>
              <div class="card-footer bg-primary">
                <div class="d-flex">
                  <a href="#" class="btn btn-link link-light">Cancel</a>
                  <button type="submit" class="btn btn-light ms-auto">Save</button>
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
</div>

<!-- Script to handle image preview -->
<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function(){
      const output = document.getElementById('avatar-preview');
      output.style.backgroundImage = 'url(' + reader.result + ')';
    };
    reader.readAsDataURL(event.target.files[0]);
  }
</script>
@endsection
