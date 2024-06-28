
@extends('layouts.blog.app')

@section('content')
<!-- ======= Breadcrumbs ======= -->
<!-- ======= Portfolio Details Section ======= -->
<section id="portfolio-details" class="portfolio-details">
  <div class="container-fluid">
    <div class="row justify-content-center card">
      <table class="table text-center">
        <thead>
          <tr>
            <th>No.</th>
            <th>Gambar</th>
            <th>Nama Marketing</th>
            <th>Harga Awal</th>
            <th>Diskon</th>
            <th>Harga Akhir</th>
            <th>Tgl Pesan</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @php
          $num = 1;
          @endphp
          @forelse ($get as $key => $value)
          <tr>
            <td>{{$num++}}</td>
            @if(File::exists(public_path('images/'.$value->gambar)))
            <td style="width: 100px; height: 100px"><img class="img-fluid img-thumbnail" src="{{asset('public\images')}}\{{$value->gambar}}" alt=""></td>
            @else
            <td>Gambar terhapus</td>
            @endif
            <td>{{$value->name}}</td>
            <td>{{rupiah($value->harga)}}</td>
            <td>{{$value->promo}} %</td>
            <td>{{rupiah($value->harga-($value->harga*$value->promo/100))}}</td>
            <td>{{date('d-m-Y',strtotime($value->created_at))}}</td>
            <td>{{$value->status}}</td>
            <td>
              <div class="btn-group" role="group" aria-label="Basic example">
                @if($value->status=='pesan')
                <button type="button" onclick="bayar({{$value->id}})" class="btn btn-success">Bayar</button>
                @endif
                @if($value->status=='pesan')
                <button onclick="batal({{$value->id}})" type="button" class="btn btn-danger">Batalkan</button>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td class="text-center" colspan="6">Data Kosong</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</section>
<!-- End Portfolio Details Section -->
@endsection
@push('scripting')
<script type="text/javascript">
  $('.table').DataTable();
</script>
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
  function bayar(id){
    $.ajax({
      url:'{{route('blog.keranjang.cart_id')}}',
      type:'get',
      data:{
        id:id
      },success:function(data){
        // console.log(data.id,data.harga)
        $.ajax({
          url:'{{route('blog.order.bayar')}}',
          type:'post',
          data:{
            '_token':'{{csrf_token()}}',
            id:data.id,
            gross_amount:data.harga,
            // gross_amount:1,
            name:'{{Auth::user()->name}}',
            email:'{{Auth::user()->email}}',
          },success:function(data){
            console.log(data);
            window.open('{{route('blog.order.payload')}}?token='+data.token+'&id_cart='+data.id_cart);
          },error:function(){
            // console.log('gagal');
          }
        });
      }
    })

  }
  function batal(id){
    $.ajax({
      url:'{{route('blog.keranjang.batal')}}',
      type:'post',
      data:{
        '_token':'{{csrf_token()}}',
        id:id
      },success:function(data){
        Toast.fire({
          icon: 'success',
          title: 'Daftar kerangjang dihapus',
        });
        setTimeout(function(){
          location.reload();
        }, 3000);
      },error:function(data){
        Toast.fire({
          icon: 'error',
          title: 'Gagal menghapus',
        });
      }
    })
  }
</script>
@endpush
