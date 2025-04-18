@extends('layouts.main')

@section('title')
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
                        <h2>@yield('title')</h2>
                        <ol class="breadcrumb">
                            <li>
                                {{ link_to('dashboard', 'Dashboard') }}
                            </li>
                            <li>
                                {{ link_to_route('laporan.list', $title = 'Laporan') }}
                            </li>
                            <li>
                                AD52
                            </li>
                            <li class="active">
                                <a href="{{ url()->full() }}">
                                    <strong>@yield('title')</strong>
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
                    <h5>Carian</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    {{-- Form::open(['id' => 'search-form']) --}}
                    {{ Form::open(['url' => url()->current(), 'method' => 'get']) }}
                        <div class="row">
                            <div class="col-md-1 col-lg-3"></div>
                            <div class="col-md-10 col-lg-6">
                                <div class="panel panel-success">
                                    <div class="panel-heading">
                                        <i class="fa fa-info-circle"></i>&nbsp;Carian
                                    </div>
                                    <div class="panel-body">
                                        <div class="form-group" id="date">
                                            {{ Form::label('datestart', 'Tarikh Penerimaan Aduan', ['class' => 'control-label']) }}
                                            <div class="input-daterange input-group" id="datepicker">
                                                {{ Form::text(
                                                    'datestart',
                                                    $data['datestart'] ?? '',
                                                    [
                                                        'class' => 'form-control',
                                                        'id' => 'datestart',
                                                        'onkeypress' => "return false",
                                                        'onpaste' => "return false",
                                                        'placeholder' => 'HH-BB-TTTT',
                                                        'readonly' => true
                                                    ]
                                                ) }}
                                                <span class="input-group-addon">hingga</span>
                                                {{ Form::text(
                                                    'dateend',
                                                    $data['dateend'] ?? '',
                                                    [
                                                        'class' => 'form-control',
                                                        'id' => 'dateend',
                                                        'onkeypress' => "return false",
                                                        'onpaste' => "return false",
                                                        'placeholder' => 'HH-BB-TTTT',
                                                        'readonly' => true
                                                    ]
                                                ) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            {{ Form::label('state', 'Negeri', ['class' => 'control-label']) }}
                                            {{ Form::select('state', $data['states'] ?? [], null, ['class' => 'form-control', 'placeholder' => '-- SEMUA NEGERI --']) }}
                                        </div>
                                        {{-- Form::hidden('search_ind', 0, [
                                            'class' => 'form-control',
                                            'id' => 'search_ind',
                                            'onkeypress' => "return false",
                                            'onpaste' => "return false",
                                            'readonly' => true
                                        ]) --}}
                                    </div>
                                    <div class="panel-footer">
                                        <div class="text-center">
                                            <a href="{{ url()->current() }}" class='btn btn-rounded btn-success btn-outline'>
                                                <i class="fa fa-refresh"></i>&nbsp;Semula
                                            </a>
                                            {{ Form::button(
                                                '<i class="fa fa-search"></i>&nbsp;Carian',
                                                [
                                                    'type' => 'submit',
                                                    'class' => 'btn btn-rounded btn-success'
                                                ]
                                            ) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-1 col-lg-3"></div>
                        </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
    @if(isset($data['issearch']) && $data['issearch'])
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>@yield('title')</h5>
                    <div class="ibox-tools">
                        <a class="collapse-link">
                            <i class="fa fa-chevron-up"></i>
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        @include('laporan.ad52.list.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    <!-- Modal Start -->
    <div id="modal-show-summary" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id='ModalShowSummary'></div>
        </div>
    </div>
    <!-- Modal End -->
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

        $(function () {
            var caseListTable = $('#case-list-table').DataTable({
                processing: true,
                serverSide: true,
                pagingType: 'full_numbers',
                order: [ 7, 'desc' ],
                dom: '<\'row\'<\'col-sm-6\'i><\'col-sm-6 Bfrtip html5buttons\'B<\'pull-right\'l>>>' +
                    '<\'row\'<\'col-sm-12\'tr>>' +
                    '<\'row\'<\'col-sm-12\'p>>',
                language: {
                    lengthMenu: 'Paparan _MENU_ rekod',
                    zeroRecords: 'Tiada rekod ditemui',
                    info: 'Memaparkan _START_-_END_ daripada _TOTAL_ rekod',
                    infoEmpty: 'Tiada rekod ditemui',
                    infoFiltered: '(Paparan daripada _MAX_ jumlah rekod)',
                    processing: "<span class=\"font-md\"></span><i class=\"fa fa-spinner fa-spin ml5\"></i>",
                    paginate: {
                        previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                        next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                        first: 'Pertama',
                        last: 'Terakhir'
                    },
                    search: 'Carian', 
                    searchPlaceholder: 'Carian'
                },
                ajax: {
                    url: "{{ url('laporan/ad52/list/dt') }}"
                        + "?" + "datestart=" + "{{ $data['datestart'] ?? '' }}"
                        + "&" + "dateend=" + "{{ $data['dateend'] ?? '' }}"
                        + "&" + "state=" + "{{ $data['state'] ?? '' }}"
                    // url: "{{-- url('laporan/ad52/list/dt') --}}",
                    // data: function (d) {
                    //     d.datestart = $('#search-form #datestart').val();
                    //     d.dateend = $('#search-form #dateend').val();
                    //     d.state = $('#search-form #state').val();
                    //     d.search_ind = $('#search-form #search_ind').val();
                    // },
                },
                columns: [
                    { data: 'DT_Row_Index', name: 'id', 'width': '1%', searchable: false, orderable: false },
                    { data: 'CA_CASEID', name: 'CA_CASEID' },
                    { data: 'CA_FILEREF', name: 'CA_FILEREF' },
                    { data: 'department', name: 'department' },
                    { data: 'descr', name: 'descr' },
                    { data: 'CA_DEPTCD', name: 'CA_DEPTCD' },
                    { data: 'case_act_descr', name: 'case_act_descr' },
                    { data: 'CA_RCVDT', name: 'CA_RCVDT' },
                    { data: 'emptystring', name: 'emptystring' },
                    { data: 'firstactiondate', name: 'firstactiondate' },
                    { data: 'firstactionduration', name: 'firstactionduration' },
                    { data: 'firstactionreason', name: 'firstactionreason' },
                    { data: 'assign_latest_date', name: 'assign_latest_date' },
                    { data: 'emptystring', name: 'emptystring' },
                    { data: 'answer_date', name: 'answer_date' },
                    { data: 'answer_duration', name: 'answer_duration' },
                    { data: 'answer_reason', name: 'answer_reason' },
                    { data: 'CA_COMPLETEDT', name: 'CA_COMPLETEDT' },
                    { data: 'case_act_descr', name: 'case_act_descr' },
                ],
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {orthogonal: 'export', columns: ':visible'}
                    },
                    { extend: 'colvis', text: 'Paparan Medan' }
                ]
            });

            // $('#search-form').on('submit', function (e) {
            //     $('#search-form #search_ind').val(1);
            //     caseListTable.draw();
            //     e.preventDefault();
            // });
        });

        function ShowSummary(CASEID) {
            $('#modal-show-summary').modal('show').find('#ModalShowSummary').load("{{ route('tugas.showsummary','') }}" + '/' + CASEID)
            document.getElementById(CASEID).style.color = 'purple'
        }
    </script>
@endsection
