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
        'kategori'    => $kategori,
        'departement' => $departement,
        'status'      => $status,
        'strategic'   => $strategic,
        'uk'          => $uk,
      ];
    @endphp

    <ul class="nav nav-tabs" id="dataMasterTab" role="tablist">
      @foreach ($tabs as $key => $items)
        <li class="nav-item" role="presentation">
          <button class="nav-link @if ($loop->first) active @endif"
                  id="{{ $key }}-tab"
                  data-bs-toggle="tab"
                  data-bs-target="#{{ $key }}"
                  type="button"
                  role="tab">
            {{ ucfirst(str_replace('uk', 'Unit Kerja ', $key)) }}
          </button>
        </li>
      @endforeach
    </ul>

    <div class="tab-content p-3" id="dataMasterTabContent">
      @foreach ($tabs as $key => $items)
        <div class="tab-pane fade @if ($loop->first) show active @endif" id="{{ $key }}" role="tabpanel">
          <div class="d-flex justify-content-end mb-3">
            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#addModal"
                    data-type="{{ $key }}">
              + Tambah {{ ucfirst(str_replace('uk', 'Unit Kerja ', $key)) }}
            </button>
          </div>

          <table class="table table-bordered table-striped">
            <thead class="table-light">
              <tr>
                <th width="5%">No</th>
                @if ($key === 'uk')
                  <th>Unit Kerja</th>
                  <th>Kode Unit Kerja</th>
                @else
                  <th>Nama</th>
                @endif
                <th width="20%">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse ($items as $item)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  @if ($key === 'uk')
                    <td>{{ $item->unit_kerja }}</td>
                    <td>{{ $item->kode_unit_kerja }}</td>
                  @else
                    <td>{{ $item->$key }}</td>
                  @endif
                  <td>
                    <!-- Button Edit -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal-{{ $key }}-{{ $item->id }}">Edit</button>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal-{{ $key }}-{{ $item->id }}" tabindex="-1">
                      <div class="modal-dialog">
                        <form class="modal-content" method="POST" action="{{ route('hc.k-data-master.edit', $item->id) }}">
                          @csrf @method('PUT')
                          <input type="hidden" name="tipe" value="{{ $key }}">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit {{ ucfirst(str_replace('_',' ',$key)) }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            @if ($key === 'uk')
                              <div class="mb-3">
                                <label class="form-label">Unit Kerja</label>
                                <input type="text" name="unit_kerja" class="form-control" value="{{ $item->unit_kerja }}" required>
                              </div>
                              <div class="mb-3">
                                <label class="form-label">Kode Unit Kerja</label>
                                <input type="text" name="kode_unit_kerja" class="form-control" value="{{ $item->kode_unit_kerja }}" required>
                              </div>
                            @else
                              <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="{{ $key }}" class="form-control" value="{{ $item->$key }}" required>
                              </div>
                            @endif
                          </div>
                          <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                          </div>
                        </form>
                      </div>
                    </div>

                    <!-- Button Delete -->
                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $key }}-{{ $item->id }}">Hapus</button>

                    <!-- Modal Delete -->
                    <div class="modal fade" id="deleteModal-{{ $key }}-{{ $item->id }}" tabindex="-1">
                      <div class="modal-dialog">
                        <form class="modal-content" method="POST" action="{{ route('hc.k-data-master.delete', $item->id) }}">
                          @csrf @method('DELETE')
                          <input type="hidden" name="tipe" value="{{ $key }}">
                          <div class="modal-header">
                            <h5 class="modal-title">Konfirmasi Hapus</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                          </div>
                          <div class="modal-body">
                            Apakah Anda yakin ingin menghapus <strong>{{ $key === 'uk' ? $item->unit_kerja : $item->$key }}</strong>?
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
                  <td colspan="{{ $key === 'uk' ? 4 : 3 }}" class="text-center">Data belum tersedia.</td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      @endforeach
    </div>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="addModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="addForm" class="modal-content" method="POST">
      @csrf
      <div class="modal-header">
        <h5 class="modal-title">Tambah Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div id="defaultInputGroup">
          <div class="mb-3">
            <label id="addLabel" class="form-label">Nama</label>
            <input type="text" name="value" class="form-control" >
          </div>
        </div>
        <div id="unitKerjaGroup" style="display: none;">
          <div class="mb-3">
            <label class="form-label">Unit Kerja</label>
            <input type="text" name="unit_kerja" class="form-control" >
          </div>
          <div class="mb-3">
            <label class="form-label">Kode Unit Kerja</label>
            <input type="text" name="kode_unit_kerja" class="form-control" >
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const addModal = document.getElementById('addModal');
    const form = document.getElementById('addForm');
    const label = document.getElementById('addLabel');
    const defaultGroup = document.getElementById('defaultInputGroup');
    const unitGroup = document.getElementById('unitKerjaGroup');

    addModal.addEventListener('show.bs.modal', event => {
      const type = event.relatedTarget.dataset.type;
      form.reset();
      form.action = `/hc/k-data-master/${type}/store`;

      if (type === 'uk') {
        defaultGroup.style.display = 'none';
        unitGroup.style.display = 'block';
      } else {
        unitGroup.style.display = 'none';
        defaultGroup.style.display = 'block';
        label.textContent = `Nama ${type.replace('_', ' ').replace(/\b\w/g, l => l.toUpperCase())}`;
      }
    });
  });
</script>

@endsection
