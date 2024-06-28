@extends('layouts.blog.app')

@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-12">
			<div class="card">
				<div class="card-body">
					<p class="h5">Pesan Lukisan</p>
					<hr>
					<form method="post" id="form_lukisan" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<input type="hidden" class="form-control" name="pemasar" value="{{Auth()->user()->koderef_cust}}">
							<div class="form-group col-md-6">
								<label for="inputEmail4">Ukuran Canvas</label>
								<select class="form-control" name="canvas" id="canvas">
									<option value="46" >40 X 60</option>
									<option value="67" >60 X 70</option>
									<option value="79" >70 X 90</option>
									<option value="912" >90 X 120</option>
									<option value="1218" >120 X 180</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="inputEmail4">Media Lukisan</label>
								<select class="form-control" name="media" id="media">
									<option value="canvas" >Canvas</option>
									<option value="kayu" >Kayu Jati</option>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label for="inputEmail4">Contoh Gambar</label>
								<div class="custom-file">
									<input name="file" type="file" class="form-control" id="customFile">
								</div>
							</div>
							<div class="form-group col-md-6">
								<label for="inputEmail4">Nama Gambar</label>
								<input type="text" name="nama" id="nama" class="form-control">
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</form>
				</div>
			</div>
		</div>
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
	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	});

	$('#form_lukisan').submit(function(e) {
		let formData = new FormData(this);
		$.ajax({
			type:'POST',
			url: '{{route('blog.custom.create')}}',
			data: formData,
			contentType: false,
			processData: false,
			success: (response) => {
				Toast.fire({
					icon: 'success',
					title: 'Berhasil menambahkan lukisan',
					text: "akan berpindah halaman",
				});
				setTimeout(function(){
					window.location.href = '{{route('blog.custom.index')}}'
				}, 3000);
			},
			error: function(response){
				Toast.fire({
					icon: 'error',
					title: 'Gagal menambahkan',
				});
			}
		});
		e.preventDefault();

	});
</script>
@endpush