@extends('auth.app')

@section('judul', 'REGISTER')

@push('styleshet')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style media="screen">

    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center dataku">
            <div class="col-md-12">
                <div class="card">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                        </div>
                        <!-- a{{ Hash::make('admin') }}a -->
                        <div class="row">
                            <div class="col">
                                <form method="POST" action="{{ route('customer') }}">
                                    @csrf
                                    <div class="form-group">
                                        <input name="name" type="text" class="form-control form-control-user"
                                            id="exampleFirstName" placeholder="Name Customer"
                                            class="@error('name') is-invalid @enderror">
                                    </div>
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user"
                                            id="exampleInputEmail" placeholder="Email Address"
                                            class="@error('email') is-invalid @enderror">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password"
                                            class="@error('password') is-invalid @enderror">
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-user btn-block">
                                        Register Account
                                    </button>
                                </form>
                                <br>
                            </div>
                            {{-- <div class="col-lg-6">
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
            </div> --}}
                        </div>
                        <div class="text-center">
                            <a class="small" href="{{ route('login') }}">Already have an account? Login!</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripting')
@endpush
