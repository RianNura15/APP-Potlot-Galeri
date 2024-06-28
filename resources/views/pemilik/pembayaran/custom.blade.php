@extends('layouts.pemilik.app')

@push('styleshet')
  <link rel="stylesheet" href="{{asset('public\sb_admin\vendor\datatables\dataTables.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-body">
          <p class="h5">Daftar Pendapatan Custom</p>
          <hr>
          <table class="table" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Lihat Pendapatan</th>
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
    searchable: false,
    searchDelay: 1000,
    ordering: false,
    scrollX: true,
    scrollCollapse: true,
    language: {
      processing: "Sedang diproses..."
    },
    ajax: {
      url: '{{route('pemilik.pembayaran.get_data_custom')}}',
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
    {data: null,
      render:function(data, type, row){
        return "<a href='{{url('pemilik/pembayaran/custom')}}/"+data.id+"' class='btn btn-success'>CEK PENDAPATAN</a>";
        // return '<a href="{{url('pemilik/pembayaran/detail/data.id')}}" class="btn btn-success">CEK PENDAPATAN</a>';
      }
    },
    ]
  });
</script>
@endpush
