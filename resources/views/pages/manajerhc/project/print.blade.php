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

    <!-- Title -->
    <h1>LAPORAN PROJECT</h1>

    <!-- Main Table -->
    <table>
        <tr>
            <th colspan="4">Judul</th>
        </tr>
        <tr>
            <td colspan="4">{{ $data->judul }}</td>
        </tr>
        <tr>
            <th colspan="2">Kode Project</th>
            <td colspan="2">{{ $data->kode_project }}</td>
        </tr>
        <tr>
            <th>Kode Unit Kerja</th>
            <td>{{ $data->kode_uk }}</td>
            <th>Unit Kerja</th>
            <td>{{ $data->unit_kerja }}</td>
        </tr>
        <tr>
            <th>Status</th>
            <td>{{ $data->status }}</td>
            <th>Kategori</th>
            <td>{{ $data->kategori }}</td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td>{{ \Carbon\Carbon::parse($data->start_date)->format('d M Y') }}</td>
            <th>End Date</th>
            <td>{{ \Carbon\Carbon::parse($data->end_date)->format('d M Y') }}</td>
        </tr>
    </table>

    <!-- Description -->
    <h3>DESKRIPSI:</h3>
    <div class="description">
        {{ $data->deskripsi }}
    </div>

    <!-- Users Involved -->
    <h3>USER YANG TERLIBAT:</h3>
    <table class="users-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Email</th>
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
                    <td>Pegawai</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
