@extends('layouts.pemilik.app')

@push('styleshet')
  <link rel="stylesheet" href="{{asset('public\sb_admin\vendor\datatables\dataTables.bootstrap4.min.css')}}">
@endpush

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">DAFTAR ADMIN</div>
                <div class="card-body">
                    <table class="table" style="text-align: center" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Admin</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(DB::table('users')->where('role','admin')->get() as $key => $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$value->name}}</td>
                                <td>
                                    <a href="{{url('pemilik/home/detail')}}/{{$value->id}}" class="btn btn-success">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
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
    $('.table').DataTable();
</script>

@endpush
