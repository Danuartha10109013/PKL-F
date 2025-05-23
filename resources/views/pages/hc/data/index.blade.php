@extends('layout.pegawai.main')

@section('title')
Kelola Data Master || Human Capital
@endsection

@section('content')
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <div class="page-pretitle">Overview</div>
        <h2 class="page-title">Kelola Data Master</h2>
      </div>
    </div>
  </div>
</div>

<div class="container mt-3">
  <div class="card">
    @php
      $tabs = [
        'kategori' => $kategori,
        'departement' => $departement,
        'status' => $status,
        'strategic' => $strategic,
      ];
    @endphp

    <ul class="nav nav-tabs" id="dataMasterTab" role="tablist">
      @foreach ($tabs as $key => $items)
      <li class="nav-item" role="presentation">
        <button class="nav-link @if ($loop->first) active @endif" id="{{ $key }}-tab" data-bs-toggle="tab" data-bs-target="#{{ $key }}" type="button" role="tab">
          {{ ucfirst($key) }}
        </button>
      </li>
      @endforeach
    </ul>

    <div class="tab-content p-3" id="dataMasterTabContent">
      @foreach ($tabs as $key => $items)
      <div class="tab-pane fade @if ($loop->first) show active @endif" id="{{ $key }}" role="tabpanel">
        <div class="d-flex justify-content-end mb-3">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal" data-type="{{ $key }}">
            + Tambah {{ ucfirst($key) }}
          </button>
        </div>

        <table class="table table-bordered table-striped">
          <thead class="table-light">
            <tr>
              <th width="5%">No</th>
              <th>Nama</th>
              <th width="20%">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($items as $item)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $item->$key }}</td>
              <td>
                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal-{{ $key }}-{{ $item->id }}">
                Edit
                </button>
                <div class="modal fade" id="editModal-{{ $key }}-{{ $item->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $key }}-{{ $item->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <form class="modal-content" action="{{ route('hc.k-data-master.edit', $item->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="tipe" value="{{ $key }}">
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel-{{ $key }}-{{ $item->id }}">Edit {{ ucfirst($key) }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        
                        <div class="modal-body">
                            <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" name="{{ $key }}" class="form-control" value="{{ $item->$key }}" required>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                        </form>
                    </div>
                    </div>

                <!-- Delete Button triggers modal -->
                <button type="button" class="btn btn-danger " data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $key }}-{{ $item->id }}">
                Hapus
                </button>
                <!-- Delete Confirmation Modal -->
                <div class="modal fade" id="deleteModal-{{ $key }}-{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $key }}-{{ $item->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('hc.k-data-master.delete', $item->id) }}" method="POST" class="modal-content">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="tipe" value="{{ $key }}">

                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel-{{ $key }}-{{ $item->id }}">Konfirmasi Hapus</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        Apakah Anda yakin ingin menghapus <strong>{{ $item->$key }}</strong>?
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </div>
                    </form>
                </div>
                </div>


              </td>
            </tr>

           
            @empty
            <tr>
              <td colspan="3" class="text-center">Data belum tersedia.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Add Modal -->
<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="modal-content" method="POST" id="addForm">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title" id="addModalLabel">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label id="addLabel" class="form-label">Nama</label>
          <input type="text" name="value" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  const addModal = document.getElementById('addModal');
  addModal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const type = button.getAttribute('data-type');
    const form = document.getElementById('addForm');
    const label = document.getElementById('addLabel');

    label.innerText = `Nama ${type.charAt(0).toUpperCase() + type.slice(1)}`;
    form.action = `/hc/k-data-master/${type}/store`;
  });
</script>
<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

@endsection
