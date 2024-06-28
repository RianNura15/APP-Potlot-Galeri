@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
              @include('admin.user.modal_detail')
              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Form Pelukis</h5>
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
                  <p class="h5">Daftar Pelukis</p>
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
@push('script')
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
        url: '{{route('admin.user.get_pelukis')}}',
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
          return '<div class="btn-group" role="group" aria-label="Basic example">'+
                    '<button onclick="detail('+data.id+')" class="btn btn-sm btn-info"><i class="fa fa-folder-open-o" aria-hidden="true"></i> Detail Anggota</button>'+
                    '<button class="btn btn-sm btn-danger" onclick="hapus('+data.id+')"> Hapus</button>'+
                  '</div>';
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
    function simpan(){
      data = $('form').serializeArray();
      $.ajax({
        url:'{{route('admin.user.add_pelukis')}}',
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
