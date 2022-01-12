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
                            <li>Laporan</li>
                            <li>Integriti</li>
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
                    @if($data['issearch'])
                        <div class="table-responsive">
                            <p class="text-center">{{ $data['datetext'] ?? '' }}</p>
                            <p class="text-center">{{ $data['statustext'] ?? '' }}</p>
                            <p class="text-center">
                                <a href="{{ $data['urlexcel'] ?? '' }}" class="btn btn-primary" target="_blank">
                                    <i class="fa fa-file-excel-o"></i> Muat Turun Excel
                                </a>
                            </p>
                        </div>
                        <div class="table-responsive">
                            @includeIf('report.integrity.statusdetail.table')
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Start -->
    <div id="modal-show-summary-integriti" class="modal fade" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content" id='ModalShowSummaryIntegriti'></div>
        </div>
    </div>
    <!-- Modal End -->
@endsection

@section('script_datatable')
    <script type="text/javascript">
        function showsummaryintegriti(id)
        {
            $('#modal-show-summary-integriti')
                .modal("show")
                .find("#ModalShowSummaryIntegriti")
                .load("{{ route('integritibase.showsummary','') }}" + "/" + id);
        }
    </script>
@endsection