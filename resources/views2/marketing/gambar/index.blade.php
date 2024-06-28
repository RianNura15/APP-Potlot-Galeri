@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="modal fade" id="modalpemasar" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLongTitle">Pilih Pemasar</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <form id="form_pemasar">
                    @csrf
                    <input type="hidden" name="id_karya_modal">
                    <select name="pemasar" class="form-control" style="width:100%" id="select_pemasar">
                    </select>
                  </form>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" form="form_pemasar" class="btn btn-primary">Save changes</button>
                </div>
              </div>
            </div>
          </div>
            <div class="card shadow">
                <div class="card-body">
                  <p class="h5">Data Karya</p>
                  <hr>
                    <table class="table" width="100%">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Nama Gambar</th>
                          <th>Harga</th>
                          <th>Tanggal Masuk</th>
                          <th>Status</th>
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
        url: '{{route('marketing.gambar.get_data')}}',
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
        {data: "harga"},
        {data: "created_at"},
        {data: "status"},
        { data: null,
          render: function ( data, type, row ) {
          return '<div class="btn-group" role="group" aria-label="Basic example">'+
                    '<button onclick="tambah_pemasar('+data.id+')" class="btn btn-sm btn-info"><i class="fa fa-folder-open-o" aria-hidden="true"></i>View Gambar</button>'+
                  '</div>';
        }},
      ]
    });
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
    function hapus(id){
      $.ajax({
        url:'{{route('admin.karya.delete')}}',
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
        url:'{{route('admin.karya.tambah_pemasar')}}',
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
