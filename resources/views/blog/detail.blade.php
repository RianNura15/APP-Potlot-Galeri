@extends('layouts.blog.app')

@section('judul','DETAIL')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-8">
      <div class="portfolio-details-slider swiper">
        <div class="swiper-wrapper align-items-center">
          <div class="swiper-slide">
            <?php
            if (File::exists(public_path('images/'.$get->gambar))){
              ?>
              <img src="{{route('resize_gambar',['gambar'=>$get->gambar])}}" width="350px">'
              <!-- <img src="{{asset('public/images')}}/{{$get->gambar}}" width="350px">' -->
              <?php
            }
            else{
              echo "Lukisan Sudah Terhapus Silahkan Menunggu untuk update foto terbaru";
            }
            ?>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </div>

    <div class="col-lg-4">
      <div class="portfolio-info">
        <h3>Detail</h3>
        <table>
          <tr><td><strong>Nama</strong></td><td>:</td><td>{{$get->nama}}</td></tr>
          <tr><td><strong>Publikasi</strong></td><td>:</td><td>{{date('d-m-Y',strtotime($get->created_at))}}</td></tr>
          <tr><td><strong>Harga Awal</strong></td><td>:</td><td>{{rupiah($get->harga)}}</td></tr>
          <tr><td><strong>Diskon</strong></td><td>:</td><td>{{$get->promo}} %</td></tr>
          <tr><td><strong>Harga Akhir</strong></td><td>:</td><td>{{rupiah($get->harga-($get->promo/100)*$get->harga)}}</td></tr>
        </table>
        <input type="hidden" class="form-control" name="pemasar" value="{{Auth()->user()->koderef_cust}}">
        <p><button onclick="tambah_keranjang({{$get->id}})" class="btn btn-warning" type="button" name="button"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Tambahkan Troli</button></p>
      </div>
      <div class="portfolio-description">
        <!-- <p>{{$get->keterangan}}</p> -->
      </div>
    </div>
  </div>
</div>
@endsection
@push('scripting')
<script type="text/javascript">
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
  })
  @auth
  function tambah_keranjang(id){
    $.ajax({
      url:'{{route('blog.keranjang.tambah')}}',
      type:'post',
      data:{
        '_token':'{{csrf_token()}}',
        id:id,
        user:{{Auth::user()->id}},
        pemasar: $('[name=pemasar]').val(),
      },success:function(data){
        Toast.fire({
          icon: 'success',
          title: 'Berhasil menambah keranjang',
          text: "akan berpindah halaman",
        });
        setTimeout(function(){
          window.location.href = '{{route('blog.keranjang.index')}}'
        }, 3000);
      },error:function(data){
        Toast.fire({
          icon: 'error',
          title: 'Data sudah ditambahkan',
          // title: data.responseJSON,
        });
      }
    })
  }
  @endauth
  @guest
  function tambah_keranjang(id){
    Toast.fire({
      icon: 'error',
      title: 'Login terlebih dahulu',
    });
  }
  @endguest
</script>
@endpush
