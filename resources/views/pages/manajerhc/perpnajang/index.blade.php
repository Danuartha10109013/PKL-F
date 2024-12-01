@extends('layout.pegawai.main')

@section('title', 'Perpanjang Kontrak || Manajer HC')

@section('content')
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <div class="page-pretitle">Overview</div>
                <h2 class="page-title">Rekomendasi Perpanjangan Kontrak</h2>
            </div>
        </div>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
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
                                    <th>Total Nilai</th>
                                    <th>Periode Kontrak</th>
                                    <th>Riwayat Proyek</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $index => $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td> <!-- Display the ranking -->
                                        <td>
                                            <img src="{{ asset('storage/'.$item['user']->profile) }}" alt="Avatar" class="rounded-circle" width="40" height="40">
                                            {{ $item['user']->name }}
                                        </td>
                                        <td>{{ number_format($item['total'], 2) }}</td>
                                        <td>{{ $item['periode'] }}</td>
                                        <td>
                                            <ul class="list-unstyled">
                                                @foreach ($item['projects'] as $project)
                                                    <li>{{ $project }}</li>
                                                @endforeach
                                            </ul>
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
@endsection
