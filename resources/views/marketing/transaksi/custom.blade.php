@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center card">
        <table class="table text-center">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Gambar</th>
                    <th>Harga</th>
                    <th>Sampel</th>
                    <th>Pemesan</th>
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
                    <td>
                        <img class="img-fluid img-thumbnail" src="{{asset('public\custom')}}\{{$value->sampel}}" style="height: 100px; width: 100px" alt="">
                    </td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->status}}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <a href="{{url('marketing/transaksi/chat',$value->id)}}" class="btn btn-primary">Chat</a>
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
</script>
@endpush