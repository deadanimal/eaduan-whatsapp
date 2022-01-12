<style>
    th, td {
        font-size: 12px;
    }
    div {
        text-align: center;
        font-size: 12px;
    }
</style>
<div class="row">
    <div style="text-align: center;">
        <h4 align="center">{{ $data['appname'] ?? '' }}</h4>
        <h4 align="center">{{ $data['title'] ?? '' }}</h4>
        <h4 align="center">{{ $data['datetext'] ?? '' }}</h4>
        <h4 align="center">{{ $data['statetext'] ?? '' }}</h4>
    </div>
    <div>
        @includeIf('laporan.ad52.report2new.table')
    </div>
</div>
