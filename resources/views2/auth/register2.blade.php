<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <link rel="stylesheet" href="{{asset('public\sb_admin\css\sb-admin-2.min.css')}}">
  <link rel="stylesheet" href="{{asset('public\sb_admin\vendor\fontawesome-free\css\all.min.css')}}">
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

  <!-- Styles -->
  <style media="screen">
    .bg-register-image{
      background-image: url('https://arthive.net/res/media/img/orig/article/c2e/7567110@2x.jpg');
    }
  </style>
</head>
<body>
  <div id="app">
    <main class="py-4">
      <div class="container">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-4 d-none d-lg-block bg-register-image"></div>
              <div class="col-lg-8">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">Create an Account</h1>
                  </div>
                  <div class="row">
                    <div class="col-lg-6">
                      <form method="POST" action="{{ route('customer') }}">
                        @csrf
                        <div class="form-group">
                          <input  name="name" type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Name Customer" class="@error('name') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                          <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address" class="@error('email') is-invalid @enderror">
                        </div>
                        <div class="form-group">
                          <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password" class="@error('password') is-invalid @enderror">
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                          Register Account
                        </button>
                      </form>
                      <br>
                    </div>
                    <div class="col-lg-6">
                      <form method="POST" action="{{ route('marketing') }}">
                        @csrf
                        <div class="form-group">
                          <input  name="name" type="text" class="form-control form-control-user" id="exampleFirstName" placeholder="Name Marketing">
                        </div>
                        <div class="form-group">
                          <input type="email" name="email" class="form-control form-control-user" id="exampleInputEmail" placeholder="Email Address">
                        </div>
                        <div class="form-group">
                          <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                          Register Account
                        </button>
                      </form>
                    </div>
                  </div>
                  <hr>
                  <div class="text-center">
                    <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                  </div>
                  <div class="text-center">
                    <a class="small" href="{{route('login')}}">Already have an account? Login!</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </main>
  </div>
  <script src="{{asset('public\sb_admin\vendor\jquery\jquery.min.js')}}"></script>
  <script src="{{asset('public\sb_admin\vendor\bootstrap\js\bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('public\sb_admin\vendor\jquery-easing\jquery.easing.min.js')}}"></script>
  <script src="{{asset('public\sb_admin\js\sb-admin-2.min.js')}}" charset="utf-8"></script>
</body>

</html>
