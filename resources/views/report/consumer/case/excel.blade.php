<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <table>
        <thead>
            <tr>
                <th colspan="5">{{ $data['appname'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="5">{{ $data['title'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="5">{{ $data['datetext'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="5">{{ $data['statetext'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="5">{{ $data['categorytext'] ?? '' }}</th>
            </tr>
        </thead>
    </table>
    @includeIf('report.consumer.case.table')
</html>
