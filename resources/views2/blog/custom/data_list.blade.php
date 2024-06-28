
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
                <th>Keterangan</th>
                <th>Tanggal</th>
                <th>Hasil Gambar</th>
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
                  <td style="width: 100%"><img class="img-fluid img-thumbnail" src="{{asset('public\images')}}\{{$value->gambar}}" alt=""></td>
                  <td>{{$value->custom}}</td>
                  <td>{{date('d-m-Y',strtotime($value->created_at))}}</td>
                  <td> <a href="{{asset('public/images/'.$value->hasil)}}">{{$value->hasil}}</a> </td>
                  <td>
                    <div class="btn-group" role="group" aria-label="Basic example">
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
    function batal(id){
      $.ajax({
        url:'{{route('blog.custom.batal')}}',
        type:'post',
        data:{
          '_token':'{{csrf_token()}}',
          id:id
        },success:function(data){
          Toast.fire({
            icon: 'success',
            title: 'Daftar custom dihapus',
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
