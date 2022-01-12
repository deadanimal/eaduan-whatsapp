<table id="example" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%">
  <thead>
    <tr>
      <th width="30%">Kategori</th>
      @for($i = 1; $i < 13; $i++)
      <th style="color: white">
        @if($gen=='w')
        <a
          href="{{ route('laporan.feedback.r3.index') }}?year={{
            $year
          }}&month={{ $i }}"
          >{{Carbon\Carbon::createFromFormat('m', $i)->format('M')}}</a
        >
        @else
        {{Carbon\Carbon::createFromFormat('m', $i)->format('M')}}
        @endif
      </th>
      @endfor
      <th width="10%">Jumlah</th>
      <th width="10%">Peratusan (%)</th>
    </tr>
  </thead>
  <tbody>
    <tr style="background-color: lightblue">
      <th>Aduan KPDNHEP</th>
      @foreach($data_final_case_info as $datum)
      <th>{{ $datum }}</th>
      @endforeach
      <th>{{ $data_final_pct["case_info"]["total"]["total"] }}</th>
    </tr>
    <tr>
      <td>Aduan KPDNHEP</td>
      @foreach($data_final_case_info as $datum)
      <td>{{ $datum }}</td>
      @endforeach
      <td></td>
    </tr>
    @foreach($data_final as $key => $data_final_datum)
    <tr style="background-color: lightblue">
      <th>{{ $category_name[$key] }}</th>
      @foreach($data_final_datum['total'] as $datum)
      <th>{{ $datum }}</th>
      @endforeach
      <th>{{ $data_final_pct[$key]["total"]["total"] }}</th>
    </tr>
    @foreach($data_final_datum['child'] as $k => $datum_child)
    <tr>
      <td>{{ $template_by_title[$k] }}</td>
      @foreach($datum_child as $datum)
      <td>{{ $datum }}</td>
      @endforeach
      <td></td>
    </tr>
    @endforeach @endforeach
  </tbody>
  <tfoot>
    <tr style="background-color: lightblue">
      <th>Jumlah Maklumbalas</th>
      @foreach($data_final_total['total'] as $datum)
      <td>
        <b>{{ $datum }}</b>
      </td>
      @endforeach
      <td><b>100.00</b></td>
    </tr>
  </tfoot>
</table>

<div class="highcharts-figure">
  <div id="container" style="width: 100%; height: 600px"></div>
</div>

<script src="/js/plugins/highcharts/highcharts.js"></script>
<script src="/js/plugins/highcharts/modules/stock.js"></script>
<script src="/js/plugins/highcharts/modules/map.js"></script>
<script src="/js/plugins/highcharts/highmaps.js"></script>

<script type="text/javascript">

  document.addEventListener("DOMContentLoaded", function () {
    var data_final = {!! json_encode($data_final) !!}
    var data_final_case_info = {!! json_encode($data_final_case_info) !!}

    var tahun = {!! json_encode($year) !!}
    // console.log(tahun);
    var aduan = data_final_case_info
    const aduanValues = Object.values(aduan);
    aduanValues.pop()

    var lbk_total = data_final.lbk.total
    const lbkValues = Object.values(lbk_total);
    lbkValues.pop()

    var qna_total = data_final.qna.total
    const qnaValues = Object.values(qna_total);
    qnaValues.pop()

    var tl_total = data_final.tl.total
    const tlValues = Object.values(tl_total);
    tlValues.pop()

    var agensi_total = data_final.agensi.total
    const agensiValues = Object.values(agensi_total);
    agensiValues.pop()

    var scam_total = data_final.scam.total
    const scamValues = Object.values(scam_total);
    scamValues.pop()

    var ttpm_total = data_final.ttpm.total
    const ttpmValues = Object.values(ttpm_total);
    ttpmValues.pop()

    const chart = Highcharts.chart('container', {
        chart: {
            type: 'column'
        },
        title: {
            text: 'Laporan Statistik Bulanan Maklumbalas Melalui Aplikasi Whatsapp'
        },
        subtitle: {
            text: tahun
        },
        xAxis: {
            categories: [
              'Jan',
              'Feb',
              'Mar',
              'Apr',
              'May',
              'Jun',
              'Jul',
              'Aug',
              'Sep',
              'Oct',
              'Nov',
              'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} mm</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'Aduan KPDNKK',
            data: aduanValues

        },{
            name: 'LBK',
            data: lbkValues

        }, {
            name: 'QNA',
            data: qnaValues

        }, {
            name: 'TL',
            data: tlValues

        }, {
            name: 'AGENSI',
            data: agensiValues

        },
        {
            name: 'SCAM',
            data: scamValues

        },{
            name: 'TTPM',
            data: ttpmValues

        }]
    });
  });
</script>

<script type="text/javascript">
$(document).ready(function() {
	$('#example').DataTable({
		dom: 'Bfrtip',
		buttons: [
			{
			extend: 'copy',
			title: ''
			},
			{
			extend: 'csv',
			title: ''
			},
			{
			extend: 'excel',
			title: ''
			},
			{
			extend: 'pdf',
			title: ''
			},
			{
			extend: 'print',
			title: ''
			}
		]
	});
});
</script>
