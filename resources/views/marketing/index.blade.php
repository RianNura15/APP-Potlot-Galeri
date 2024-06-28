@extends('layouts.admin.app')

@section('content')
<!-- <div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
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
    </div>
</div> -->
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header">{{ __('Komisi yang Diperoleh') }}</div>
                <div class="card-body">
                    <div style="width: 100%; overflow-x: auto;">
                        <table style="width: 100%; text-align: left; border-collapse: collapse;">
                            <tr style="display: flex; justify-content: space-between;">
                                <td style="flex: 1; min-width: 100px; padding: 5px;">Pendapatan</td>
                                <td style="flex: 0; min-width: 10px; padding: 5px;">:</td>	
                                <td style="flex: 2; min-width: 150px; padding: 5px;">Total Biasa + Total Custom</td>
                            </tr>
                            <tr style="display: flex; justify-content: space-between;">
                                <td style="flex: 1; min-width: 100px; padding: 5px;"></td>
                                <td style="flex: 0; min-width: 10px; padding: 5px;">:</td>	
                                <td style="flex: 2; min-width: 150px; padding: 5px;">Rp. {{number_format($data['totalcart'],2,',','.')}} + Rp. {{number_format($data['totalcustom'],2,',','.')}}</td>
                            </tr>
                            <tr style="display: flex; justify-content: space-between;">
                                <td style="flex: 1; min-width: 100px; padding: 5px;">Hasil Pendapatan</td>
                                <td style="flex: 0; min-width: 10px; padding: 5px;">:</td>	
                                <td style="flex: 2; min-width: 150px; padding: 5px;">Pendapatan x 10%</td>
                            </tr>
                            <tr style="display: flex; justify-content: space-between;">
                                <td style="flex: 1; min-width: 100px; padding: 5px;"></td>
                                <td style="flex: 0; min-width: 10px; padding: 5px;">:</td>	
                                <td style="flex: 2; min-width: 150px; padding: 5px;">Rp. {{number_format($data['komisi'],2,',','.')}} x 10%</td>
                            </tr>
                            <tr style="display: flex; justify-content: space-between;">
                                <td style="flex: 1; min-width: 100px; padding: 5px;">Komisi</td>
                                <td style="flex: 0; min-width: 10px; padding: 5px;">:</td>	
                                <td style="flex: 2; min-width: 150px; padding: 5px;"><h3 style="font-weight: bold;">Rp. {{number_format(10/100*$data['komisi'],2,',','.')}}</h3>( Peringkat {{$data['peringkat_anda']}} )</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Peringkat Pendapatan</h6>
                </div>
                <div class="card-body">
                    @foreach($data['data_peringkat'] as $key => $value)
                    <div class="card border-left-success shadow mb-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <!-- Earnings (Annual) -->
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{DB::table('users')->where('id','=',$value['nama'])->first()->name}}</div>
                                </div>
                                <div class="col-auto">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{$loop->iteration}}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
