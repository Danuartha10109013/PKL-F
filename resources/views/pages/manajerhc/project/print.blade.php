<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Project</title>
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th, td {
            text-align: center;
            padding: 8px;
        }
        .logo {
            position: absolute;
            top: 20px;
            left: 20px;
            height: 50px;
        }
        .description {
            text-align: left;
            padding-left: 10px;
            margin-bottom: 20px;
        }
        .users-table {
            margin-top: 20px;
            width: 100%;
        }
        .users-table th, .users-table td {
            text-align: left;
        }
    </style>
</head>
<body onload="window.print()">
    <!-- Logo -->
    <img src="{{ asset('logo_wika.png') }}" alt="Logo" class="logo">
    <header>
        <center>
           <h5 style="color: rgb(84, 128, 240)"> PT WIJAYA KARYA (PERSERO)TBK</h5>
            <h6 style="color: rgb(84, 128, 240);margin-top: -20px">
                Jl. DI. Panjaitan No.Kav. 9-10, RT.1/RW.11, Cipinang Cempedak, Kecamatan Jatinegara, <br>
                Kota Jakarta Timur, Daerah Khusus Ibukota Jakarta 13340
            </h6>
        </center>
        <hr style="height: 2px;color: #000;background-color: #000">
    </header>
    <!-- Title -->
    <h1>LAPORAN PROJECT</h1>

    <!-- Main Table -->
    <table>
        <tr>
            <th colspan="3">{{ $data->judul }}</th>
        </tr>
        <tr>
            <td colspan="3">{{ $data->kode_project }}</td>
        </tr>
        <tr>
            <th>Kode Unit Kerja</th>
            <td> : </td>
            <td>{{ $data->kode_uk }}</td>
        </tr>
        <tr>
            <th >Unit Kerja</th>
            <td> : </td>
            <td>{{ $data->unit_kerja }}</td>
        </tr>
        <tr>
            @php
                $kapro = \App\Models\User::find($data->kapro_id);
            @endphp
            <th >Ketua Project</th>
            <td> : </td>
            <td>{{ $kapro->name }}</td>
        </tr>
        <tr>
            <th >Kategori</th>
            <td> : </td>
            <td>{{ $data->kategori }}</td>
        </tr>
        <tr>
            <th >SBU</th>
            <td> : </td>
            <td>{{ $data->sbu }}</td>
        </tr>
        <tr>
            <th >Status</th>
            <td> : </td>
            <td>{{ $data->statusin }}</td>
        </tr>
        
        <tr>
            <th >Start Date</th>
            <td> : </td>
            <td>{{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}</td>
        </tr>
        
        <tr>
            <th >Status</th>
            <td> : </td>
            @if ($data->status == 0)
            <td style="color: orange">Belum Dimulai</td>
            @elseif ($data->status == 1)
            <td style="color: blue">Akitf</td>
            @elseif ($data->status == 5)
            <td style="color: yellow">Pemeliharaan</td>
            @elseif ($data->status == 2)
            <td style="color: green">Selesai</td>
            @else
            <td style="color: red">Unknown</td>
            
            @endif
        </tr>
        <tr>
            <th >End Date</th>
            <td> : </td>
            <td>{{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}</td>
        </tr>
        <tr>
            <th colspan="3">Deskripsi</th>
        </tr>
        <tr>
            <td colspan="3">{{ $data->deskripsi }}</td>
        </tr>
        
    </table>

    <!-- Users Involved -->
    <h3>USER YANG TERLIBAT:</h3>
    <table class="users-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Nilai</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            @php
                      // Decode JSON array from pegawai_id
                      $pegawai_ids = json_decode($data->pegawai_id, true);

                      // Check if pegawai_ids is valid array
                      if (is_array($pegawai_ids) && count($pegawai_ids) > 0) {
                          // Retrieve users involved using whereIn to handle array of IDs
                          $user_terlibat = \App\Models\User::whereIn('id', $pegawai_ids)->get();
                      } else {
                          $user_terlibat = collect(); // Use empty collection if no users are involved
                      }
                  @endphp
            @foreach ($user_terlibat as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @php
                        $project = $data->id;
                        $ids = \App\Models\PenilaianM::where('user_id', $user->id)->where('project_id',$project)->count();
                          $total = \App\Models\PenilaianM::where('user_id', $user->id)->where('project_id',$project)->value('total');
                        @endphp
                        {{$total}}
                    </td>
                    <td>Pegawai</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
