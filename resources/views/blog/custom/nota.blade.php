<!DOCTYPE html>
<html>
<head>
	<title>CETAK NOTA {{$tgl}}</title>
</head>
<body>
	<center>
		<h2>NOTA BUKTI PEMBAYARAN</h2>
		<table style="margin-left: auto;margin-right: auto;">
			<tr><td>Nama Lukisan</td><td>:</td><td>{{$cstm->nama}}</td></tr>
			<tr><td>Nama Pemasar</td><td>:</td><td>{{App\User::nama_pemasar($cstm->id_pemasar)}}</td></tr>
			<tr><td>Nama Pemesan</td><td>:</td><td>{{App\User::nama_pemesan($cstm->id_cust)}}</td></tr>
			<tr><td>Status</td><td>:</td><td>{{$cstm->status}}</td></tr>
			<tr><td>Harga</td><td>:</td><td>{{rupiah($cstm->harga)}}</td></tr>
			<tr><td>Pemesanan</td><td>:</td><td>{{$cstm->created_at}}</td></tr>
		</table>
		<br>
		GAMBAR HASIL
		<br>
		<!-- {{$cstm->gambar4}} -->
		<img src="{{asset('public/custom/gmb4')}}/{{$cstm->gambar4}}" height="350" width="350">
		<br>
		GAMBAR SAMPEL
		<br>
		<img src="{{asset('public/custom')}}/{{$cstm->sampel}}" height="350" width="350">
	</center>
</body>
</html>