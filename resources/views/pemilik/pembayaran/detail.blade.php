
@push('styleshet')
  <link rel="stylesheet" href="{{asset('public\sb_admin\vendor\datatables\dataTables.bootstrap4.min.css')}}">
@endpush
@extends('layouts.pemilik.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-body">
          <p class="h5">Daftar Pendapatan Pemesanan {{$data['markt']->name}}</p>
          <hr>
          <a href="{{url('pemilik/pembayaran/index')}}" class="btn btn-primary"><== KEMBALI</a>
          <a href="{{url('pemilik/pembayaran/index/cetak',$data['markt']->id)}}" target="_blank" class="btn btn-primary"><span class="fas fa-print"></span> CETAK</a>
          <hr>
          <table class="table" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama Pemesan</th>
                <th>Harga Awal</th>
                <th>Promo</th>
                <th>Harga Akhir</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
            	@foreach($data['cart'] as $key => $value)
            	<tr>
            		<td>{{$loop->iteration}}</td>
            		<td>{{\App\User::nama_pemesan($value->id_cust)}}</td>
            		<td>{{rupiah($value->harga)}}</td>
            		<td>{{$value->promo}} %</td>
            		<td>{{rupiah($value->harga-($value->promo*$value->harga/100))}}</td>
            		<td>{{$value->status}}</td>
            	</tr>
            	@endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripting')
<script src="{{asset('public\sb_admin\vendor\datatables\jquery.dataTables.min.js')}}" charset="utf-8"></script>
<script src="{{asset('public\sb_admin\vendor/datatables/dataTables.bootstrap4.min.js')}}" charset="utf-8"></script>
<script type="text/javascript">
	$('.table').DataTable();

</script>

@endpush

