@extends('layout.pegawai.main')
@section('title')
Laporan Project || Kepala seksi kesejahteraan aparatur
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
                    Project : {{$data->judul}}
                </h2>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-body">
                <form action="{{ route('kapro.project.update.isi', $laporan->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-3">Ringkasan :</div>
                                <div class="col-md-9">
                                    <textarea name="ringkasan" class="form-control">{{ old('ringkasan', $laporan->ringkasan) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">Pencapaian :</div>
                                <div class="col-md-9">
                                    <textarea name="pencapaian" class="form-control">{{ old('pencapaian', $laporan->pencapaian) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">Hasil :</div>
                                <div class="col-md-9">
                                    <textarea name="hasil" class="form-control">{{ old('hasil', $laporan->hasil) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">Kendala :</div>
                                <div class="col-md-9">
                                    <textarea name="kendala" class="form-control">{{ old('kendala', $laporan->kendala) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="row mb-3">
                                <div class="col-md-3">Solusi :</div>
                                <div class="col-md-9">
                                    <textarea name="solusi" class="form-control">{{ old('solusi', $laporan->solusi) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">Rencana :</div>
                                <div class="col-md-9">
                                    <textarea name="rencana" class="form-control">{{ old('rencana', $laporan->rencana) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">Inisatif :</div>
                                <div class="col-md-9">
                                    <textarea name="inisiatif_tambahan" class="form-control">{{ old('inisiatif_tambahan', $laporan->inisiatif_tambahan) }}</textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">Catatan :</div>
                                <div class="col-md-9">
                                    <textarea name="catatan" class="form-control">{{ old('catatan', $laporan->catatan) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="{{route('pegawai.project')}}" class="btn btn-dark">Back</a>
                            <button type="submit" class="btn btn-primary">Update Laporan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
