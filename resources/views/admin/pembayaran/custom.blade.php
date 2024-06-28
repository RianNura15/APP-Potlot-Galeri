@extends('layouts.admin.app')

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
      url: '{{route('admin.pembayaran.get_data_custom')}}',
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
        return "<a href='{{url('admin/pembayaran/custom')}}/"+data.id+"' class='btn btn-success'>CEK PENDAPATAN</a>";
        // return '<a href="{{url('admin/pembayaran/detail/data.id')}}" class="btn btn-success">CEK PENDAPATAN</a>';
      }
    },
    ]
  });
</script>
@endpush
