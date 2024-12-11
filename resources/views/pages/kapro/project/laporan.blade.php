@extends('layout.pegawai.main')
@section('title')
Laporan Pegawai || Kepala seksi kesejahteraan aparatur
@endsection
@section('content')
    <!-- Page body -->
<div class="page-body">
    <div class="container-xl">
      <div class="row row-cards">
        <div class="col-md-12">
          <div class="card">
            <div class="card-body">
                @php
                    $name = \App\Models\User::where('id',$laporan->user_id)->value('name');
                    $profile = \App\Models\User::where('id',$laporan->user_id)->value('profile');
                    // dd($name);
                    $project = \App\Models\ProjectM::where('id',$laporan->project_id)->value('judul');
                @endphp
                <h3 class="mb-4">Laporan {{$name}}  &nbsp;
                    <img src="{{asset('storage/'.$profile)}}" width="5%" alt="{{$profile}}">
                </h3>
                <h4 class="mb-4">Project : {{$project}} </h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <p>
                        <div class="row">
                            <div class="col-md-3">Ringkasan :</div>
                            <div class="col-md-9">{{$laporan->ringkasan}}</div>
                        </div>
                        <br> </p>
                        <p>
                        <div class="row">
                            <div class="col-md-3">Pencapaian : </div>
                            <div class="col-md-9">{{$laporan->pencapaian}}</div>
                        </div>
                       <br> </p>
                       <p>
                        <div class="row">
                            <div class="col-md-3">Hasil : </div>
                            <div class="col-md-9">{{$laporan->hasil}}</div>
                        </div>
                         <br> </p>
                         <p>
                        <div class="row">
                            <div class="col-md-3">Kendala : </div>
                            <div class="col-md-9">{{$laporan->kendala}}</div>
                        </div>
                        <br> </p>
                    </div>
                    <div class="col-md-6">
                        <p> 
                        <div class="row">
                            <div class="col-md-3">Solusi : </div>
                            <div class="col-md-9"> {{$laporan->solusi}}</div>
                        </div>
                        <br></p>
                        <p>
                        <div class="row">
                            <div class="col-md-3">Rencana : </div>
                            <div class="col-md-9">{{$laporan->rencana}}</div>
                        </div>
                        <br> </p>
                        <p>
                        <div class="row">
                            <div class="col-md-3">Inisatif : </div>
                            <div class="col-md-9">{{$laporan->inisiatif_tambahan}}</div>
                        </div>
                        <br> </p>
                        <p>
                        <div class="row">
                            <div class="col-md-3">Catatan : </div>
                            <div class="col-md-9">{{$laporan->catatan}}</div>
                        </div>
                       <br> </p>
                    </div>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection