@extends('layouts.main_public')

@section('content')
    <style>
        textarea {
            resize: vertical;
        }
    </style>
    <div class="row" style="padding-top: 20px; padding-bottom: 10px; background-color:#efefef;">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
        {{ Form::open(['route' => 'publiccaserating.store']) }}
            <div class="ibox float-e-margins">
                <div class="ibox-content">
                 	@includeIf('aduan.public.rating.fields')
                </div>
                <div class="ibox-footer">
                    <div class="row">
                        <!-- Submit Field -->
                        <div class="form-group col-sm-12 m-b-none text-center">
                            <a href="{{ route('dashboard') }}" class="btn btn-default">
                                @lang('button.back')
                            </a>
                            {{ Form::submit(trans('button.save'), ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                </div>
            </div>
	        {{ Form::close() }}
        </div>
        <div class="col-lg-1">
        </div>
    </div>
@endsection
