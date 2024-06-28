@extends('auth.app')

@section('judul','LOGIN')

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
          <!-- a{{Hash::make('admin')}}a -->

          <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
              <input type="email"  name="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address...">
            </div>
            <div class="form-group">
              <input type="password" name="password" class="form-control form-control-user" id="exampleInputPassword" placeholder="Password">
            </div>
            <button type="submit" class="btn btn-primary btn-user btn-block">
              Login
            </button>
            <hr>
          </form>
          <div class="text-center">
            <a class="small" href="{{route('register')}}">Create an Account!</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripting')


@endpush