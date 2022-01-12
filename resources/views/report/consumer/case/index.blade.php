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
                            <li><a href="{{ url('laporan/list') }}">Laporan</a></li>
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
                        <div class="col-md-1 col-lg-2"></div>
                        <div class="col-md-10 col-lg-8">
                            <div class="table-responsive">
                                <div class="form-group" id="date">
                                    {{ Form::label('datestart', 'Tarikh Penerimaan:', ['class' => 'control-label']) }}
                                    <div class="input-daterange input-group" id="datepicker">
                                        {{ Form::text('datestart',
                                            $data['datestart'] ?? '',
                                            [
                                                'class' => 'form-control',
                                                'onkeypress' => "return false",
                                                'onpaste' => "return false",
                                                'placeholder' => 'HH-BB-TTTT',
                                                'readonly' => true,
                                            ]
                                        ) }}
                                        <span class="input-group-addon">Hingga</span>
                                        {{ Form::text('dateend',
                                            $data['dateend'] ?? '',
                                            [
                                                'class' => 'form-control',
                                                'onkeypress' => "return false",
                                                'onpaste' => "return false",
                                                'placeholder' => 'HH-BB-TTTT',
                                                'readonly' => true,
                                            ]
                                        ) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        {{ Form::label('state', 'Negeri:', ['class' => 'control-label']) }}
                                        {{ Form::select('state', $data['states'] ?? [], null, ['class' => 'form-control', 'placeholder' => '-- SEMUA --']) }}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        {{ Form::label('category', 'Kategori:', ['class' => 'control-label']) }}
                                        {{ Form::select('category', $data['categories'] ?? [], null, ['class' => 'form-control', 'placeholder' => '-- SEMUA --']) }}
                                    </div>
                                </div>
                                <div class="form-group text-center">
                                    <a href="{{ url()->current() }}" class='btn btn-rounded btn-success btn-outline'>
                                        <i class="fa fa-refresh"></i>&nbsp;Semula
                                    </a>
                                    &nbsp;
                                    {{ Form::button('<i class="fa fa-search"></i>&nbsp;Jana', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-rounded btn-success'
                                    ]) }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-1 col-lg-2"></div>
                    </div>
                    @if(isset($data['issearch']) && $data['issearch'])
                    <hr class="hr-line-solid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group text-center">
                                <div class="table-responsive">
                                    {{ Form::button('<i class="fa fa-file-excel-o"></i>&nbsp;Muat Turun Excel', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-rounded btn-primary',
                                        'name' => 'generate',
                                        'value' => 'excel',
                                        'formtarget' => '_blank'
                                    ]) }}
                                    &nbsp;
                                    {{ Form::button('<i class="fa fa-file-pdf-o"></i>&nbsp;Muat Turun PDF', [
                                        'type' => 'submit',
                                        'class' => 'btn btn-rounded btn-danger btn-outline',
                                        'name' => 'generate',
                                        'value' => 'pdf',
                                        'formtarget' => '_blank'
                                    ]) }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    {{ Form::close() }}
                    @if(isset($data['issearch']) && $data['issearch'])
                        <div class="table-responsive">
                            <h4 class="text-center">@yield('page_title')</h4>
                            <h4 class="text-center">{{ $data['datetext'] ?? '' }}</h4>
                            <h4 class="text-center">{{ $data['statetext'] ?? '' }}</h4>
                            <h4 class="text-center">{{ $data['categorytext'] ?? '' }}</h4>
                        </div>
                        <div class="table-responsive">
                            @includeIf('report.consumer.case.table_link')
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

        function changeTextColor(element) {
            element.style.color = 'purple';
        }
    </script>
@endsection
