@php
    $filename = env('APP_NAME', 'eAduan 2.0') . ' ' . $title . date(' YmdHis').'.xls';
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=" . $filename);
    $fp = fopen('php://output', 'w');
@endphp
<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<table>
	    <tr>
	        <td colspan="7" style="text-align:center">
	        	{{ $title }}
	        </td>
	    </tr>
	    <tr>
	        <td colspan="7" style="text-align:center">
	        	Tarikh Penerimaan Aduan : Dari
                {{ date('d-m-Y', strtotime($date_start)) }}
                Hingga
                {{ date('d-m-Y', strtotime($date_end)) }}
	        </td>
	    </tr>
	</table>
	@include('laporan.ad52.report5.table')
</html>
@php
    exit;
    fclose($fp);
@endphp
