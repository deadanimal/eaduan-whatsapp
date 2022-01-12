<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<table>
	    <tr>
	        <td colspan="18">{{ $data['appname'] ?? '' }}</td>
	    </tr>
	    <tr>
	        <td colspan="18">{{ $data['title'] ?? '' }}</td>
	    </tr>
	    <tr>
	        <td colspan="18">{{ $data['datetext'] ?? '' }}</td>
	    </tr>
	    <tr>
	        <td colspan="18">{{ $data['statustext'] ?? '' }}</td>
	    </tr>
	</table>
	@includeIf('report.integrity.statusdetail.table')
</html>
