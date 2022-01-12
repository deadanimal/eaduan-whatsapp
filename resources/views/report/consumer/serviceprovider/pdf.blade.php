<style>
    th, td {
        text-align: left;
        font-size: 12px;
    }
    table, th, td {
        border: 1px solid black;
        border-collapse: collapse
    }
</style>
<div class="row">
    <div style="text-align: center;">
        <h4 align="center">{{ $data['appname'] ?? '' }}</h4>
        <h4 align="center">{{ $data['title'] ?? '' }}</h4>
        <h4 align="center">{{ $data['datetext'] ?? '' }}</h4>
        <h4 align="center">{{ $data['categorytext'] ?? '' }}</h4>
    </div>
    <div>
        @includeIf('report.consumer.serviceprovider.table')
    </div>
</div>
