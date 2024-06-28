
@extends('layouts.blog.app')

@section('content')
  <!-- ======= Breadcrumbs ======= -->
  <!-- ======= Portfolio Details Section ======= -->
  <section id="portfolio-details" class="portfolio-details">
    <div class="container">

      <div class="row gy-4">
          <table class="table">
            <thead>
              <tr>
                <th>No.</th>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Harga</th>
                <th>Tanggal</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @php
                $num = 1;
              @endphp
              @forelse ($get as $key => $value)
                <tr>
                  <td>{{$num++}}</td>
                  <td style="width: 25%"><img class="img-fluid img-thumbnail" src="{{asset('public\images')}}\{{$value->gambar}}" alt=""></td>
                  <td>{{$value->nama}}</td>
                  <td>{{rupiah($value->harga)}}</td>
                  <td>{{date('d-m-Y',strtotime($value->created_at))}}</td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
                      <button type="button" onclick="bayar({{$value->id}})" class="btn btn-success">Bayar</button>
                      <button onclick="batal({{$value->id}})" type="button" class="btn btn-danger">Batalkan</button>
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
  </section><!-- End Portfolio Details Section -->
@endsection
@push('script')
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
          console.log(data)
          $.ajax({
            url:'{{route('blog.order.bayar')}}',
            type:'post',
            data:{
              '_token':'{{csrf_token()}}',
              id:data.id,
              gross_amount:data.harga,
              name:`{{Auth::user()->name}}`,
              email:`{{Auth::user()->email}}`,
            },success:function(data){
              window.open('{{route('blog.order.payload')}}?token='+data.token+'&id_cart='+data.id_cart);
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
