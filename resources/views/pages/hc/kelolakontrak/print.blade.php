<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Kontrak</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
        }

        .header {
            text-align: center;
        }

        .header img {
            width: 10%;
            margin-bottom: 10px;
        }

        .header h1 {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }

        .header p {
            font-size: 14px;
            margin: 0;
        }

        hr {
            border: 1px solid black;
            margin: 20px 0;
        }

        h2, h3 {
            font-size: 16px;
            text-align: left;
        }

        .content {
            margin: 20px;
        }

        .content p {
            line-height: 1.8;
        }

        ul {
            margin: 0;
            padding-left: 20px;
        }

        .footer {
            text-align: center;
            margin-top: 50px;
        }
    </style>
</head>
<body>

<div class="header">
    <img src="{{asset('logo_wika.png')}}" alt="Logo">
    <h1>PT WIJAYA KARYA (PERSERO) TBK</h1>
    <p>Jl. DI. Panjaitan No.Kav. 9-10, RT.1/RW.11, Cipinang Cempedak, Kecamatan Jatinegara, Kota Jakarta Timur,<br>
        Daerah Khusus Ibukota Jakarta 13340</p>
    <hr>
    <h2>
        <center>
        DETAIL KONTRAK
        </center>
    </h2>
</div>

<div class="content">
    <p>Nomor: {{$data->id}}/KONTRAK/WIKA/{{$data->created_at->format('Y')}}</p>

    <h3>PIHAK PERTAMA</h3>
    <p>
        Nama Perusahaan: PT WIJAYA KARYA PERSERO TBK <br>
        Alamat: Jl. DI. Panjaitan No.Kav. 9-10, RT.1/RW.11, Cipinang Cempedak, Kecamatan Jatinegara,<br>
        Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13340 <br>
        Nama Penanggung Jawab: [Nama Penanggung Jawab] <br>
        Jabatan: Senior Vice President  Infrastructure 1 Division <br>
    </p>

    <h3>PIHAK KEDUA</h3>
    @php
      $user = \App\Models\User::find($data->user_id);
    @endphp
    <p>
        Nama: {{$user->name}} <br>
        Nomor Identitas: {{$user->no_ktp}} <br>
        Alamat: {{$user->alamat}} Rt. {{$user->rt}} Rw. {{$user->rw}} Kel. {{$user->kelurahan}} Kec. {{$user->kecamatan}} Kota {{$user->kota}} Prov. {{$user->provinsi}} Kode Pos {{$user->kode_pos}} <br>
    </p>

    <p>
        Dengan ini menyatakan bahwa <strong> PIHAK KEDUA bekerja di PT WIJAYA KARYA </strong> dengan masa kerja <br>
        sebagai berikut: <br>
        <ul>
            <li><strong>Tanggal Mulai:</strong> {{$data->awal_kontrak}}</li>
            <li><strong>Tanggal Berakhir:</strong> {{$data->akhir_kontrak}}</li>
        </ul>
        Demikian surat ini dibuat dengan sebenar-benarnya untuk dijadikan dokumen resmi dan dipahami oleh kedua belah pihak.
    </p>
</div>

<div class="footer">
    <p>Jakarta, {{$data->created_at->format('d-m-Y')}}</p>
    <p>PT WIJAYA KARYA (PERSERO) TBK</p>
    <br><br><br>
    <p>[Nama Penanggung Jawab]</p>
</div>

<a class="print" href="javascript:void(0);" onclick="window.print()">Print BTN</a>

<style>
    @media print {
        .print {
            display: none;
        }
    }
</style>

<script>
    window.onload = function() {
        window.print();  // This triggers the print dialog as soon as the page is loaded
    }
</script>

</body>
</html>
