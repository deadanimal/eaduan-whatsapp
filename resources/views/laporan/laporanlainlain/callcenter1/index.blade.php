@extends('layouts.main')
<?php
    use App\Ref;
    use App\Branch;
?>
@section('content')

<table style="width: 100%;">
    <tr><td><center><h3>LAPORAN CALL CENTER</h3></center></td></tr>
    <tr><td><center><h3>TAHUN {{ $year }}</h3></center></td></tr>
    <tr><td><center><h3>{{ $titlemonth }}</h3></center></td></tr>
    <tr><td><center><h3>NAMA: {{ $mUser->name }}</h3></center></td></tr>
</table>

{!! Form::open(['method' => 'GET']) !!}
    <div class="form-group" align="center">
        {{ Form::button('<i class="fa fa-file-excel-o"></i> Muat Turun Excel', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'name'=>'excel', 'value' => '1']) }}
        {{ Form::button('<i class="fa fa-file-pdf-o"></i> Muat Turun PDF', ['type' => 'submit', 'class' => 'btn btn-success btn-sm', 'name'=>'pdf', 'value' => '1', 'formtarget' => '_blank']) }}
    </div>
{!! Form::close() !!}

<div class="table-responsive">
    <table class="table table-striped table-bordered table-hover" style="width: 100%">
        <thead>
            <tr>
                <th>Bil.</th>
                <th>No. Aduan</th>
                <th>Aduan</th>
                <th>Nama Pengadu</th>
                <th>Nama Diadu</th>
                <!--<th>Cawangan</th>-->
                <th>Kategori Aduan</th>
                <th>Tarikh Terima</th>
                <th>Tarikh Penugasan</th>
                <th>Tarikh Selesai</th>
                <th>Tarikh Penutupan</th>
                <th>Penyiasat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($query as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a onclick="ShowSummary('{{ $data->CA_CASEID }}')">{{ $data->CA_CASEID }}</a></td>
                    <td>{{ implode(' ', array_slice(explode(' ', ucfirst($data->CA_SUMMARY)), 0, 7)).'...' }}</td>
                    <td>{{ $data->CA_NAME }}</td>
                    <td>{{ $data->CA_AGAINSTNM }}</td>
                    <!--<td>{{-- $data->BrnCd->BR_BRNNM --}}</td>-->
                    <!--<td>{{-- $data->CA_BRNCD != '' ? Branch::GetBranchName($data->CA_BRNCD) : ''  --}}</td>-->
                    <!--<td>{{-- $data->CmplCat->descr --}}</td>-->
                    <td>{{ $data->CA_CMPLCAT != '' ? Ref::GetDescr('244', $data->CA_CMPLCAT, 'ms') : '' }}</td>
                    <td>{{ $data->CA_RCVDT? date('d-m-Y h:i A', strtotime($data->CA_RCVDT)):'' }}</td>
                    <td>{{ $data->CA_ASGDT? date('d-m-Y h:i A', strtotime($data->CA_ASGDT)):'' }}</td>
                    <td>{{ $data->CA_COMPLETEDT? date('d-m-Y h:i A', strtotime($data->CA_COMPLETEDT)):'' }}</td>
                    <td>{{ $data->CA_CLOSEDT? date('d-m-Y h:i A', strtotime($data->CA_CLOSEDT)):'' }}</td>
                    <td>{{ $data->CA_INVBY? $data->InvBy->name:'' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Start -->
<div id="modal-show-summary" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" id='ModalShowSummary'></div>
    </div>
</div>
<!-- Modal End -->
@stop

@section('script_datatable')
    <script type="text/javascript">
        function ShowSummary(CASEID)
        {
            $('#modal-show-summary').modal("show").find("#ModalShowSummary").load("{{ route('tugas.showsummary','') }}" + "/" + CASEID);
        }
    </script>
@stop