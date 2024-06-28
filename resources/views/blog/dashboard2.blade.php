@extends('layouts.blog.app2')

@section('judul','UTAMA')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        @php
        $hour = date('H',strtotime('+7 hour'));
        $dayTerm = ($hour > 17) ? "Malam" : (($hour > 12) ? "Sore" : "Pagi");
        @endphp
        @guest
        <div class="card-header">
          <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
              <h1 class="welcome-text">Selamat {{$dayTerm}}</h1>
            </li>
          </ul>
        </div>
        @endguest
        @auth
        <div class="card-header">
          <ul class="navbar-nav">
            <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
              <h1 class="welcome-text">
                Selamat {{$dayTerm}},<span class="text-black fw-bold">{{Auth::user()->name}}</span>
              </h1>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <p>Coba periksa beberapa lukisan kami</p>
        </div>
        @endauth
      </div>
    </div>
  </div>
  <br>
  <div class="row justify-content-center dataku">
  </div>
</div>
<div class="container-fluid">
  <div class="data">

  </div>
</div>
@endsection
@push('scripting')
<script type="text/javascript">
  $(document).ready(function() {
    // console.log('aaa');
    load();
  });

  function load(){
    $.ajax({
      url:'{{route('blog.lukisan_json')}}',
      type:'get',
      success:function(data){
        setTimeout(function() {
          $('.dataku').html(data)
        }, 0);
      }
    })
  }
</script>
@endpush