@extends('layouts.pemilik.app')

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
        url: '{{route('pemilik.transaksi.get_data')}}',
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
      ]
    });
  </script>
@endpush
