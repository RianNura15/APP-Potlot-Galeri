@extends('layouts.admin.app')

@section('content')
<div class="container-fluid">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow mb-4">
        <div class="card-header">
          <p class="h5">Data Pendapatan Custom <!-- ( dibayar <span id="d_cstm1"></span>, belum dibayar <span id="b_cstm1"></span> , total <span id="t_cstm1"></span> ) --></p>
        </div>
        <div class="card-body">
          <div class="d-flex flex">
            <select name="tahun" id="tahun" class="form-control">
              @foReach($data['tgl'] as $tahun)
              <option value="{{$tahun->tahun}}" <?= $tahun->tahun==DATE('Y')? 'selected' : '' ?> >{{$tahun->tahun}}</option>
              @endforeach
            </select>
            <button class="btn btn-success" onclick="Tahun()">CEK</button>
          </div>
          <hr>
          <div class="card-body">
            <div class="chart-area" id="ch">
              <canvas id="myAreaChart"></canvas>
            </div>
            <div class="chart-area" id="ch2">
              <canvas id="myAreaChart2"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-body">
          <p class="h5">Daftar Pendapatan Custom ( dibayar <span id="d_cstm"></span>, belum dibayar <span id="b_cstm"></span> , total <span id="t_cstm"></span> )</p>
          <table class="table_cstm" width="100%">
            <thead>
              <tr>
                <th>No.</th>
                <th>Nama Gambar</th>
                <th>Gambar</th>
                <th>Pemesan</th>
                <th>Harga</th>
                <th>Tgl Pesan</th>
                <th>Status</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
<?php 
$bul = [];
$is = [];
?>
@push('scripting')
<script src="{{asset('public/sb_admin/vendor/chart.js/Chart.min.js')}}"></script>
<script type="text/javascript">
  $a =0;
  $.ajax({
    url:'{{route('marketing.pendapatan.d_cstm')}}',
    type:'get',
    success: function(data){
      $('#d_cstm1').html(rupiah(data));
      $('#d_cstm').html(rupiah(data));
    },error: function(data){
      $('#d_cstm1').html(0);
      $('#d_cstm').html(0);
    }
  });
  $.ajax({
    url:'{{route('marketing.pendapatan.b_cstm')}}',
    type:'get',
    success: function(data){
      $('#b_cstm1').html(rupiah(data));
      $('#b_cstm').html(rupiah(data));
    },error: function(data){
      $('#b_cstm1').html(0);
      $('#b_cstm').html(0);
    }
  });
  $.ajax({
    url:'{{route('marketing.pendapatan.t_cstm')}}',
    type:'get',
    success: function(data){
      $('#t_cstm1').html(rupiah(data));
      $('#t_cstm').html(rupiah(data));
    },error: function(data){
      $('#t_cstm1').html(0);
      $('#t_cstm').html(0);
    }
  });
  $('.table_cstm').DataTable({
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
      url: '{{route('marketing.pendapatan.get_data_cstm')}}',
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
    {data: "nama_gambar"},
    {data: "gambar"},
    {data: "pemesan"},
    {data: "harga"},
    {data: "pesan"},
    {data: "bayar"},
    ]
  });
  function Tahun() {
    // console.log({!!json_encode($data['bulan'])!!});
    // console.log($('#tahun').val());
    $a+=1;
    $.ajax({
      url:'{{route('marketing.pendapatan.get_grafik_cstm')}}',
      type:'get',
      data:{
        'tahun':$('#tahun').val()
      },
      success:function(data){
        $bul = data['bulan'];
        $is = data['isi'];
        showcart1();
        // console.log($bul,$is);
      },
      error:function(data){
        // console.log(data);
      }

    });
  }
  showcart();
  function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + '').replace(',', '').replace(' ', '');
    var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
      s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
      s[1] = s[1] || '';
      s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
  }
  function showcart() {
    var ctx = document.getElementById("myAreaChart");
    $('#ch2').hide();
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: {!!json_encode($data['bulan'])!!},
        datasets: [{
          label: "Pendapatan",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: {!!json_encode($data['isi'])!!},
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              callback: function(value, index, values) {
                return 'Rp. ' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
            }
          }
        }
      }
    })
  }
  function showcart1() {
    // console.log('show',$bul,$is);
    $('#ch').hide();
    $('#ch2').show();
    var ctx = document.getElementById("myAreaChart2");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        // labels: {!!json_encode($bul)!!},
        labels: $bul,
        datasets: [{
          label: "Pendapatan",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 1,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: $is,
        }],
      },
      options: {
        maintainAspectRatio: false,
        layout: {
          padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
          }
        },
        scales: {
          xAxes: [{
            time: {
              unit: 'date'
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }],
          yAxes: [{
            ticks: {
              maxTicksLimit: 5,
              padding: 10,
              callback: function(value, index, values) {
                return 'Rp. ' + number_format(value);
              }
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }],
        },
        legend: {
          display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
            label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel);
            }
          }
        }
      }
    }) 
  }
</script>
@endpush
