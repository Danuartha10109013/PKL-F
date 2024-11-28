<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>Kotrak Pegawai</h3>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pegawai</th>
                <th>Duration</th>
                <th>Start</th>
                <th>End</th>
                <th>Periode</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $d)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>
                    @php
                      $name = \App\Models\User::where('id',$d->user_id)->value('name');
                    @endphp
                    {{$name}}
                </td>
                <td>
                    @php
                        $today = \Carbon\Carbon::now();
                        $endDate = \Carbon\Carbon::parse($d->akhir_kontrak);
                        $remainingDays = ceil($endDate->diffInDays($today, false)); // Round up to the nearest whole number
                    @endphp
                    @if ($remainingDays < 0)
                    {{ abs($remainingDays -1) }} hari 
                    @else
                    <p class="text-danger">Kontrak Selesai</p>
                    @endif
                </td>
                <td>{{$d->awal_kontrak}}</td>
                <td>{{$d->akhir_kontrak}}</td>
                <td>{{$d->periode}}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>