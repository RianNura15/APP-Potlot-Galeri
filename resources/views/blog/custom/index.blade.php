@extends('layouts.blog.app')

@section('content')
<section id="portfolio-details" class="portfolio-details">
  <div class="container-fluid">
    <div class="row justify-content-center card">
      <table class="table text-center">
        <thead>
          <tr>
            <th>No.</th>
            <th>Nama Gambar</th>
            <th>Harga</th>
            <th>Sampel</th>
            <th>Nama Marketing</th>
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
            <td>{{$value->nama}}</td>
            <td>{{rupiah($value->harga)}}</td>
            <td><img class="img-fluid img-thumbnail" src="{{asset('public\custom')}}\{{$value->sampel}}" style="height: 100px; width: 100px" alt=""></td>
            <td>{{$value->name}}</td>
            <td>{{$value->status}}</td>
            <td>
              <div class="btn-group" role="group" aria-label="Basic example">
                @if($value->status=='pesan')
                <button type="button" onclick="bayar({{$value->id}})" class="btn btn-success">Bayar</button>
                @endif
                <a href="{{url('blog/custom/chat',$value->id)}}" class="btn btn-primary">Chat</a>
                <!-- <button onclick="batal({{$value->id}})" type="button" class="btn btn-danger">Batalkan</button> -->
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
@endsection

@push('scripting')
<script type="text/javascript">
  $('.table').DataTable();
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
      url:'{{route('blog.custom.cart_id')}}',
      type:'get',
      data:{
        id:id
      },success:function(data){
        // console.log(data)
        $.ajax({
          url:'{{route('blog.custom.bayar')}}',
          type:'post',
          data:{
            '_token':'{{csrf_token()}}',
            id:data.id,
            gross_amount:data.harga,
            // gross_amount:1,
            name:`{{Auth::user()->name}}`,
            email:`{{Auth::user()->email}}`,
          },success:function(data){
            window.open('{{route('blog.custom.payload')}}?token='+data.token+'&id_cart='+data.id_cart);
          }
        });
      }
    })
  }

</script>
@endpush