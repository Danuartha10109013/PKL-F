@extends('layout.pegawai.main')
@section('title')
Kontrak || Pegawai
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
                    Kontrak
                </h2>
            </div>
            <!-- Page title actions -->
            <div class="col-auto ms-auto d-print-none">
                <div class="btn-list">
                    <!-- Search Form -->
                    <form action="{{ route('hc.kelola-project') }}" method="GET" class="d-flex justify-content-center mb-0 position-relative">
                        <input type="text" id="searchInput" name="search" class="form-control w-100" 
                               placeholder="Search project..." value="{{ request()->query('search') }}">
                        <!-- Clear 'X' Button outside the input -->
                        @if(request()->query('search'))
                            <button type="button" id="clearSearch" class="btn btn-light position-absolute" 
                                    style="right: 90px; top: 50%; transform: translateY(-50%); z-index: 2;">
                                &times;
                            </button>
                        @endif
                        <button type="submit" class="btn btn-primary ms-2">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <h4>Kontrak : {{ Auth::user()->name }}</h4>
                <img src="{{ asset('storage/' . Auth::user()->profile) }}" width="5%" alt="">
                <br>
                <p class="mt-4">Detail kontrak</p>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Awal Kontrak:</strong> {{ $data->awal_kontrak }}</p>
                        <p><strong>Durasi:</strong> 
                            @php
                                $today = \Carbon\Carbon::now();
                                $endDate = \Carbon\Carbon::parse($data->akhir_kontrak);
                                $remainingDays = ceil($endDate->diffInDays($today, false));
                            @endphp
                            @if ($remainingDays < 0)
                                {{ abs($remainingDays) }} hari 
                            @else
                                <p class="text-danger">Kontrak Selesai</p>
                            @endif
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Akhir Kontrak:</strong> {{ $data->akhir_kontrak }}</p>
                        <p><strong>Periode:</strong> {{ $data->periode }}</p>
                    </div>
                    <!-- Calendar Container -->
                    <div id="calendar" class="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

<!-- FullCalendar Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: [
                // Contract period events with color differentiation
                @for($date = \Carbon\Carbon::parse($data->awal_kontrak); $date <= \Carbon\Carbon::parse($data->akhir_kontrak); $date->addDay())
                    {
                        title: 'Contract Period',
                        start: '{{ $date->toDateString() }}',
                        backgroundColor: '{{ $date->isPast() ? "gray" : "green" }}',
                        borderColor: '{{ $date->isPast() ? "gray" : "green" }}',
                        allDay: true
                    },
                @endfor

                // Off days (weekends) with red color overriding green
                @for($date = \Carbon\Carbon::parse($data->awal_kontrak); $date <= \Carbon\Carbon::parse($data->akhir_kontrak); $date->addDay())
                    @if($date->isWeekend())
                        {
                            title: 'Off Day',
                            start: '{{ $date->toDateString() }}',
                            backgroundColor: 'red',
                            borderColor: 'red',
                            allDay: true
                        },
                    @endif
                @endfor
            ],
        });
        calendar.render();
    });
</script>
@endsection
