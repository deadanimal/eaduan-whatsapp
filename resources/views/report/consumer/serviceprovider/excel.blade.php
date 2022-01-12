<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <table>
        <thead>
            <tr>
                <th colspan="12">{{ $data['appname'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="12">{{ $data['title'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="12">{{ $data['datetext'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="12">{{ $data['categorytext'] ?? '' }}</th>
            </tr>
        </thead>
    </table>
    @includeIf('report.consumer.serviceprovider.table')
</html>
