@extends('layout.pegawai.main')
@section('title')
Kelola Kontrak || Human Capital
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
          Detail Kontrak
        </h2>
      </div>
      <div class="col text-end">
        @if (Auth::user()->role == 0)
        <a href="{{route('hc.kelola-kontrak.print',$data->id)}}" class="btn btn-warning"><i class="ti ti-printer"></i></a>
        @elseif (Auth::user()->role == 3)
        <a href="{{route('manajerhc.kontrak.print',$data->id)}}" class="btn btn-warning"><i class="ti ti-printer"></i></a>
        @endif
      </div>
      <div class="card">
        <div class="container mt-3">
            <img src="{{asset('logo_wika.png')}}" width="10%" alt="">
            <center>
                <h1 class="fw-bolder" style="font-size: 24px">PT WIJAYA KARYA (PERSERO)TBK</h1>
                <p class="fw-bold" style="font-size: 18px">Jl. DI. Panjaitan No.Kav. 9-10, RT.1/RW.11, Cipinang Cempedak, Kecamatan Jatinegara, Kota Jakarta Timur,<br>
                    Daerah Khusus Ibukota Jakarta 13340</p>
                <hr style="outline: 5px black">
                <h2>DETAIL KONTRAK</h2>
            </center>
            <div class="container">
              <p>Nomor : {{$data->id}}/KONTRAK/WIKA/{{$data->created_at->format('Y')}}</p>

            <h3>
              PIHAK PERTAMA
            </h3>
            <p>
              Nama Perusahaan : PT WIJAYA KARYA PERSERO TBK <br>
              Alamat : Jl. DI. Panjaitan No.Kav. 9-10, RT.1/RW.11, Cipinang Cempedak, Kecamatan Jatinegara, <br>
              Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13340 <br>
              Nama Penanggung Jawab : [Nama Penanggung Jawab] <br>
              Jabatan : Senior Vice President  Infrastructure 1 Division <br>
            </p>

            <h3>
              PIHAK KEDUA 
            </h3>
            @php
              $user = \App\Models\User::find($data->user_id);
              // dd($user);
            @endphp
            <p>
              Nama : {{$user->name}} <br>
              Nomor Identitas: {{$user->no_ktp}} <br>
              Alamat : {{$user->alamat}} Rt. {{$user->rt}} Rw. {{$user->rw}} Kel. {{$user->kelurahan}} Kec. {{$user->kecamatan}} Kota {{$user->kota}} Prov. {{$user->provinsi}} Kode Pos {{$user->kode_pos}}
            </p>

            <p>
              Dengan ini menyatakan bahwa <strong> PIHAK KEDUA bekerja di PT WIJAYA KARYA </strong> dengan masa kerja <br> sebagai berikut: <br>
              <ul>
                <li><strong>Tanggal Mulai</strong>: {{$data->awal_kontrak}}</li>
                <li><strong>Tanggal Berakhir</strong>: {{$data->akhir_kontrak}}</li>
              </ul>
              Demikian surat ini dibuat dengan sebenar-benarnya untuk dijadikan dokumen resmi dan dipahami oleh kedua belah pihak.
            </p>
            </div>
            

        </div>
      </div>
    </div>
  </div>
</div>
@endsection