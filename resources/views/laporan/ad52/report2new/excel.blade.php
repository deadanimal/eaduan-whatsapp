<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<table>
		<thead>
		    <tr>
	        	<td colspan="{{ $countActTemplate > 0 ? $countActTemplate + 1 : 1 }}" style="text-align:center">
		        	{{ $data['appname'] ?? '' }}
		        </td>
		    </tr>
		    <tr>
	        	<td colspan="{{ $countActTemplate > 0 ? $countActTemplate + 1 : 1 }}" style="text-align:center">
		        	{{ $data['title'] ?? '' }}
		        </td>
		    </tr>
		    <tr>
		        <td colspan="{{ $countActTemplate > 0 ? $countActTemplate + 1 : 1 }}" style="text-align:center">
		        	{{ $data['datetext'] ?? '' }}
		        </td>
		    </tr>
		    <tr>
		        <td colspan="{{ $countActTemplate > 0 ? $countActTemplate + 1 : 1 }}" style="text-align:center">
		        	{{ $data['statetext'] ?? '' }}
		        </td>
		    </tr>
		</thead>
	</table>
	@includeIf('laporan.ad52.report2new.table')
</html>
