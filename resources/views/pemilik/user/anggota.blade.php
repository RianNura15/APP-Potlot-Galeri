@extends('layouts.pemilik.app')

@push('styleshet')
  <link rel="stylesheet" href="{{asset('public\sb_admin\vendor\datatables\dataTables.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow">
        @include('pemilik.user.modal_detail')
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Form Anggota</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form>
                  @csrf
                  <div class="form-group">
                    <label for="exampleInputEmail1">Nama</label>
                    <input name="nama" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                  </div>
                  <div class="form-group">
                    <label for="exampleInputEmail1">Email</label>
                    <input name="email" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                  </div>
                  <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input name="password" type="password" class="form-control" id="exampleInputPassword1">
                  </div>
                  <button type="button" onclick="simpan()" class="btn btn-primary">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div class="card-body">
          <p class="h5">Daftar Anggota</p>
          <button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-sm btn-info" name="button"> Tambah</button>
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
<script src="{{asset('public\sb_admin\vendor\datatables\jquery.dataTables.min.js')}}" charset="utf-8"></script>
<script src="{{asset('public\sb_admin\vendor/datatables/dataTables.bootstrap4.min.js')}}" charset="utf-8"></script>
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
      url: '{{route('pemilik.user.get_anggota')}}',
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
      url:'{{route('pemilik.user.detail_anggota')}}',
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
      url:'{{route('pemilik.user.verif_anggota')}}',
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
  $('#edit').on('submit',function(e){
    e.preventDefault();
    var data = new FormData(this)
    $.ajax({
      url:'{{route('pemilik.user.edit')}}',
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
      url:'{{route('pemilik.user.delete_anggota')}}',
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
