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
            <select name="tahun" id="tahun" class="form-control mr-3">
              @for ($i = 2020; $i <= date('Y'); $i++)
                  <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
              @endfor
            </select>
            <select name="bulan" id="bulan" class="form-control">
              @foreach ($data['bulan'] as $index => $bulan)
                  <option value="{{ $index + 1 }}" {{ $index + 1 == date('n') ? 'selected' : '' }}>{{ $bulan }}</option>
              @endforeach
            </select>
          </div>
          <hr>
          <div class="card-body">
            <h1 style="font-size: 30px; margin-bottom: 40px; font-weight: 600;">Grafik Tahun <span id="get-tahun"></span></h1>
            <div class="chart-area" id="ch">
              <canvas id="myAreaChart"></canvas>
            </div>
            <h1 style="margin-top: 30px; font-size: 20px;">Total Pendapatan Tahun <span id="get-tahun2"></span> = <span id="t_cstm1" style="font-weight: 700;"></span></h1>
          </div>
          <hr>
          <div class="card-body">
            <h1 style="font-size: 30px; margin-bottom: 40px; font-weight: 600;">Grafik Bulan <span id="get-bulan"></span></h1>
            <div class="chart-area" id="ch">
              <canvas id="myBarChart"></canvas>
            </div>
            <h1 style="margin-top: 30px; font-size: 20px;">Total Pendapatan Bulan <span id="get-bulan2"></span> = <span id="total-bulan" style="font-weight: 700;"></span></h1>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-12">
      <div class="card shadow">
        <div class="card-header">
          <p class="h5">Daftar Pendapatan Pemesanan</p>
        </div>
        <div class="card-body">
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
@push('scripting')
<script src="{{asset('public/sb_admin/vendor/chart.js/Chart.min.js')}}"></script>
<script type="text/javascript">
  $a = 0;

  function getBulan() {
    var bulan = $('#bulan').val()
    let namaBulan = ["Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember"]

    $('#get-bulan').html(namaBulan[bulan - 1])
    $('#get-bulan2').html(namaBulan[bulan - 1])
  }

  getBulan()

  function getTahun() {
    var tahun = $('#tahun').val()

    $('#get-tahun').html(tahun)
    $('#get-tahun2').html(tahun)
  }

  getTahun()

  function totalTahun() {
    var tahun = $('#tahun').val()

    $.ajax({
      url:'{{route('marketing.pendapatan.t_cstm')}}',
      type:'GET',
      data: {
        tahun: tahun
      },
      success: function(data){
        $('#t_cstm1').html(rupiah(data));
      },
      error: function(data){
        $('#t_cstm1').html(0);
      }
    })
  }

  totalTahun()
  
  function totalBulan() {
    var tahun = $('#tahun').val()
    var bulan = $('#bulan').val()

    $.ajax({
      url:'{{route('marketing.pendapatan.total_harga_bulan_cstm')}}',
      type:'GET',
      data: {
        tahun: tahun,
        bulan: bulan
      },
      success: function(data){
        $('#total-bulan').html(rupiah(data));
      },
      error: function(data){
        $('#total-bulan').html(0);
      }
    })
  }

  totalBulan()
  
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
        url: '{{ route('marketing.pendapatan.get_data_cstm') }}',
        type: 'GET',
        data: function(d) {
            d.tahun = $('#tahun').val();
            d.bulan = $('#bulan').val();
        },
        error: function(xhr, error, code) {
            console.log(xhr);
            console.log(code);
            console.log(error);
        }
    },
    columns: [
        {
            data: "id",
            render: function(data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        {data: "nama_gambar"},
        {data: "gambar"},
        {data: "pemesan"},
        {data: "harga"},
        {
          data: "pesan",
          render: function(data, type, row) {
              const date = new Date(data);
              const options = { year: 'numeric', month: 'long', day: 'numeric' };
              return date.toLocaleDateString('id-ID', options);
          }
        },
        {data: "bayar"},
    ]
  });

  $('#tahun, #bulan').on('change', function() {
    $('.table_cstm').DataTable().ajax.reload();
    showcart()
    showcart2()
    totalTahun()
    totalBulan()
    getTahun()
    getBulan()
  });
  
  showcart()

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
    var tahun = $('#tahun').val();

    $.ajax({
      url: '{{ route("marketing.pendapatan.get_data_tahun_cstm") }}',
      type: 'GET',
      data: {
          tahun: tahun,
      },
      success: function(response) {
        var ctx = document.getElementById("myAreaChart");

        if (window.myLineChart) {
            window.myLineChart.destroy();
        }

        window.myLineChart = new Chart(ctx, {
          type: 'line',
          data: {
            labels: response.bulan,
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
              data: response.isi,
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
                  beginAtZero: true,
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
    })
  }

  showcart2()

  function showcart2() {
    var tahun = $('#tahun').val();
    var bulan = $('#bulan').val();

    $.ajax({
      url: '{{ route("marketing.pendapatan.get_data_bulan_cstm") }}',
      type: 'GET',
      data: {
          tahun: tahun,
          bulan: bulan
      },
      success: function(response) {
        var ctx1 = document.getElementById("myBarChart");

        if (window.mySecondChart) {
            window.mySecondChart.destroy();
        }

        window.mySecondChart = new Chart(ctx1, {
          type: 'bar',
          data: {
            labels: response.tanggal_lengkap,
            datasets: [{
              label: "Pendapatan",
              lineTension: 0.3,
              backgroundColor: "rgba(78, 115, 223, 1)",
              borderColor: "rgba(78, 115, 223, 1)",
              pointRadius: 1,
              pointBackgroundColor: "rgba(78, 115, 223, 1)",
              pointBorderColor: "rgba(78, 115, 223, 1)",
              pointHoverRadius: 3,
              pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
              pointHoverBorderColor: "rgba(78, 115, 223, 1)",
              pointHitRadius: 10,
              pointBorderWidth: 2,
              data: response.isi,
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
                  maxTicksLimit: 31
                }
              }],
              yAxes: [{
                ticks: {
                  maxTicksLimit: 5,
                  beginAtZero: true,
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
    })
  }

</script>
@endpush
