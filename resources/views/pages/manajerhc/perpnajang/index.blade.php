@extends('layout.pegawai.main')
@section('title')
Perpanjang Kontrak || Manajer HC
@endsection
@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-2 align-items-center">
        <div class="col">
          <div class="page-pretitle">
            Overview
          </div>
          <h2 class="page-title">
            Rekomendasi Perpanjangan Kontrak
          </h2>
        </div>
        <div class="col-auto ms-auto d-print-none">
          <div class="btn-list">
            <button class="btn btn-primary" id="sortBtn">
              <i class="fas fa-sort"></i> Urutkan Berdasarkan Nilai
            </button>
          </div>
        </div>
      </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            @php
                $users = \App\Models\User::where('active',1)->orderBy('role', 'desc')->get();
            @endphp
            @foreach($users as $index => $user)
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">#{{ $index + 1 }}</h4> <!-- Menampilkan Nomor Urut -->
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <img src="{{ asset('storage/' . $user->profile) }}" alt="profile" class="avatar me-3">
                            <div>
                                <h3 class="mb-0">{{ $user->name }}</h3>
                                <p class="text-muted mb-1">{{ $user->jabatan }}</p>
                                <p class="text-muted mb-0">Project History: {{ $user->project_count }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">Nilai: <strong>{{ $user->role }}</strong></div>
                            <a href="" class="btn btn-sm btn-outline-primary">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
