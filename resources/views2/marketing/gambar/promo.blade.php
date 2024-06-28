@extends('layouts.admin.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="modal fade" id="modal_promo" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLongTitle">Buat Promo Untuk Karya Seni</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <form id="form_promo">
                @csrf
                <input type="hidden" name="id_karya">
                <p>Harga Karya : <strong><f class="text-success" id="harga_karya"></f></strong></p>
                <div class="form-group">
                  <label for="exampleInputEmail1">Promo (%)</label>
                  <input type="number" name="promo" onkeyup="add_promo(this)" class="form-control" id="exampleInputEmail1">
                </div>
                <p>Harga Akhir : <strong><f class="text-primary" id="harga_akhir"></f></strong></p>
                <input type="hidden" name="harga_akhir">
              </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" form="form_promo" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div>
      <div class="card shadow">
        <div class="card-body">
          <p class="h5">Daftar Promoa</p>
          <hr>
          <table class="table" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Harga</th>
                <th>Harga Promo</th>
                <th></th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
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
  var harga_karya,harga_akhir;
  $('.table').DataTable({
    paging: true,
    lengthChange: true,
    autoWidth: true,
    processing: true,
    serverSide: true,
    orderable: true,
    searchable: true,
    searchDelay: 1000,
    ordering: false,
    scrollX: true,
    scrollCollapse: true,
    language: {
      processing: "Sedang diproses..."
    },
    ajax: {
      url: '{{route('marketing.gambar.get_promo')}}',
      type:'get',
      contentType: 'application/json',
      data:{
        id_user:'{{auth()->user()->id}}'
      }
    },
    columns: [
    {
      data: "id",
      render: function (data, type, row, meta){
        return meta.row + meta.settings._iDisplayStart + 1;
      }
    },
    {data: "nama"},
    {data: "gambar"
  },
  {data: "harga"},
  {data: "harga_akhir"},
  { data: null,
    render: function ( data, type, row ) {
      return '<div class="btn-group" role="group" aria-label="Basic example">'+
      '<button type="button" onclick="buat_promo('+data.id+')" class="btn btn-success" name="button">Promo</button>'+
      '</div>';
    }},
    ]
  });
  function buat_promo(id){
    $.ajax({
      url:'{{route('marketing.gambar.data_karya')}}',
      type:'get',
      data:{
        id:id
      },success:function(data){
        $('#modal_promo').modal('show');
        $('#harga_karya').html(rupiah(parseFloat(data.harga)))
        harga_karya = parseFloat(data.harga);
        harga_akhir = harga_karya;
        $('#harga_akhir').html(rupiah(harga_karya))
        $('[name=id_karya]').val(data.id)
      }
    })
  }
  function add_promo(e){
    value = e.value
    potongan = (value/100)*harga_karya
    harga_akhir = (harga_karya-potongan)
    $('#harga_akhir').html(rupiah(harga_akhir))
    $('[name=harga_akhir]').val(harga_akhir);
  }
  $('#form_promo').on('submit',function(e){
    e.preventDefault();
    data = new FormData(this);
    $.ajax({
      url:'{{route('marketing.gambar.add_promo')}}',
      type:'post',
      processData:false,
      contentType:false,
      data:data,
      success:function(data){
        $('#modal_promo').modal('hide');
        document.getElementById('form_promo').reset();
        $('.table').DataTable().ajax.reload();
        Toast.fire({
          icon: 'success',
          title: 'Berhasil menambah promo',
        });
      },error:function(data){
        Toast.fire({
          icon: 'error',
          title: 'Gagal menambah promo',
        });
      }
    });
  })
</script>
@endpush
