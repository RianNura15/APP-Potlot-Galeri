@extends('layouts.pemilik.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">DAFTAR GAJI ADMIN ( {{DB::table('users')->find($id)->name }} )</div>
                <div class="card-body row">
                    <div class="col-md-4 card">
                        <p class="h5">Input Gaji</p>
                        <hr>
                        <form action="{{url('pemilik/home/detail/gaji/')}}/{{$id}}">
                            <div class="input-group" id="gajian">
                                <input type="number" class="form-control" aria-label="gaji" id="gajian" name="gajian">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-success">Kirim</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-8 card">
                        <table class="table" style="text-align: center" width="100%">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Jumlah Gaji</th>
                                    <th>Waktu</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(DB::table('tb_gaji')->where('id_user',$id)->get() as $key => $value)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{rupiah($value->gaji)}}</td>
                                    <td>{{$value->tgl_gaji}}</td>
                                    <td>
                                        @include('pemilik.gaji.ubah')
                                        <button type="button" data-toggle="modal" data-target="#ubah{{$loop->iteration}}" class="btn btn-sm btn-info">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="{{url('pemilik/home/detail/delete/')}}/{{$id}}/delete/{{$value->tgl_gaji}}" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripting')
<script type="text/javascript">
    u_gaji();

    function u_gaji() {
        $('.table').DataTable();
    }
</script>

@endpush
