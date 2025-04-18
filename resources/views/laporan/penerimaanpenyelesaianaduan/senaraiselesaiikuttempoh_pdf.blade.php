{{-- @extends('layouts.main') --}}
<?php
use App\Ref;
use App\Laporan\ReportYear;
use App\Laporan\TerimaSelesaiAduan;
?>
{{-- @section('content') --}}
<div class="ibox-content">
    <!--<h2>Laporan Aduan (Senarai)</h2>-->
    <table style="width: 100%;">
        <tr><td><h3><center>LAPORAN PENYELESAIAN ADUAN NEGERI</center></h3></td></tr>
        <tr><td><h3><center>{{ date('d-m-Y', strtotime($CA_RCVDT_FROM)) }} <?php echo $CA_RCVDT_TO != '' ? 'hingga' : ''; ?> {{ date('d-m-Y', strtotime($CA_RCVDT_TO)) }}</center></h3></td></tr>
        <tr><td><h3><center><?php echo $CA_DEPTCD != '' ? Ref::GetDescr('315', $CA_DEPTCD) : 'Semua Bahagian' ?></center></h3></td></tr>
    </table>
    {{-- Form::open(['method'=>'GET', 'url'=>'pembandinganaduan/senarai']) --}}
    {{-- <div class="form-group" align="center"> --}}
        {{-- Form::button('<i class="fa fa-file-excel-o"></i> Muat Turun Excel', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'name'=>'excel', 'value' => '1']) --}}
        {{-- Form::button('<i class="fa fa-file-pdf-o"></i> Muat Turun PDF', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'name'=>'pdf', 'value' => '1', 'formtarget' => '_blank']) --}}
    {{-- </div> --}}
    {{-- Form::close() --}}
    <div class="table-responsive">
        <!-- table id="senaraitable" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%; font-size: 10px;" -->
        <table id="senaraitable" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%; font-size: 10px;border:1px solid; border-collapse: collapse" border="1">
            <thead>
                <tr>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Bil.</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">No. Aduan</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Keterangan Aduan</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Nama Pengadu</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Nama Diadu</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Negeri</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Cawangan</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Kategori</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Tarikh Penerimaan</th>
                    <!--<th width="1%">Penyiasat</th>-->
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $senaraiaduan)
                <tr>
                    <td width="3px">{{ $i ++ }}</td>
                    <!--<td width="1%">{{-- $senaraiaduan->CA_CASEID --}}</td>-->
                    <td width="1%">
                        <a onclick="ShowSummary('{{ $senaraiaduan->CA_CASEID }}')">{!! $senaraiaduan->CA_CASEID !!}</a>
                    </td>
                    <td width="1%">
                        {{ implode(' ', array_slice(explode(' ', $senaraiaduan->CA_SUMMARY), 0, 5)).' ...' }}
                        {{-- substr($senaraiaduan->CA_SUMMARY, 0, 50).'...' --}}
                    </td>
                    <td width="1%">{{ $senaraiaduan->CA_NAME }} </td>
                    <td width="1%">{{ $senaraiaduan->CA_AGAINSTNM }} </td>
                    <td width="1%">
                        {{ $senaraiaduan->BR_STATECD != '' ? Ref::GetDescr('17', $senaraiaduan->BR_STATECD, 'ms') : '' }}
                    </td>
                    <td width="1%">{{ $senaraiaduan->BR_BRNNM ?? '' }}</td>
                    <td width="1%">
                        {{ $senaraiaduan->CA_CMPLCAT != '' ? Ref::GetDescr('244', $senaraiaduan->CA_CMPLCAT, 'ms') : '' }}
                    </td>
                    <td width="1%">
                        {{ $senaraiaduan->CA_RCVDT != '' ? date('d-m-Y h:i A', strtotime($senaraiaduan->CA_RCVDT)) : '' }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<div id="modal-show-summary" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id='ModalShowSummary'></div>
    </div>
</div>
{{-- @stop --}}
{{-- @section('script_datatable') --}}
    <script type="text/javascript">
        function ShowSummary(CASEID){
            $('#modal-show-summary').modal("show").find("#ModalShowSummary").load("{{ route('tugas.showsummary','') }}" + "/" + CASEID);
        }
    </script>
{{-- @stop --}}
