<table id="example" class="display" style="width: 100%">
  <thead style="background-color: rgb(17, 82, 114); color: white">
    <tr>
      <th width="25%">Nama Pegawai</th>
      <th width="10%">Jumlah Maklumbalas (Tutup)</th>
      <th width="10%">Jumlah Aduan Dicipta</th>
      <th width="10%">Jumlah Keseluruhan</th>
      <th width="10%">Peratusan (%)</th>
    </tr>
  </thead>
  <tbody>
    @foreach($data_final as $datum)
    <tr>
      <td>{{ $datum["name"] }}</td>
      <td>{{ $datum["close"] }}</td>
      <td>{{ $datum["ticket"] }}</td>
      <td>{{ $datum["total"] }}</td>
      <td>{{ $datum["pct"] }}</td>
    </tr>
    @endforeach
  </tbody>
  <tfoot>
    <tr style="background-color: lightblue">
      <th>Jumlah</th>
      @foreach($data_final_total_by_type as $datum)
      <th>{{ $datum }}</th>
      @endforeach
      <th>100.00</th>
    </tr>
  </tfoot>
</table>

<div class="highcharts-figure" style="margin-top: 10px">
  <div id="container" style="width: 100%; height: 600px"></div>
</div>

<script src="/js/plugins/highcharts/highcharts.js"></script>
<script src="/js/plugins/highcharts/modules/stock.js"></script>
<script src="/js/plugins/highcharts/modules/map.js"></script>
<script src="/js/plugins/highcharts/highmaps.js"></script>

<script type="text/javascript">
  document.addEventListener("DOMContentLoaded", function () {
    var name = {!! json_encode($name_list) !!}
    var close = {!! json_encode($close_list) !!}
    var ticket = {!! json_encode($ticket_list) !!}
    var mula = {!! json_encode($date_start) !!}
    var tamat = {!! json_encode($date_end) !!}
    var subss = mula+" hingga "+tamat;
    console.log(subss);

    const chart = Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Laporan Statistik Kecekapan Pegawai Pengurusan Maklumat Aplikasi Whatsapp'
    },
    subtitle: {
        text: mula+" hingga "+tamat,
    },
    xAxis: {
        categories: name,
        title: {
            text: null
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: '',
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        }
    },
    tooltip: {
        valueSuffix: ''
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        x: -40,
        y: 80,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF',
        shadow: true
    },
    credits: {
        enabled: false
    },
    series: [{
        name: 'Jumlah Maklumbalas',
        data: close
    }, {
        name: 'Jumlah cipta aduan',
        data: ticket
    }]
});
  });
</script>
