@extends('layout.pegawai.main')

@section('title', 'Terjadi Kesalahan')

@section('content')
<div class="container mt-5">
    <div class="alert alert-danger text-center shadow-lg p-5 rounded">
        <h1 class="display-4">Oops, Page Not Found 😵</h1>
        <p class="lead">
            {{ $exception->getMessage() ?? 'Terjadi kesalahan saat memproses permintaan Anda.' }}
        </p>
        <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
    </div>
</div>
@endsection
