@extends('layouts.admin.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card shadow">

                <div class="card-body">
                  <p class="h5">Daftar Transaksi</p>
                  <hr>
                    <table class="table" width="100%">
                      <thead>
                        <tr>
                          <th>No.</th>
                          <th>Gambar</th>
                          <th>Pembeli</th>
                          <th>Pembayaran</th>
                          <th>Total</th>
                          <th>status</th>
                          <th>Tanggal</th>
                          <th>Action</th>
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
        url: '{{route('marketing.transaksi.get_data')}}',
        type:'get',
        contentType: 'application/json',
        data:{
          user_id:'{{auth()->user()->id}}'
        }
      },
      columns: [
        {
          data: "id",
          render: function (data, type, row, meta){
            return meta.row + meta.settings._iDisplayStart + 1;
          }
        },
        {data: "gambar"},
        {data: "pembeli"},
        {data: "pembayaran"},
        {data: "harga"},
        {data: "status"},
        {data: "tanggal"},
        {data: null,
          render:function(data){
            if (data.flag != 'verif') {
              return '<button class="btn btn-success" onclick="verif('+data.id+')">Verifikasi</button>'
            }
            return '';
          }
        },
      ]
    });
    function verif(id){
      $.ajax({
        url:'{{route('marketing.transaksi.verifikasi')}}',
        type:'post',
        data:{
          '_token':'{{csrf_token()}}',
          id:id
        },success:function(data){
          $('.table').DataTable().ajax.reload();
        }
      });
    }
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
