@extends('layout.pegawai.main')

@section('title', 'History Perpanjangan Kontrak || Manajer HC')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">History Perpanjangan Kontrak</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- Add a table to display rankings and other user data -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Nama</th>
                                            <th>Total Perpanjangan</th>
                                            <th>Tanggal Diperpanjang</th>
                                            <th>Perpanjangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $index => $item)
                                            <tr>
                                                @php
                                                    $user = \App\Models\User::find($item->user_id);
                                                @endphp
                                                <td>{{ $loop->iteration }}</td> <!-- Display the ranking -->
                                                <td>
                                                    <img src="{{ asset('storage/'.$user->profile) }}" alt="Avatar" class="rounded-circle" width="40" height="40">
                                                    {{ $user->name }}
                                                </td>
                                                <td>{{ $item->jumlah_perpanjangan }}</td>
                                                <td>{{ $item->tanggal_perpanjangan }}</td>
                                                <td>
                                                    {{ $item->awal }} s/d {{ $item->akhir }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection