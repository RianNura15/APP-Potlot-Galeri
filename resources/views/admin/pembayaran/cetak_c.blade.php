<!DOCTYPE html>
<html>
<head>
	<title>CETAK NOTA {{$tgl}}</title>
</head>
<body>
	<center>
		<h2>REKAP PENDAPATAN PEMESANAN CUSTOM</h2>
		<h4>{{$data['user']->name}}</h4>
		<table style="text-align:center; margin-left: auto;margin-right: auto; ">
			<thead>
				<tr>
					<th>No.</th>
					<th>Nama Pemesan</th>
					<th>Nama Lukisan</th>
					<th>Harga</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['data'] as $key => $value)
				<tr>
					<td>{{$loop->iteration}}</td>
					<td>{{\App\User::nama_pemesan($value->id_cust)}}</td>
					<td>{{$value->nama}}</td>
					<td>{{rupiah($value->harga)}}</td>
					<td>{{$value->status}}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</center>
</body>
</html>