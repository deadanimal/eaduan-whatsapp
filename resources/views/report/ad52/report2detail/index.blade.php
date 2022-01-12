@extends('layouts.main')

@section('page_title')
{{ $data['title'] ?? '' }}
@endsection

@section('content')
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
                    @if(isset($data['issearch']) && $data['issearch'])
                        <div class="table-responsive">
                            <h4 class="text-center">@yield('page_title')</h4>
                            <h4 class="text-center">{{ $data['datetext'] ?? '' }}</h4>
                            <h4 class="text-center">{{ $data['statetext'] ?? '' }}</h4>
                            <h4 class="text-center">{{ $data['categorytext'] ?? '' }}</h4>
                            <h4 class="text-center">{{ $data['acttext'] ?? '' }}</h4>
                        </div>
                        <hr class="hr-line-solid">
                        <div class="table-responsive">
                            @includeIf('report.ad52.report2detail.table')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Start -->
    <div id="modal-show-summary" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id='ModalShowSummary'></div>
        </div>
    </div>
    <div id="modal-show-invby" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id='ModalShowInvBy'></div>
        </div>
    </div>
    <!-- Modal End -->
@endsection

@section('script_datatable')
    <script type="text/javascript">
        function ShowSummary(CASEID)
        {
            $('#modal-show-summary').modal("show").find("#ModalShowSummary").load("{{ route('tugas.showsummary','') }}" + "/" + CASEID);
            document.getElementById(CASEID).style.color = 'purple'
        }

        function ShowInvBy(id)
        {
            $('#modal-show-invby').modal("show").find("#ModalShowInvBy").load("{{ route('carian.showinvby','') }}" + "/" + id);
        }

        $(function() {
            $('#casedetailtable').DataTable({
                processing: true,
                serverSide: true,
                bFilter: false,
                aaSorting: [],
                dom: '<\'row\'<\'col-sm-6\'i><\'col-sm-6 Bfrtip html5buttons\'B<\'pull-right\'l>>>' +
                    '<\'row\'<\'col-sm-12\'tr>>' +
                    '<\'row\'<\'col-sm-12\'p>>',
                ajax: {
                    url: "{{ url('report/ad52/report2detail/dt') }}"
                        + "?" + "datestart=" + "{{ $data['datestart'] ?? '' }}"
                        + "&" + "dateend=" + "{{ $data['dateend'] ?? '' }}"
                        + "&" + "state=" + "{{ $data['state'] ?? '' }}"
                        + "&" + "act=" + "{{ $data['act'] ?? '' }}"
                },
                columns: [
                    {data: 'DT_Row_Index', name: 'id', 'width': '5%', searchable: false, orderable: false},
                    {
                        data: 'CA_CASEID', render: function (data, type) {
                            return type === 'export' ? "' " + data : data;
                        }, 
                        name: 'CA_CASEID', orderable: false
                    },
                    {data: 'CA_SUMMARY', name: 'CA_SUMMARY', orderable: false},
                    {data: 'CA_NAME', name: 'CA_NAME', orderable: false},
                    {data: 'CA_AGAINSTNM', name: 'CA_AGAINSTNM', orderable: false},
                    {data: 'BR_BRNNM', name: 'BR_BRNNM', orderable: false},
                    {data: 'CA_CMPLCAT', name: 'CA_CMPLCAT', orderable: false},
                    {data: 'CA_RCVDT', name: 'CA_RCVDT', orderable: false},
                    {data: 'CA_COMPLETEDT', name: 'CA_COMPLETEDT', orderable: false},
                    {data: 'CA_CLOSEDT', name: 'CA_CLOSEDT', orderable: false},
                    {data: 'CA_INVBY', name: 'CA_INVBY', orderable: false},
                ],
                language: {
                    lengthMenu: 'Memaparkan _MENU_ rekod',
                    zeroRecords: 'Tiada rekod ditemui',
                    info: 'Memaparkan _START_-_END_ daripada _TOTAL_ rekod',
                    infoEmpty: 'Tiada rekod ditemui',
                    infoFiltered: '(Paparan daripada _MAX_ jumlah rekod)',
                    paginate: {
                        previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                        next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                        first: 'Pertama',
                        last: 'Terakhir',
                    },
                },
                buttons: [
                    {
                        extend: 'excel',
                        exportOptions: {orthogonal: 'export', columns: ':visible'}
                    },
                    { extend: 'colvis', text: 'Paparan Medan' }
                ]
            });
        });
    </script>
@endsection
