<!DOCTYPE html>
<html>
<head>
	<title>CETAK NOTA {{$tgl}}</title>
</head>
<body>
	<center>
		<h2>REKAP PENDAPATAN PEMESANAN KARYA BEBAS</h2>
		<h4>{{$data['user']->name}}</h4>
		<table style="text-align:center; margin-left: auto;margin-right: auto; ">
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
				@foreach($data['data'] as $key => $value)
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
	</center>
</body>
</html>