<!doctype html>

<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sign in || PT. Wijaya Karya</title>
    <link rel="shortcut icon" href="{{ asset('wika logo.png') }}">

    <!-- CSS files -->
    <link href="{{asset('vendor')}}/dist/css/tabler.min.css?1692870487" rel="stylesheet"/>
    <link href="{{asset('vendor')}}/dist/css/tabler-flags.min.css?1692870487" rel="stylesheet"/>
    <link href="{{asset('vendor')}}/dist/css/tabler-payments.min.css?1692870487" rel="stylesheet"/>
    <link href="{{asset('vendor')}}/dist/css/tabler-vendors.min.css?1692870487" rel="stylesheet"/>
    <link href="{{asset('vendor')}}/dist/css/demo.min.css?1692870487" rel="stylesheet"/>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column mt-5">
    <script src="{{asset('vendor')}}/dist/js/demo-theme.min.js?1692870487"></script>
    <div class="page page-center">
      <div class="container container-tight mt-5 py-4">
        <div class="text-center mt-4">
          <a href="https://www.wika.co.id/" class="navbar-brand navbar-brand-autodark">
            <img src="{{asset('wika logo.png')}}" width="200"  alt="Tabler" class="navbar-brand-image">
          </a>
        </div>
        <div class="card card-md">
          <div class="card-body">
            <h2 class="h2 text-center mb-4">Login to your account</h2>
            <form action="{{route('login-proses')}}"   method="POST" autocomplete="off" novalidate>
              @method('POST')
                @csrf
                @if (session('success'))
                  <script>
                      Swal.fire({
                          icon: 'success',
                          title: 'Success!',
                          text: '{{ session('success') }}',
                          showConfirmButton: false,
                          timer: 3000
                      });
                  </script>
              @endif

              @if (session('error'))
                  <script>
                      Swal.fire({
                          icon: 'error',
                          title: 'Error!',
                          text: '{{ session('error') }}',
                          showConfirmButton: false,
                          timer: 3000
                      });
                  </script>
              @endif

              @if ($errors->any())
                  <script>
                      Swal.fire({
                          icon: 'error',
                          title: 'Validation Error!',
                          html: '<ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>',
                          showConfirmButton: true
                      });
                  </script>
              @endif

              <div class="mb-3">
                <label class="form-label">Username Or Email</label>
                <input type="text" name="username" class="form-control" placeholder="username or email" autocomplete="off">
              </div>
              <div class="mb-2">
                <label class="form-label">
                  Password
                <input type="password" name="password" class="form-control" placeholder="password" autocomplete="off">
                  
                </label>
                
              </div>
              <div class="mb-2">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input"/>
                  <span class="form-check-label">Remember me on this device</span>
                </label>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
              </div>
            </form>
          </div>
          <div class="card-body">
            
          </div>
        </div>

      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{asset('vendor')}}/dist/js/tabler.min.js?1692870487" defer></script>
    <script src="{{asset('vendor')}}/dist/js/demo.min.js?1692870487" defer></script>
  </body>
</html>