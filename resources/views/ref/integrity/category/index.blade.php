@extends('layouts.main')
@section('page_title')
    Selenggara Kategori Aduan Integriti
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
                        <a class="btn btn-primary pull-right" style="" href="{{ route('ref.integrity.categories.create') }}">
                            Tambah Baharu
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        @includeIf('ref.integrity.category.table')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
