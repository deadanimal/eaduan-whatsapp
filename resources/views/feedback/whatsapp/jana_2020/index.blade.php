@extends('layouts.main')
<style>
    #chartdiv {
        width: 100%;
        height: 500px;
    }
</style>
@section('content')
<div class="row wrapper border-bottom white-bg page-heading mb-4">
    <div class="col-lg-10">
        <h2>Laporan Statistik Bulanan </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <strong>Maklumbalas Melalui Aplikasi Whatsapp</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row text-center">
    <div class="col">
        <div class="ibox">
            <div class="ibox-content">
                <div class="form-group row">
                    <form action="/jananik" method="POST">
                        {{csrf_field()}}
                        <div class="col-lg-2">
                            <label class=" col-form-label">Pilih Tahun</label>
                        </div>
                        <div class="col-lg-8">
                            <select class="form-control m-b" name="tahun">
                                <option value="1">Sila pilih tahun</option>
                                <option value="2020" selected>2020</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-primary" type="submit">Jana</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<h3>2020 Laporan Bulanan</h3>

<div class="ibox">
    <div class="ibox-content">
        <table id="example" class="display nowrap" style="width:50%">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>Jan</th>
                    <th>Feb</th>
                    <th>Mac</th>
                    <th>April</th>
                    <th>Mei</th>
                    <th>Jun</th>
                    <th>Jul</th>
                    <th>Ogos</th>
                    <th>Sept</th>
                    <th>Okt</th>
                    <th>Nov</th>
                    <th>Dis</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Agensi kpdnhep</td>
                    <td>447</td>
                    <td>254</td>
                    <td>247</td>
                    <td>323</td>
                    <td>247</td>
                    <td>200</td>
                    <td>204</td>
                    <td>216</td>
                    <td>184</td>
                    <td>193</td>
                    <td>152</td>
                    <td>115</td>
                </tr>
                <tr>
                    <td>BNM</td>
                    <td>15</td>
                    <td>9</td>
                    <td>8</td>
                    <td>11</td>
                    <td>7</td>
                    <td>2</td>
                    <td>10</td>
                    <td>1</td>
                    <td>6</td>
                    <td>2</td>
                    <td>2</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>CFM</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>JAKIM</td>
                    <td>39</td>
                    <td>5</td>
                    <td>4</td>
                    <td>12</td>
                    <td>8</td>
                    <td>10</td>
                    <td>13</td>
                    <td>6</td>
                    <td>13</td>
                    <td>7</td>
                    <td>1</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>JIM</td>
                    <td>3</td>
                    <td>0</td>
                    <td>3</td>
                    <td>1</td>
                    <td>1</td>
                    <td>5</td>
                    <td>2</td>
                    <td>2</td>
                    <td>0</td>
                    <td>5</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>JKDM</td>
                    <td>28</td>
                    <td>13</td>
                    <td>10</td>
                    <td>19</td>
                    <td>15</td>
                    <td>10</td>
                    <td>6</td>
                    <td>13</td>
                    <td>6</td>
                    <td>10</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>JKM</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>JKR</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>JPN</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>KATS</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>KDM</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>KKM</td>
                    <td>78</td>
                    <td>28</td>
                    <td>22</td>
                    <td>23</td>
                    <td>27</td>
                    <td>20</td>
                    <td>42</td>
                    <td>31</td>
                    <td>30</td>
                    <td>34</td>
                    <td>7</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>KPKT</td>
                    <td>9</td>
                    <td>6</td>
                    <td>5</td>
                    <td>6</td>
                    <td>3</td>
                    <td>1</td>
                    <td>4</td>
                    <td>2</td>
                    <td>3</td>
                    <td>5</td>
                    <td>6</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>KPM</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>KSM</td>
                    <td>1</td>
                    <td>2</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>LPKP</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>Mahkamah</td>
                    <td>3</td>
                    <td>8</td>
                    <td>2</td>
                    <td>3</td>
                    <td>3</td>
                    <td>5</td>
                    <td>4</td>
                    <td>0</td>
                    <td>1</td>
                    <td>8</td>
                    <td>1</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>MAVCOM</td>
                    <td>0</td>
                    <td>1</td>
                    <td>3</td>
                    <td>1</td>
                    <td>0</td>
                    <td>1</td>
                    <td>2</td>
                    <td>1</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>MOA</td>
                    <td>13</td>
                    <td>2</td>
                    <td>2</td>
                    <td>0</td>
                    <td>2</td>
                    <td>1</td>
                    <td>0</td>
                    <td>2</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>MOT</td>
                    <td>3</td>
                    <td>8</td>
                    <td>1</td>
                    <td>10</td>
                    <td>3</td>
                    <td>4</td>
                    <td>0</td>
                    <td>7</td>
                    <td>4</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>MOTAC</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>PBT</td>
                    <td>18</td>
                    <td>13</td>
                    <td>17</td>
                    <td>11</td>
                    <td>12</td>
                    <td>2</td>
                    <td>11</td>
                    <td>4</td>
                    <td>9</td>
                    <td>5</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>PDRM</td>
                    <td>15</td>
                    <td>10</td>
                    <td>15</td>
                    <td>8</td>
                    <td>21</td>
                    <td>7</td>
                    <td>25</td>
                    <td>15</td>
                    <td>23</td>
                    <td>22</td>
                    <td>1</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>SIRIM</td>
                    <td>3</td>
                    <td>8</td>
                    <td>1</td>
                    <td>10</td>
                    <td>3</td>
                    <td>4</td>
                    <td>0</td>
                    <td>7</td>
                    <td>4</td>
                    <td>1</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>SKMM</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>SPRM</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>TENAGA</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
                <tr>
                    <td>TNB</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>2</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="ibox">
    <div class="ibox-content">
		<div class="chart">
			<div class="amcharts" id="chartdiv"></div>
		</div>
    </div>
