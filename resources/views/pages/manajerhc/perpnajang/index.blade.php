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
                                    <th>Action</th>
                                    <th>Status</th>
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
                                        <td>
                                            @php
                                                $kontrak = \App\Models\KontrakM::where('user_id', $item['user']->id)->value('id');
                                                $kontrak_value = \App\Models\KontrakM::find($kontrak);
                                                $today = \Carbon\Carbon::now();
                                                $endDate = \Carbon\Carbon::parse($kontrak_value->akhir_kontrak);
                                                $remainingDays = ceil($endDate->diffInDays($today, false)); // Round up to the nearest whole number
                                                // dd($remainingDays);
                                            @endphp
                                            @if ($remainingDays < 0)
                                            Masih dalam Kontrak
                                            @else
                                            <a href="javascript:void(0)" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#perpanjangModal-{{ $item['user']->id  }}">
                                                <i class=""></i> Update Status
                                              </a>
                            
                                              <!-- Modal Structure -->
                                              <div class="modal fade" id="perpanjangModal-{{ $item['user']->id  }}" tabindex="-1" aria-labelledby="perpanjangModalLabel-{{ $item['user']->id  }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="perpanjangModalLabel-{{ $item['user']->id  }}">Perpanjang User</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        
                                                          <form action="{{ route('manajerhc.perpanjang.post', $kontrak ) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <!-- Select Status -->
                                                                <div class="mb-3">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select name="status" id="status" class="form-control" required>
                                                                        <option value="" selected disabled>--Pilih Status--</option>
                                                                        <option value="Diperpanjang">Diperpanjang</option>
                                                                        <option value="Tidak Diperpanjang">Tidak Diperpanjang</option>
                                                                    </select>
                                                                </div>

                                                                <!-- Start Date (Hidden unless 'Diperpanjang') -->
                                                                <div class="mb-3 tanggal-group" style="display: none;">
                                                                    <label for="startDate" class="form-label">Start Date</label>
                                                                    <input type="date" name="start_date" id="startDate" class="form-control" value="{{ \Carbon\Carbon::now()->toDateString() }}">
                                                                </div>

                                                                <!-- End Date (Hidden unless 'Diperpanjang') -->
                                                                <div class="mb-3 tanggal-group" style="display: none;">
                                                                    <label for="endDate" class="form-label">End Date</label>
                                                                    <input type="date" name="end_date" id="endDate" class="form-control">
                                                                </div>
                                                            </div>

                                                            {{-- Tambahkan script di bawah sebelum </body> atau di @section('scripts') --}}
                                                            <script>
                                                                document.addEventListener('DOMContentLoaded', function () {
                                                                    const statusSelect = document.getElementById('status');
                                                                    const dateFields = document.querySelectorAll('.tanggal-group');

                                                                    statusSelect.addEventListener('change', function () {
                                                                        if (this.value === 'Diperpanjang') {
                                                                            dateFields.forEach(field => field.style.display = 'block');
                                                                        } else {
                                                                            dateFields.forEach(field => field.style.display = 'none');
                                                                        }
                                                                    });
                                                                });
                                                            </script>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                <button type="submit" class="btn btn-success">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                              </div>
                                            @endif
                                        </td>
                                        @php
                                            $status = $kontrak_value->status ?? 'Belum Diperpanjang';
                                            $textClass = $status === 'Diperpanjang' ? 'success' : 'danger';
                                        @endphp

                                        <td class="text text-{{ $textClass }}">{{ $status }}</td>
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
