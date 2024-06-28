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

  <!-- Styles -->
  <style media="screen">
    .bg-login-image{
      background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/e/ea/Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg/1200px-Van_Gogh_-_Starry_Night_-_Google_Art_Project.jpg');
    }
  </style>
</head>
<body>
  <div id="app">
    <main class="py-4">
      <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

          <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
              <div class="card-body p-0">
                <!-- Nested Row within Card Body -->
                <div class="row">
                  <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                  <div class="col-lg-6">
                    <div class="p-5">
                      <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                      </div>
                      <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="form-group">
                          <input type="email"  name="email" class="form-control form-control-user"
                          id="exampleInputEmail" aria-describedby="emailHelp"
                          placeholder="Enter Email Address...">
                        </div>
                        <div class="form-group">
                          <input type="password" name="password" class="form-control form-control-user"
                          id="exampleInputPassword" placeholder="Password">
                        </div>
                        <div class="form-group">
                          <div class="custom-control custom-checkbox small">
                            <input name="remember" type="checkbox" class="custom-control-input" id="customCheck">
                            <label class="custom-control-label" for="customCheck">Remember
                            Me</label>
                          </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                          Login
                        </button>
                        <hr>
                      </form>
                      <div class="text-center">
                        <a class="small" href="{{ route('password.request') }}">Forgot Password?</a>
                      </div>
                      <div class="text-center">
                        <a class="small" href="{{route('register')}}">Create an Account!</a>
                      </div>
                    </div>
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