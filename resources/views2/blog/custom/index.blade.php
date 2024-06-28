@extends('layouts.blog.app')

@section('content')
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body shadow">
          <p>Custom Gambar</p>
          <hr>
          <form id="form_custom">
            @csrf
            <div class="form-group">
              <label for="exampleFormControlTextarea1">Keterangan Custom</label>
              <textarea name="keterangan" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="custom-file mb-5">
              <input type="file" name="gambar" class="custom-file-input" id="customFile">
              <label class="custom-file-label" for="customFile">Choose file</label>
            </div>
            <input type="hidden" name="id_users" value="{{auth()->user()->id}}">
            <button type="submit" class="btn btn-success" name="button">Custom</button>
          </form>
        </div>
      </div>
    </div>
@endsection
@push('script')
<script type="text/javascript">
$('input[type="file"]').change(function(e){
       var fileName = e.target.files[0].name;
       $('.custom-file-label').html(fileName);
   });
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
  $('#form_custom').on('submit',function(e){
    e.preventDefault();
    var formdata = new FormData(this)
    $.ajax({
      url:'{{route('blog.custom.create')}}',
      type:'post',
      processData:false,
      contentType:false,
      data:formdata,
      success:function(data){
        Toast.fire({
          icon: 'success',
          title: 'Berhasil mengirimkan custom',
        });
        document.getElementById('form_custom').reset();
      }
    })
  })
  @guest
    function tambah_keranjang(id){
      Toast.fire({
        icon: 'error',
        title: 'Login terlebih dahulu',
      });
    }
  @endguest
</script>
@endpush
