@extends('layouts.main')
<?php
    use App\Ref;
    use App\Branch;
    use App\Pertanyaan\PertanyaanAdmin;
?>
@section('content')

<table style="width: 100%;">
    <tr><td><center><h3>LAPORAN PERTANYAAN / CADANGAN</h3></center></td></tr>
    <tr><td><center><h3>TAHUN {{ $year }}</h3></center></td></tr>
    <tr><td><center><h3>{{ $titlemonth }}</h3></center></td></tr>
    <tr><td><center><h3>{{ $status != '0' ? 'Status: ' . Ref::GetDescr('1061', $status, 'ms') : 'SEMUA STATUS' }}</h3></center></td></tr>
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
                <th>No. Pertanyaan / Cadangan</th>
                <th>Keterangan</th>
                <th>Nama Pihak yang Bertanya</th>
                <th>Tarikh Terima</th>
                <th>Tarikh Dijawab</th>
                <th>Dijawab Oleh</th>
                <th>Hari</th>
            </tr>
        </thead>
        <tbody>
            @foreach($query as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><a onclick="ShowSummary('{{ $data->AS_ASKID }}')">{{ $data->AS_ASKID }}</a></td>
                    <td>{{ implode(' ', array_slice(explode(' ', ucfirst($data->AS_SUMMARY)), 0, 7)).'...' }}</td>
                    <td>{{ $data->AS_NAME }}</td>
                    <td>{{ $data->AS_RCVDT ? date('d-m-Y h:i A', strtotime($data->AS_RCVDT)) : '' }}</td>
                    <td>{{ $data->AS_COMPLETEDT ? date('d-m-Y h:i A', strtotime($data->AS_COMPLETEDT)) : '' }}</td>
                    <td>{{ $data->AS_COMPLETEBY ? $data->CompleteBy->name : '' }}</td>
                    <td></td>
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
        function ShowSummary(ASKID)
        {
            $('#modal-show-summary').modal("show").find("#ModalShowSummary").load("{{ route('pertanyaan-admin.showsummary','') }}" + "/" + ASKID);
        }
    </script>
@stop