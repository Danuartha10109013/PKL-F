@extends('layout.pegawai.main')

@section('title', '403 - Access Denied')

@section('content')
<!-- Page header -->
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row justify-content-center">
      <div class="col-md-6 text-center">
        <!-- Branding image -->
        
        <!-- Page title -->
        <h1 class="page-title text-danger" style="margin-left: 3.1em">
          403 - Access Denied
        </h1>
        <img src="{{ asset('wika logo.png') }}" alt="Wika Logo" class="img-fluid mb-4" style="max-width: 150px;">
        
        <!-- Description -->
        <p class="text-muted mb-4">
          Sorry, you do not have the necessary permissions to access this page.
        </p>
        
        <!-- Return button -->
        @if (Auth::user()->role == 0)
        <a href="{{route('hc.dashboard')}}" class="btn btn-lg btn-primary">
          Return to Dashboard
        </a>
          @elseif (Auth::user()->role == 1)
          <a href="{{route('pegawai.dashboard')}}" class="btn btn-lg btn-primary">
            Return to Dashboard
          </a>
          @elseif (Auth::user()->role == 2)
          <a href="{{route('kapro.dashboard')}}" class="btn btn-lg btn-primary">
            Return to Dashboard
          </a>
          @elseif (Auth::user()->role == 3)
          <a href="{{route('manajerhc.dashboard')}}" class="btn btn-lg btn-primary">
            Return to Dashboard
          </a>
          @elseif (Auth::user()->role == 3)
          <a href="{{route('pusat.dashboard')}}" class="btn btn-lg btn-primary">
            Return to Dashboard
          </a>
        @endif
      </div>
    </div>
  </div>
</div>

<!-- Additional styling -->
<style>
  .page-header {
    margin-top: 50px;
    padding: 50px 0;
    background-color: #f8f9fa;
  }
  .page-title {
    font-size: 2.5rem;
    margin-bottom: 20px;
  }
  .btn-primary {
    padding: 10px 20px;
    font-size: 1.2rem;
  }
</style>
@endsection
