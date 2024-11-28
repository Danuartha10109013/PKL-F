<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>Data Pegawai</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Role</th>
                <th>No Pegawai</th>
                <th>Email</th>
                <th>Personal Number</th>
                <th>Status Data</th>
                <th>Keterangan</th>
                <th>Posisi</th>
                <th>Gender</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>No KTP</th>
                <th>Phone</th>
                <th>Agama</th>
                <th>Status Perkawinan</th>
                <th>Jumlah Tanggungan</th>
                <th>NPWP</th>
                <th>Alamat</th>
                <th>RT</th>
                <th>RW</th>
                <th>Kelurahan</th>
                <th>Kecamatan</th>
                <th>Kota</th>
                <th>Provinsi</th>
                <th>Kode Pos</th>
                <th>No BPJS</th>
                <th>No BPJSTK</th>
                <th>Lokasi BPJS</th>
                <th>Terdaftar BPJSTK</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$d->name}}</td>
                <td>{{$d->role == 0 ? 'Human Capital' : ($d->role == 1 ? 'Pegawai' : ($d->role == 2 ? 'Ketua Project' : ($d->role == 3 ? 'Manajer Human Capital' : 'Unknown')))}}</td>
                <td>{{$d->no_pegawai}}</td>
                <td>{{$d->email}}</td>
                <td>{{$d->personel_number}}</td>
                <td>{{$d->status_data}}</td>
                <td>{{$d->keterangan}}</td>
                <td>{{$d->posisi}}</td>
                <td>{{$d->gender}}</td>
                <td>{{$d->tempat_lahir}}</td>
                <td>{{$d->tanggal_lahir}}</td>
                <td>{{$d->no_ktp}}</td>
                <td>{{$d->phone}}</td>
                <td>{{$d->agama}}</td>
                <td>{{$d->kawin}}</td>
                <td>{{$d->tanggungan}}</td>
                <td>{{$d->npwp}}</td>
                <td>{{$d->alamat}}</td>
                <td>{{$d->rt}}</td>
                <td>{{$d->rw}}</td>
                <td>{{$d->kelurahan}}</td>
                <td>{{$d->kecamatan}}</td>
                <td>{{$d->kota}}</td>
                <td>{{$d->provinsi}}</td>
                <td>{{$d->kode_pos}}</td>
                <td>{{$d->no_bpjs}}</td>
                <td>{{$d->no_bpjstk}}</td>
                <td>{{$d->lokasi_bpjs}}</td>
                <td>{{$d->terdaftar_bpjstk}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>