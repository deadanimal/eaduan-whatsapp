@extends('layouts.main')

@section('page_title')
{{ $data['title'] ?? '' }}
@endsection

@section('content')
    <style>
        .form-control[readonly][type="text"] {
            background-color: #ffffff;
        }
    </style>
	<div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <div class="table-responsive">
                        <h2>@yield('page_title')</h2>
                        <ol class="breadcrumb">
                            <li>{{ link_to('dashboard', 'Dashboard') }}</li>
                            <li>Laporan</li>
                            <li>Pertanyaan / Cadangan</li>
                            <li class="active">
                                <a href="{{ url()->full() }}">
                                    <strong>@yield('page_title')</strong>
                                </a>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="table-responsive">
                        <h5>@yield('page_title')</h5>
                    </div>
                </div>
                <div class="ibox-content">
                    {{ Form::open(['url' => url()->current(), 'method' => 'get']) }}
                    <div class="row">
                        <div class="table-responsive">
                            <div class="col-md-1 col-lg-4"></div>
                            <div class="col-md-10 col-lg-4">
                                <div class="form-group">
                                    {{ Form::label('year', 'Tahun:', ['class' => 'control-label']) }}
                                    {{ Form::select('year', $data['yearList'] ?? [], null, ['class' => 'form-control']) }}
                                </div>
                                <div class="form-group text-center">
                                    <a href="{{ url()->current() }}" class='btn btn-rounded btn-success btn-outline'>
                                        <i class="fa fa-refresh"></i>&nbsp;Semula
                                    </a>
                                    {{ Form::button('<i class="fa fa-search"></i>&nbsp;Jana', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-rounded btn-success'
                                    ]) }}
                                </div>
                            </div>
                            <div class="col-md-1 col-lg-4"></div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    @if(!empty($data['isSearch']))
                        <hr class="hr-line-solid">
                        <div class="table-responsive">
                            <h4 class="text-center">
                                <a href="{{ $data['urlexcel'] ?? '' }}"
                                    class="btn btn-primary btn-rounded"
                                    target="_blank">
                                    <i class="fa fa-file-excel-o"></i>&nbsp;Muat Turun Versi Excel
                                </a>
                                &nbsp;
                                <a href="{{ $data['urlpdf'] ?? '' }}"
                                    class="btn btn-danger btn-rounded btn-outline"
                                    target="_blank">
                                    <i class="fa fa-file-pdf-o"></i>&nbsp;Muat Turun Versi PDF
                                </a>
                            </h4>
                            <h4 class="text-center">@yield('page_title')</h4>
                            <h4 class="text-center">{{ $data['yeartext'] ?? '' }}</h4>
                        </div>
                        <div class="table-responsive">
                            @includeIf('report.askenquiry.category.table')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script_datatable')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#date .input-daterange').datepicker({
                autoclose: true,
                calendarWeeks: true,
                forceParse: false,
                format: 'dd-mm-yyyy',
                keyboardNavigation: false,
                todayBtn: "linked",
                todayHighlight: true,
                weekStart: 1,
                startDate: '01-01-2013',
                endDate: '+1d'
            });
        });
    </script>
@endsection
