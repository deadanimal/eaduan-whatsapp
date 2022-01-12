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
                <div class="table-responsive">
                    {{ Form::model($data['refIntegrityCategory'] ?? null, ['route' => ['ref.integrity.categories.update', $data['refIntegrityCategory']->id ?? null], 'method' => 'patch']) }}
                    <div class="ibox-title">
                        <div class="table-responsive">
                            <h5>@yield('page_title') : {{ $data['refIntegrityCategory']->descr ?? null }}</h5>
                        </div>
                    </div>
                    <div class="ibox-content">
                        @includeIf('ref.integrity.category.fields')
                    </div>
                    <div class="ibox-footer">
                        <div class="row">
                            <!-- Submit Field -->
                            <div class="form-group col-sm-12 m-b-none text-center">
                                <a href="{{ route('ref.integrity.categories.index') }}" class="btn btn-default">
                                Kembali</a>
                                {{ Form::submit('Simpan', ['class' => 'btn btn-primary']) }}
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
