<html>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <table>
        <thead>
            <tr>
                <th colspan="15">{{ $data['appname'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="15">{{ $data['title'] ?? '' }}</th>
            </tr>
            <tr>
                <th colspan="15">{{ $data['yeartext'] ?? '' }}</th>
            </tr>
        </thead>
    </table>
    @includeIf('report.askenquiry.category.table')
</html>