</div>

@stop

@section('customscript')


<script>
    $(document).ready(function() {
        $('#example').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    });

    $('g:has(> g[stroke="#3cabff"])').hide();
</script>


<!-- Chart code -->
<script>
    am4core.ready(function() {

        // Themes begin
        am4core.useTheme(am4themes_animated);
        am4core.addLicense("ch-custom-attribution");
        // Themes end

        // Create chart instance
        var chart = am4core.create("chartdiv", am4charts.PieChart);

        // Set data
        var selected;
        var types = [{
                type: "Januari",
                percent: 258,
                color: chart.colors.getIndex(0),
                subs: [
                    //     {
                    //     type: "Agensi KPDNHEP",
                    //     percent: 447
                    // }, 
                    {
                        type: "BNM",
                        percent: 15
                    }, {
                        type: "CFM",
                        percent: 15
                    },
                    {
                        type: "JAKIM",
                        percent: 39
                    },
                    {
                        type: "JIM",
                        percent: 3
                    },
                    {
                        type: "JKDM",
                        percent: 28
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 1
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 78
                    },
                    {
                        type: "KPKT",
                        percent: 9
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 1
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 3
                    },
                    {
                        type: "MAVCOM",
                        percent: 0
                    },
                    {
                        type: "MOA",
                        percent: 13
                    },
                    {
                        type: "MOT",
                        percent: 3
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 18
                    },
                    {
                        type: "PDRM",
                        percent: 15
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 18
                    },
                    {
                        type: "TENAGA",
                        percent: 15
                    },
                    {
                        type: "TNB",
                        percent: 15
                    },
                ]
            },
            {
                type: "Februari",
                percent: 124,
                color: chart.colors.getIndex(1),
                subs: [
                    //     {
                    //     type: "Agensi KPDNHEP",
                    //     percent: 447
                    // }, 
                    {
                        type: "BNM",
                        percent: 9
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 5
                    },
                    {
                        type: "JIM",
                        percent: 0
                    },
                    {
                        type: "JKDM",
                        percent: 13
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 28
                    },
                    {
                        type: "KKM",
                        percent: 28
                    },
                    {
                        type: "KPKT",
                        percent: 6
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 2
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 8
                    },
                    {
                        type: "MAVCOM",
                        percent: 1
                    },
                    {
                        type: "MOA",
                        percent: 2
                    },
                    {
                        type: "MOT",
                        percent: 8
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 13
                    },
                    {
                        type: "PDRM",
                        percent: 10
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 8
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    },
                ]
            },
            {
                type: "Mac",
                percent: 112,
                color: chart.colors.getIndex(3),
                subs: [{
                        type: "BNM",
                        percent: 8
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 4
                    },
                    {
                        type: "JIM",
                        percent: 3
                    },
                    {
                        type: "JKDM",
                        percent: 10
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 22
                    },
                    {
                        type: "KPKT",
                        percent: 5
                    },
                    {
                        type: "KPM",
                        percent: 1
                    },
                    {
                        type: "KSM",
                        percent: 0
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 2
                    },
                    {
                        type: "MAVCOM",
                        percent: 3
                    },
                    {
                        type: "MOA",
                        percent: 2
                    },
                    {
                        type: "MOT",
                        percent: 1
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 17
                    },
                    {
                        type: "PDRM",
                        percent: 15
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 8
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    },
                ]
            },
            {
                type: "April",
                percent: 136,
                color: chart.colors.getIndex(5),
                subs: [{
                        type: "BNM",
                        percent: 11
                    }, {
                        type: "CFM",
                        percent: 1
                    },
                    {
                        type: "JAKIM",
                        percent: 12
                    },
                    {
                        type: "JIM",
                        percent: 1
                    },
                    {
                        type: "JKDM",
                        percent: 19
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 1
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 23
                    },
                    {
                        type: "KPKT",
                        percent: 6
                    },
                    {
                        type: "KPM",
                        percent: 1
                    },
                    {
                        type: "KSM",
                        percent: 1
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 3
                    },
                    {
                        type: "MAVCOM",
                        percent: 1
                    },
                    {
                        type: "MOA",
                        percent: 0
                    },
                    {
                        type: "MOT",
                        percent: 10
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 11
                    },
                    {
                        type: "PDRM",
                        percent: 8
                    },
                    {
                        type: "SIRIM",
                        percent: 10
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 0
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    },]
            },
            {
                type: "Mei",
                percent: 123,
                color: chart.colors.getIndex(7),
                subs: [{
                        type: "BNM",
                        percent: 7
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 8
                    },
                    {
                        type: "JIM",
                        percent: 1
                    },
                    {
                        type: "JKDM",
                        percent: 15
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 1
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 27
                    },
                    {
                        type: "KPKT",
                        percent: 3
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 0
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 3
                    },
                    {
                        type: "MAVCOM",
                        percent: 0
                    },
                    {
                        type: "MOA",
                        percent: 2
                    },
                    {
                        type: "MOT",
                        percent: 3
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 12
                    },
                    {
                        type: "PDRM",
                        percent: 21
                    },
                    {
                        type: "SIRIM",
                        percent: 3
                    },
                    {
                        type: "SKMM",
                        percent: 2
                    },
                    {
                        type: "SPRM",
                        percent: 2
                    },
                    {
                        type: "TENAGA",
                        percent: 2
                    },
                    {
                        type: "TNB",
                        percent: 2
                    }]
            },
            {
                type: "Jun",
                percent: 83,
                color: chart.colors.getIndex(9),
                subs: [{
                        type: "BNM",
                        percent: 2
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 10
                    },
                    {
                        type: "JIM",
                        percent: 5
                    },
                    {
                        type: "JKDM",
                        percent: 10
                    },
                    {
                        type: "JKM",
                        percent: 1
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 20
                    },
                    {
                        type: "KPKT",
                        percent: 1
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 0
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 5
                    },
                    {
                        type: "MAVCOM",
                        percent: 1
                    },
                    {
                        type: "MOA",
                        percent: 1
                    },
                    {
                        type: "MOT",
                        percent: 4
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 2
                    },
                    {
                        type: "PDRM",
                        percent: 7
                    },
                    {
                        type: "SIRIM",
                        percent: 4
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 0
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    }]
            },
            {
                type: "Julai",
                percent: 151,
                color: chart.colors.getIndex(11),
                subs: [{
                        type: "BNM",
                        percent: 10
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 13
                    },
                    {
                        type: "JIM",
                        percent: 2
                    },
                    {
                        type: "JKDM",
                        percent: 6
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 1
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 1
                    },
                    {
                        type: "KKM",
                        percent: 42
                    },
                    {
                        type: "KPKT",
                        percent: 4
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 0
                    },
                    {
                        type: "LPKP",
                        percent: 1
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 4
                    },
                    {
                        type: "MAVCOM",
                        percent: 2
                    },
                    {
                        type: "MOA",
                        percent: 0
                    },
                    {
                        type: "MOT",
                        percent: 0
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 11
                    },
                    {
                        type: "PDRM",
                        percent: 25
                    },
                    {
                        type: "SIRIM",
                        percent: 0
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 0
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    }]
            },
            {
                type: "Ogos",
                percent: 105,
                color: chart.colors.getIndex(2),
                subs: [{
                        type: "BNM",
                        percent: 1
                    }, {
                        type: "CFM",
                        percent: 1
                    },
                    {
                        type: "JAKIM",
                        percent: 6
                    },
                    {
                        type: "JIM",
                        percent: 2
                    },
                    {
                        type: "JKDM",
                        percent: 13
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 31
                    },
                    {
                        type: "KPKT",
                        percent: 0
                    },
                    {
                        type: "KPM",
                        percent: 2
                    },
                    {
                        type: "KSM",
                        percent: 1
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 0
                    },
                    {
                        type: "MAVCOM",
                        percent: 1
                    },
                    {
                        type: "MOA",
                        percent: 2
                    },
                    {
                        type: "MOT",
                        percent: 7
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 4
                    },
                    {
                        type: "PDRM",
                        percent: 15
                    },
                    {
                        type: "SIRIM",
                        percent: 7
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 0
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    }]
            },
            {
                type: "September",
                percent: 112,
                color: chart.colors.getIndex(4),
                subs: [{
                        type: "BNM",
                        percent: 6
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 13
                    },
                    {
                        type: "JIM",
                        percent: 0
                    },
                    {
                        type: "JKDM",
                        percent: 6
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 30
                    },
                    {
                        type: "KPKT",
                        percent: 3
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 0
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 1
                    },
                    {
                        type: "MAVCOM",
                        percent: 2
                    },
                    {
                        type: "MOA",
                        percent: 2
                    },
                    {
                        type: "MOT",
                        percent: 4
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 9
                    },
                    {
                        type: "PDRM",
                        percent: 23
                    },
                    {
                        type: "SIRIM",
                        percent: 4
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 0
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    }]
            },
            {
                type: "Oktober",
                percent: 123,
                color: chart.colors.getIndex(6),
                subs: [{
                        type: "BNM",
                        percent: 2
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 7
                    },
                    {
                        type: "JIM",
                        percent: 5
                    },
                    {
                        type: "JKDM",
                        percent: 10
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 34
                    },
                    {
                        type: "KPKT",
                        percent: 5
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 0
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 8
                    },
                    {
                        type: "MAVCOM",
                        percent: 0
                    },
                    {
                        type: "MOA",
                        percent: 0
                    },
                    {
                        type: "MOT",
                        percent: 1
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 5
                    },
                    {
                        type: "PDRM",
                        percent: 22
                    },
                    {
                        type: "SIRIM",
                        percent: 1
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 0
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    }]
            },
            {
                type: "November",
                percent: 21,
                color: chart.colors.getIndex(10),
                subs: [{
                        type: "BNM",
                        percent: 2
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 1
                    },
                    {
                        type: "JIM",
                        percent: 0
                    },
                    {
                        type: "JKDM",
                        percent: 0
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 7
                    },
                    {
                        type: "KPKT",
                        percent: 6
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 0
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 1
                    },
                    {
                        type: "MAVCOM",
                        percent: 0
                    },
                    {
                        type: "MOA",
                        percent: 0
                    },
                    {
                        type: "MOT",
                        percent: 0
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 0
                    },
                    {
                        type: "PDRM",
                        percent: 1
                    },
                    {
                        type: "SIRIM",
                        percent: 0
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 0
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    }]
            },
            {
                type: "Disember",
                percent: 30,
                color: chart.colors.getIndex(8),
                subs: [{
                        type: "BNM",
                        percent: 0
                    }, {
                        type: "CFM",
                        percent: 0
                    },
                    {
                        type: "JAKIM",
                        percent: 0
                    },
                    {
                        type: "JIM",
                        percent: 0
                    },
                    {
                        type: "JKDM",
                        percent: 0
                    },
                    {
                        type: "JKM",
                        percent: 0
                    },
                    {
                        type: "JKR",
                        percent: 0
                    },
                    {
                        type: "JPN",
                        percent: 0
                    },
                    {
                        type: "KATS",
                        percent: 0
                    },
                    {
                        type: "KDM",
                        percent: 0
                    },
                    {
                        type: "KKM",
                        percent: 0
                    },
                    {
                        type: "KPKT",
                        percent: 0
                    },
                    {
                        type: "KPM",
                        percent: 0
                    },
                    {
                        type: "KSM",
                        percent: 0
                    },
                    {
                        type: "LPKP",
                        percent: 0
                    },
                    {
                        type: "MAHKAMAH",
                        percent: 0
                    },
                    {
                        type: "MAVCOM",
                        percent: 0
                    },
                    {
                        type: "MOA",
                        percent: 0
                    },
                    {
                        type: "MOT",
                        percent: 0
                    },
                    {
                        type: "MOTAC",
                        percent: 0
                    },
                    {
                        type: "PBT",
                        percent: 0
                    },
                    {
                        type: "PDRM",
                        percent: 0
                    },
                    {
                        type: "SIRIM",
                        percent: 0
                    },
                    {
                        type: "SKMM",
                        percent: 0
                    },
                    {
                        type: "SPRM",
                        percent: 0
                    },
                    {
                        type: "TENAGA",
                        percent: 0
                    },
                    {
                        type: "TNB",
                        percent: 0
                    }]
            }
        ];

        // Add data
        chart.data = generateChartData();

        // Add and configure Series
        var pieSeries = chart.series.push(new am4charts.PieSeries());
        pieSeries.dataFields.value = "percent";
        pieSeries.dataFields.category = "type";
        pieSeries.slices.template.propertyFields.fill = "color";
        pieSeries.slices.template.propertyFields.isActive = "pulled";
        pieSeries.slices.template.strokeWidth = 0;

        function generateChartData() {
            var chartData = [];
            for (var i = 0; i < types.length; i++) {
                if (i == selected) {
                    for (var x = 0; x < types[i].subs.length; x++) {
                        chartData.push({
                            type: types[i].subs[x].type,
                            percent: types[i].subs[x].percent,
                            color: types[i].color,
                            pulled: true
                        });
                    }
                } else {
                    chartData.push({
                        type: types[i].type,
                        percent: types[i].percent,
                        color: types[i].color,
                        id: i
                    });
                }
            }
            return chartData;
        }

        pieSeries.slices.template.events.on("hit", function(event) {
            if (event.target.dataItem.dataContext.id != undefined) {
                selected = event.target.dataItem.dataContext.id;
            } else {
                selected = undefined;
            }
            chart.data = generateChartData();
        });

    }); // end am4core.ready()
</script>
@stop