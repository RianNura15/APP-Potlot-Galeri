@extends('layouts.admin.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card">
        <div class="card-body">
          <p class="h5">Tambah Lukisan</p>
          <hr>
          <form method="post" id="form_lukisan" enctype="multipart/form-data">
            @csrf
            <div class="row">
              <div class="form-group col-md-6">
                <label for="inputEmail4">Nama</label>
                <input type="text" class="form-control" id="inputEmail4" name="nama">
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail4">Gambar</label>
                <div class="custom-file">
                  <input name="file" type="file" class="custom-file-input" id="customFile">
                  <label class="custom-file-label" for="customFile">Pilih Gambar</label>
                </div>
              </div>
              <div class="form-group col-md-6">
                <label for="exampleFormControlTextarea1">Keterangan</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="keterangan"></textarea>
              </div>
              <div class="form-group col-md-6">
                <label for="inputEmail4">Harga</label>
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Rp. </span>
                  </div>
                  <input type="number" class="form-control" aria-label="Username" aria-describedby="basic-addon1" name="harga">
                </div>
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
     url: '{{route('admin.karya.tambah')}}',
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
        window.location.href = '{{route('admin.karya.index')}}'
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
