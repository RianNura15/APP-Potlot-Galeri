@extends('layouts.pemilik.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
              <div class="modal fade" id="modal_detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Detail Anggota</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form id="edit_form">
                        @csrf
                        <input type="hidden" name="id_edit">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Nama</label>
                          <input name="nama_edit" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input name="email_edit" type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">No Telp</label>
                          <input name="telp_edit" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                      </form>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <button type="submit" form="edit_form" class="btn btn-primary">Save changes</button>
                    </div>
                  </div>
                </div>
              </div>

              <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title" id="exampleModalLongTitle">Form Admin</h5>
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                    <div class="modal-body">
                      <form id="admin_form">
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
                        <div class="form-group">
                          <label for="exampleInputEmail1">Nomor HP</label>
                          <input name="no_hp" type="number" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" >
                        </div>
                        <input type="hidden" name="role" value="anggota">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
                <div class="card-body">
                  <p class="h5">Daftar Marketing</p>
                  <button type="button" data-toggle="modal" data-target="#exampleModalCenter" class="btn btn-sm btn-info" name="button"> Tambah</button>
                  <hr>
                    <table class="table" width="100%">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Nama</th>
                          <th>Email</th>
                          <th>Role</th>
                          <th>Nomor HP</th>
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
        url: '{{route('pemilik.akun.get_data_admin')}}',
        type:'get',
        contentType: 'application/json',
        data:{
          role:'anggota',
        }
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
        {data: "role"},
        {data: "no_hp"},
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
        url:'{{route('pemilik.akun.show')}}',
        type:'get',
        data:{
          id:id
        },success:function(data){
          $('#modal_detail').modal('show')
          $('[name=id_edit]').val(data.id)
          $('[name=nama_edit]').val(data.name)
          $('[name=email_edit]').val(data.email)
          $('[name=telp_edit]').val(data.no_hp)
        }
      })
    }
    $('#edit_form').on('submit',function(e){
      e.preventDefault();
      var formData = new FormData(this);
      $.ajax({
        url:'{{route('pemilik.akun.update')}}',
        type:'post',
        processData:false,
        contentType:false,
        data:formData,
        success:function(data){
          $('.table').DataTable().ajax.reload();
          $('#modal_detail').modal('hide')
          document.getElemetById('edit_form').reset();
        },error:function(data){
          alert(data.responseJSON);
        }
      })
    })
    function hapus(id){
      $.ajax({
        url:'{{route('pemilik.akun.hapus')}}',
        type:'post',
        data:{
          '_token':'{{csrf_token()}}',
          id:id
        },success:function(data){
          $('.table').DataTable().ajax.reload();
        },error:function(data){
          alert(data.responseJSON);
        }
      })
    }
    $('#admin_form').on('submit',function(e){
      e.preventDefault();
      var formdata = new FormData(this)

      $.ajax({
        url:'{{route('pemilik.akun.insert_admin')}}',
        type:'post',
        processData:false,
        contentType:false,
        data:formdata,
        success:function(data){
          $('.table').DataTable().ajax.reload();
          $('#exampleModalCenter').modal('hide')
          document.getElemetById('admin_form').reset();
        },error:function(data){
          alert(data.responseJSON);
        }
      });
    })
  </script>
@endpush
