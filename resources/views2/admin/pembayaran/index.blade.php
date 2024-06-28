@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">
                <div class="card-body">
                  <p class="h5">Data Pembayaran</p>
                  <hr>
                    <table class="table" width="100%">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Gambar</th>
                          <th>Pembayaran</th>
                          <th>Status</th>
                          <th>Tanggal</th>
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
    $('#select_pemasar').select2({
       ajax: {
           url: '{{route('admin.anggota.get_json')}}',
           dataType: "json",
           type: "GET",
           data: function (params) {

               var queryParameters = {
                   term: params.term
               }
               return queryParameters;
           },
           processResults: function (data) {
               return {
                   results: $.map(data, function (item) {
                       return {
                           text: item.name,
                           id: item.id
                       }
                   })
               };
           }
       }
    });
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
        url: '{{route('admin.karya.get_data')}}',
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
        {data: "gambar"},
        {data: "pembayaran"},
        {data: "status"},
        {data: "jumlah"},
        {data: "tanggal"},
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
