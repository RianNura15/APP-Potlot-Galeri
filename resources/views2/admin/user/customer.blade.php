@extends('layouts.admin.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow">
        @include('admin.user.modal_detail')
        <div class="card-body">
          <p class="h5">Daftar Customer</p>
          <hr>
          <table class="table" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
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
@push('scripting')
<script type="text/javascript">
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
      url: '{{route('admin.customer.get_customer')}}',
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
    {data: "name"},
    {data: "email"},
    { data: null,
      render: function ( data, type, row ) {
        if (data.verif=='login') {
          return '<div class="btn-group" role="group" aria-label="Basic example">'+
          '<button onclick="detail('+data.id+')" class="btn btn-sm btn-info"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Detail Anggota</button>'+
          '<button class="btn btn-sm btn-danger" onclick="hapus('+data.id+')"> Hapus</button>'+
          '</div>';
        }
        else{
          return '<div class="btn-group" role="group" aria-label="Basic example">'+
          '<button onclick="detail('+data.id+')" class="btn btn-sm btn-info"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Detail Anggota</button>'+
          '<button class="btn btn-sm btn-warning" onclick="verif('+data.id+')"> Verif</button>'+
          '<button class="btn btn-sm btn-danger" onclick="hapus('+data.id+')"> Hapus</button>'+
          '</div>';
        }
      }},
      ]
    });
  function detail(id){
    $.ajax({
      url:'{{route('admin.user.detail_anggota')}}',
      type:'get',
      data:{
        id:id
      },success:function(data){
        $('#modal_detail').modal('show');
        $('[name=id_edit]').val(data.id)
        $('[name=nama_edit]').val(data.name)
        $('[name=email_edit]').val(data.email)
      }
    })
  }
  function verif(id) {
    $.ajax({
      url:'{{route('admin.user.verif_anggota')}}',
      type:'post',
      data:{
        '_token':'{{csrf_token()}}',
        id:id
      },success: function(data){
        $('.table').DataTable().ajax.reload();
      },error: function(data){
      }
    })
  }
  function simpan(){
    data = $('form').serializeArray();
    $.ajax({
      url:'{{route('admin.user.add_anggota')}}',
      type:'post',
      data:data,
      success: function(data){
        $('.table').DataTable().ajax.reload();
        $('#exampleModalCenter').modal('hide');
      },error: function(data){

      }
    })
  }
  $('#edit').on('submit',function(e){
    e.preventDefault();
    var data = new FormData(this)
    $.ajax({
      url:'{{route('admin.user.edit')}}',
      type:'post',
      processData:false,
      contentType:false,
      data:data,
      success:function(data){
        $('.table').DataTable().ajax.reload();
        $('#modal_detail').modal('hide');
      }
    })
  });
  function hapus(id){
    $.ajax({
      url:'{{route('admin.user.delete_anggota')}}',
      type:'post',
      data:{
        '_token':'{{csrf_token()}}',
        id:id
      },success: function(data){
        $('.table').DataTable().ajax.reload();
      },error: function(data){
      }
    })
  }
</script>
@endpush
