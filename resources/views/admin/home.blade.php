@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">DAFTAR GAJI    </div>
                <div class="card-body">
                    <table class="table" style="text-align: center" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Gaji</th>
                                <th>Tgl Gajian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach(DB::table('tb_gaji')->where('id_user',Auth()->user()->id)->get() as $key => $value)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{rupiah($value->gaji)}}</td>
                                <td>{{$value->tgl_gaji}}</td>
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
<script type="text/javascript">
    $('.table').DataTable();
</script>

@endpush