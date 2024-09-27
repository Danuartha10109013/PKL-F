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
                    <span class="avatar avatar-xl" style="background-image: url('{{ asset('storage/' . $data->profile) }}')"></span>
                </div>
                
                  <div class="col-auto"><a href="#" class="btn">
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
                    <input type="file" id="profile" name="profile" class="custom-file-input">
                  </div>
                  <div class="col-auto"><a href="#" class="btn btn-ghost-danger">
                      Delete avatar
                    </a></div>
                </div>
                
                <h3 class="card-title mt-4">My Profile</h3>
                <div class="row g-3">
                  <div class="col-md">
                    <div class="form-label">Full Name</div>
                    <input type="text" class="form-control" name="name" value="{{$data->name}}">
                  </div>
                  <div class="col-md">
                    <div class="form-label">Nomor Pegawai</div>
                    <input type="text" class="form-control" value="{{$data->no_pegawai}}" readonly>
                  </div>
                  <div class="col-md">
                    <div class="form-label">Role</div>
                    <input type="text" class="form-control"
                      value="{{ $data->role == 0 ? 'Admin' : ($data->role == 1 ? 'Pegawai' : 'Manager') }}" readonly>
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
                  <input class="form-control" type="text" name="password" placeholder="New Password here ..">
                </div>
                
                <input type="text" value="{{$data->id}}" name="user_id" hidden>
                
              </div>
              <div class="card-footer bg-transparent mt-auto">
                <div class="btn-list justify-content-end">
                  <a href="{{route('pegawai.dashboard')}}" class="btn">
                    Cancel
                  </a>
                  <button type="submit" class="btn btn-primary">
                    Submit
                  </button>
                </div>
              </div>
            </div>
          </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
