@extends('layouts.admin.app')

@section('content')
<section id="portfolio-details" class="portfolio-details">
    <div class="container-fluid">
        <div class="row justify-content-center card">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Gambar</th>
                        <th>Lukisan</th>
                        <th>Harga Awal</th>
                        <th>Diskon</th>
                        <th>Harga Akhir</th>
                        <th>Tgl Pesan</th>
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
                        <td style="width: 100px; height: 100px"><img class="img-fluid img-thumbnail" src="{{asset('public\images')}}\{{$value->gambar}}" alt=""></td>
                        <td>{{$value->nama}}</td>
                        <td>{{rupiah($value->harga)}}</td>
                        <td>{{rupiah($value->promo)}} %</td>
                        <td>{{rupiah($value->harga_akhir)}}</td>
                        <td>{{date('d-m-Y',strtotime($value->created_at))}}</td>
                        <td>{{$value->name}}</td>
                        <td>{{$value->status}}</td>
                        <td>
                          <div class="btn-group" role="group" aria-label="Basic example">
                            <!-- <button type="button" onclick="bayar({{$value->id}})" class="btn btn-success">Bayar</button> -->
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
</section>

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