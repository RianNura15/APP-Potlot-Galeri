@extends('layouts.pemilik.app')

@push('styleshet')
  <link rel="stylesheet" href="{{asset('public\sb_admin\vendor\datatables\dataTables.bootstrap4.min.css')}}">
@endpush

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
                  <label for="harga_promo">Promo (%)</label>
                  <input type="number" name="promo" onkeyup="add_promo(this)" class="form-control" id="harga_promo">
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
          <p class="h5">Daftar Promo</p>
          <hr>
          <table class="table" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Gambar</th>
                <th>Harga</th>
                <th>Promo</th>
                <th>Harga Promo</th>
                <th>Aksi</th>
              </tr>
            </thead>
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
      url: '{{route('pemilik.karya.get_data')}}',
      type:'get',
      contentType: 'application/json',
    },
    columns: [
    {
      data: "id",
      render: function (data, type, row, meta){
        return meta.row + meta.settings._iDisplayStart + 1;
      }
    },
    {data: "nama"},
    {data: null,
      render : function(data,type,row){
        return '<img src="{{asset('public/images/')}}'+'/'+data.gambar+'" width="100px" height="100px">';
      }
    },
    {data: "harga"},
    {data: null,
      render: function (data) {
        return data.promo+" %";
      }
    },
    {data: null,
      render: function (data) {
        var z = data.harga1-(data.promo/100)*data.harga1
        return rupiah(parseFloat(z));
      }
    },
    { data: null,
      render: function ( data, type, row ) {
        return '<div class="btn-group" role="group" aria-label="Basic example">'+
        '<button type="button" onclick="buat_promo('+data.id+')" class="btn btn-success" name="button">Promo</button>'+
        '</div>';
      }
    },
    ]
  });
  function buat_promo(id){
    $.ajax({
      url:'{{route('pemilik.karya.data_karya')}}',
      type:'get',
      data:{
        id:id
      },success:function(data){
        $('#modal_promo').modal('show');
        $('#harga_karya').html(rupiah(parseFloat(data.harga)));
        if (data.promo>0) {
          $('#harga_promo').val(data.promo);
          harga_karya = parseFloat(data.harga);
          harga_akhir = harga_karya-(data.promo/100)*harga_karya;
        }
        else{
          $('#harga_promo').val(0);
          harga_karya = parseFloat(data.harga);
          harga_akhir = harga_karya;
        }
        $('#harga_akhir').html(rupiah(harga_akhir))
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
      url:'{{route('pemilik.promo.add_promo')}}',
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
  function simpan(){
    data = $('form').serializeArray();
    $.ajax({
      url:'{{route('pemilik.user.add_anggota')}}',
      type:'post',
      data:data,
      success: function(data){
        $('.table').DataTable().ajax.reload();
        $('#exampleModalCenter').modal('hide');
      },error: function(data){

      }
    })
  }
  function hapus(id){
    $.ajax({
      url:'{{route('pemilik.karya.delete')}}',
      type:'post',
      data:{
        '_token':'{{csrf_token()}}',
        id:id
      },success: function(data){
        $('.table').DataTable().ajax.reload();
        Toast.fire({
          icon: 'success',
          title: 'Berhasil menghapus lukisan',
        });
      },error: function(data){
      }
    })
  }
  function tambah_pemasar(id){
    $('#modalpemasar').modal('toggle')
    $('[name=id_karya_modal]').val(id)
  }
  $('#form_pemasar').on('submit',function(e){
    data = new FormData(this)
    $.ajax({
      url:'{{route('pemilik.karya.tambah_pemasar')}}',
      type:'post',
      data:data,
      contentType: false,
      processData: false,
      success:function(data){
        Toast.fire({
          icon: 'success',
          title: 'Berhasil menambahkan pemasar',
        });
        $('#modalpemasar').modal('toggle')
        $('.table').DataTable().ajax.reload();
      },error:function(data){
        Toast.fire({
          icon: 'error',
          title: 'Gagal menambahkan pemasar',
        });
      }
    })
    e.preventDefault();
  })
</script>
@endpush
