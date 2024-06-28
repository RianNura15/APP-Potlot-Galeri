@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
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
      // data:{
      //   id_user:'{{auth()->user()->id}}'
      // }
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
    {data: null,
      render: function(data){
        return rupiah(data.harga)
      }
    },
    {data: null,
      render: function (data) {
        return data.promo+" %";
      }
    },
    {data: null,
      render: function (data) {
        // var z = parseFloat(data.harga1-parseFloat((parseFloat(data.promo/100).toFixed(2))*data.harga1).toFixed(2)).toFixed(2)
        var z = parseFloat(data.harga).toFixed(2)-parseFloat(parseFloat(data.harga).toFixed(2)*parseFloat(data.promo).toFixed(2)/100).toFixed(2)
        var zz = z.toString().split(".");
        if (zz[1]==null) {
          zz[1]=0
        }
        return rupiah(zz[0])+','+zz[1];
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
      url:'{{route('marketing.gambar.data_karya')}}',
      type:'get',
      data:{
        id:id
      },success:function(data){
        $('#modal_promo').modal('show');
        $('#harga_karya').html(rupiah(parseFloat(data.promo)));
        if (data.promo>0) {
          $('#harga_promo').val(data.promo);
          harga_karya = parseFloat(data.harga);
          harga_akhir = harga_karya-(data.promo/100)*harga_karya;
          
          var harga_akhir = parseFloat(harga_karya).toFixed(2)-parseFloat(parseFloat(harga_karya).toFixed(2)*parseFloat(data.promo).toFixed(2)/100).toFixed(2)
          var harga_akhirr = harga_akhir.toString().split(".");
          if (harga_akhirr[1]==null) {
            harga_akhirr[1]=0
          }

          $('#harga_akhir').html(rupiah(harga_akhirr[0])+','+harga_akhirr[1])
        }
        else{
          $('#harga_promo').val(0);
          harga_karya = parseFloat(data.harga);
          harga_akhir = harga_karya;
          $('#harga_akhir').html(rupiah(harga_akhir))
        }

        $('[name=id_karya]').val(data.id)
      }
    })
  }
  function add_promo(e){
    value = e.value
    // potongan = (value/100)*harga_karya
    // harga_akhir = (harga_karya-potongan)

    var harga_akhir = parseFloat(harga_karya).toFixed(2)-parseFloat(parseFloat(harga_karya).toFixed(2)*parseFloat(value).toFixed(2)/100).toFixed(2)
    var harga_akhirr = harga_akhir.toString().split(".");
    if (harga_akhirr[1]==null) {
      harga_akhirr[1]=0
    }

    $('#harga_akhir').html(rupiah(harga_akhirr[0])+','+harga_akhirr[1])
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
          title: 'Berhasil menambah data promo '+data,
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