@extends('layouts.main')
<?php
    use App\Ref;
    use App\Aduan\AdminCase;
    use App\Aduan\AdminCaseDoc;
?>
@section('content')
<h2>Semak Status Aduan</h2>
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#caseinfo">MAKLUMAT ADUAN</a></li>
            <li class=""><a data-toggle="tab" href="#transaction">SOROTAN TRANSAKSI</a></li>
        </ul>
        <div class="tab-content">
            <div id="caseinfo" class="tab-pane active">
                <div class="panel-body">
                    {!! Form::open(['url' => ['public-case', $model->CA_CASEID], 'class' => 'form-horizontal', 'method' => 'POST']) !!}
                    {{ csrf_field() }}{{ method_field('PATCH') }}
                    <h4>Cara Terima</h4>
                            <div class="hr-line-solid"></div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {{ Form::label('CA_CASEID', 'No. Aduan', ['class' => 'col-sm-3 control-label']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('CA_CASEID', $model->CA_CASEID, ['class' => 'form-control input-sm']) }}
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('CA_RCVDT', 'Tarikh', ['class' => 'col-sm-3 control-label']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('CA_RCVDT', date('d-m-Y h:i A', strtotime($model->CA_RCVDT)), ['class' => 'form-control input-sm', 'readonly' => 'true']) }}
                                            @if ($errors->has('CA_RCVDT'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_RCVDT') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('CA_RCVBY') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_RCVBY', 'Penerima', ['class' => 'col-sm-3 control-label']) }}
                                        <div class="col-sm-9">
                                            <!--<div class="input-group">-->
                                                {{ Form::hidden('CA_RCVBY', $model->CA_RCVBY, ['class' => 'form-control input-sm', 'id' => 'RCVBY_id']) }}
                                                {{ Form::text('', $RcvBy, ['class' => 'form-control input-sm', 'readonly' => 'true', 'id' => 'RCVBY_name']) }}
                                                <!--<span class="input-group-btn">-->
                                                    <!--<a data-toggle="modal" class="btn btn-primary btn-sm" href="#carian-penerima">Carian</a>-->
                                                <!--</span>-->
                                                @if ($errors->has('CA_RCVBY'))
                                                    <span class="help-block"><strong>{{ $errors->first('CA_RCVBY') }}</strong></span>
                                                @endif
                                            <!--</div>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('CA_RCVTYP') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_RCVTYP', 'Cara Penerimaan', ['class' => 'col-sm-4 control-label required']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('CA_RCVTYP', $model->CA_RCVTYP != ''? Ref::GetDescr('259', $model->CA_RCVTYP, 'ms') : '', ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                            <!--{{-- Form::select('CA_RCVTYP', AdminCase::getRefList('259', true), old('CA_RCVTYP', $model->CA_RCVTYP), ['class' => 'form-control input-sm']) --}}-->
                                            @if ($errors->has('CA_RCVTYP'))
                                                <span class="help-block"><strong>{{ $errors->first('CA_RCVTYP') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: {{ in_array($model->CA_RCVTYP,['S14', 'S34']) ? 'block':'none' }};">
                                        {{ Form::label('CA_BPANO', 'No. Aduan BPA', ['class' => 'col-sm-4 control-label required']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('CA_BPANO', $model->CA_BPANO, ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                        </div>
                                    </div>
                                    <div class="form-group" style="display: {{ in_array($model->CA_RCVTYP,['S33', 'S34'])? 'block':'none' }};">
                                        {{ Form::label('CA_SERVICENO', 'No. Tali Khidmat', ['class' => 'col-sm-4 control-label required']) }}
                                        <div class="col-sm-8">
                                            {{ Form::text('CA_SERVICENO', $model->CA_SERVICENO, ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4>Maklumat Pengadu</h4>
                            <div class="hr-line-solid"></div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('CA_DOCNO') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_DOCNO', 'No. Kad Pengenalan/Pasport', ['class' => 'col-sm-6 control-label required']) }}
                                        <div class="col-sm-6">
                                            {{ Form::text('CA_DOCNO', old('CA_DOCNO', $model->CA_DOCNO), ['class' => 'form-control input-sm', 'disabled' => 'true']) }}
                                            @if ($errors->has('CA_DOCNO'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_DOCNO') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('CA_EMAIL') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_EMAIL', 'Emel', ['class' => 'col-sm-6 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::text('CA_EMAIL', old('CA_EMAIL', $model->CA_EMAIL), ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                            @if ($errors->has('CA_EMAIL'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_EMAIL') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('CA_MOBILENO') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_MOBILENO', 'No. Telefon (Bimbit)', ['class' => 'col-sm-6 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::text('CA_MOBILENO', old('CA_MOBILENO', $model->CA_MOBILENO), ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                            @if ($errors->has('CA_MOBILENO'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_MOBILENO') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('CA_TELNO') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_TELNO', 'No. Telefon (Rumah)', ['class' => 'col-sm-6 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::text('CA_TELNO', old('CA_TELNO', $model->CA_TELNO), ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                            @if ($errors->has('CA_TELNO'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_TELNO') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('CA_FAXNO') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_FAXNO', 'No. Faks', ['class' => 'col-sm-6 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::text('CA_FAXNO', old('CA_FAXNO', $model->CA_FAXNO), ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                            @if ($errors->has('CA_FAXNO'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_FAXNO') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('CA_ADDR') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_ADDR', 'Alamat', ['class' => 'col-sm-6 control-label']) }}
                                        <div class="col-sm-6">
                                            {{ Form::textarea('CA_ADDR', old('CA_ADDR', $model->CA_ADDR), ['class' => 'form-control input-sm', 'rows'=>'4', 'readonly' => true]) }}
                                            @if ($errors->has('CA_ADDR'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_ADDR') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group{{ $errors->has('CA_NAME') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_NAME', 'Nama', ['class' => 'col-sm-3 control-label required']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('CA_NAME', old('CA_NAME', $model->CA_NAME), ['class' => 'form-control input-sm', 'disabled' => 'true']) }}
                                            @if ($errors->has('CA_NAME'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_NAME') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('CA_AGE') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_AGE', 'Umur', ['class' => 'col-sm-3 control-label']) }}
                                        <div class="col-sm-9">
                                            {{ Form::text('CA_AGE', $model->CA_AGE, ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                            @if ($errors->has('CA_AGE'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_AGE') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group{{ $errors->has('CA_SEXCD') ? ' has-error' : '' }}">
                                        {{ Form::label('CA_SEXCD', 'Jantina', ['class' => 'col-sm-3 control-label']) }}
                                        <div class="col-sm-9">
                                            {{ Form::select('CA_SEXCD', Ref::GetList('202', true, 'ms'), old('CA_SEXCD', $model->CA_SEXCD), ['class' => 'form-control input-sm', 'id' => 'CA_SEXCD', 'disabled' => 'true']) }}
                                            @if ($errors->has('CA_SEXCD'))
                                            <span class="help-block"><strong>{{ $errors->first('CA_SEXCD') }}</strong></span>
                                            @endif
                                        </div>
                                    </div>
                                    <div id="warganegara" style="display: {{ $model->CA_NATCD == '1' ? 'block' : 'none' }}">
                                        <div class="form-group {{ $errors->has('CA_POSCD') ? ' has-error' : 'CA_POSCD' }}">
                                            {{ Form::label('CA_POSCD', 'Poskod', ['class' => 'col-sm-3 control-label']) }}
                                            <div class="col-sm-9">
                                                {{ Form::text('CA_POSCD', old('CA_POSCD', $model->CA_POSCD), ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                                @if ($errors->has('CA_POSCD'))
                                                <span class="help-block"><strong>{{ $errors->first('CA_POSCD') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('CA_STATECD') ? ' has-error' : 'CA_STATECD' }}">
                                            {{ Form::label('CA_STATECD', 'Negeri', ['class' => 'col-sm-3 control-label required']) }}
                                            <div class="col-sm-9">
                                                {{ Form::text('CA_STATECD', $model->CA_STATECD != ''? Ref::GetDescr('17', $model->CA_STATECD, 'ms') : '', ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                                @if ($errors->has('CA_STATECD'))
                                                <span class="help-block"><strong>{{ $errors->first('CA_STATECD') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="form-group {{ $errors->has('CA_DISTCD') ? ' has-error' : 'CA_DISTCD' }}">
                                            {{ Form::label('CA_DISTCD', 'Daerah', ['class' => 'col-sm-3 control-label required']) }}
                                            <div class="col-sm-9">
                                                {{ Form::text('CA_DISTCD', ($model->CA_DISTCD != '' ? Ref::GetDescr('18', $model->CA_DISTCD, 'ms') : ''), ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                                @if ($errors->has('CA_DISTCD'))
                                                <span class="help-block"><strong>{{ $errors->first('CA_DISTCD') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div id="bknwarganegara" style="display: {{ $model->CA_NATCD == '0' ? 'block' : 'none' }}">
                                        <div class="form-group {{ $errors->has('CA_COUNTRYCD') ? ' has-error' : 'CA_COUNTRYCD' }}">
                                            {{ Form::label('CA_COUNTRYCD', 'Negara', ['class' => 'col-sm-3 control-label required']) }}
                                            <div class="col-sm-9">
                                                {{ Form::select('CA_COUNTRYCD', Ref::GetList('334', true, 'ms'), old('CA_COUNTRYCD', $model->CA_COUNTRYCD), ['class' => 'form-control input-sm']) }}
                                                @if ($errors->has('CA_COUNTRYCD'))
                                                <span class="help-block"><strong>{{ $errors->first('CA_COUNTRYCD') }}</strong></span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    <h4>Maklumat Aduan</h4>
                    <div class="hr-line-solid"></div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('CA_CMPLCAT') ? ' has-error' : '' }}">
                                <label for="CA_CMPLCAT" class="col-sm-4 control-label required">@lang('public-case.case.CA_CMPLCAT')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_CMPLCAT', $model->CA_CMPLCAT != ''? Ref::GetDescr('244', $model->CA_CMPLCAT, 'ms') : '', array('class' => 'form-control input-sm', 'id' => 'CA_CMPLCAT')) }}
                                    <!--{{-- Form::select('CA_CMPLCAT', (Auth::user()->lang == 'ms' ? Ref::GetList('244', true) : Ref::GetList('244', true, 'en')), $model->CA_CMPLCAT, array('class' => 'form-control input-sm', 'id' => 'CA_CMPLCAT')) --}}-->
                                    @if ($errors->has('CA_CMPLCAT'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_CMPLCAT')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('CA_CMPLCD') ? ' has-error' : '' }}">
                                <label for="CA_CMPLCD" class="col-sm-4 control-label required">@lang('public-case.case.CA_CMPLCD')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_CMPLCD', $model->CA_CMPLCD != ''? Ref::GetDescr('634', $model->CA_CMPLCD, 'ms') : '', ['class' => 'form-control input-sm']) }}
                                    <!--{{-- Form::select('CA_CMPLCD', $model->CA_CMPLCAT == '' ? [''=>'-- SILA PILIH --'] : AdminCase::getcmplcdlist($model->CA_CMPLCAT), old('CA_CMPLCD', $model->CA_CMPLCD), ['class' => 'form-control input-sm']) --}}-->
                                    <!--{{-- Form::select('CA_CMPLCD', PublicCase::GetCmplCd((old('CA_CMPLCAT')? old('CA_CMPLCAT') : ($model->CMPLCAT? $model->CA_CMPLCAT:'')), Auth::user()->lang), (old('CA_CMPLCD')? old('CA_CMPLCD') : ($model->CA_CMPLCD? $model->CA_CMPLCD:'')), ['class' => 'form-control input-sm', 'id' => 'CA_CMPLCD']) --}}-->
                                    @if ($errors->has('CA_CMPLCD'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_CMPLCD')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('CA_CMPLKEYWORD') ? ' has-error' : '' }}" id="CA_CMPLKEYWORD" style="display: {{ (old('CA_CMPLCAT')? (in_array(old('CA_CMPLCAT'),['BPGK 01','BPGK 03'])? 'block':'none') : ((in_array($model->CA_CMPLCAT,['BPGK 01','BPGK 03'])? 'block':'none')))  }};">
                                <label for="CA_CMPLKEYWORD" class="col-sm-4 control-label required">@lang('public-case.case.CA_CMPLKEYWORD')</label>
                                <div class="col-sm-8">
                                    {{ Form::select('CA_CMPLKEYWORD',Ref::GetList('1051',true, Auth::user()->lang), $model->CA_CMPLKEYWORD,['class' => 'form-control  input-sm'])}}
                                    @if ($errors->has('CA_CMPLKEYWORD'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_CMPLKEYWORD')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="div_CA_ONLINECMPL_PROVIDER" style="display: {{ (old('CA_CMPLCAT')? (old('CA_CMPLCAT') == 'BPGK 19'? 'block':'none') : ($model->CA_CMPLCAT == 'BPGK 19'? 'block':'none')) }};" class="form-group{{ $errors->has('CA_ONLINECMPL_PROVIDER') ? ' has-error' : '' }}">
                                <label for="CA_ONLINECMPL_PROVIDER" class="col-sm-4 control-label required">@lang('public-case.case.CA_ONLINECMPL_PROVIDER')</label>
                                <div class="col-sm-8">
                                    {{ Form::select('CA_ONLINECMPL_PROVIDER',Ref::GetList('1091',true, Auth::user()->lang), $model->CA_ONLINECMPL_PROVIDER, ['class' => 'form-control input-sm', 'id' => 'CA_ONLINECMPL_PROVIDER']) }}
                                    @if ($errors->has('CA_ONLINECMPL_PROVIDER'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_ONLINECMPL_PROVIDER')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="div_CA_ONLINECMPL_URL" style="display: {{ (old('CA_CMPLCAT')? (old('CA_CMPLCAT') == 'BPGK 19'? 'block':'none') : ($model->CA_CMPLCAT == 'BPGK 19'? 'block':'none')) }};" class="form-group{{ $errors->has('CA_ONLINECMPL_URL') ? ' has-error' : '' }}">
                                <label for="CA_ONLINECMPL_URL" class="col-sm-4 control-label required">@lang('public-case.case.CA_ONLINECMPL_URL')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_ONLINECMPL_URL',$model->CA_ONLINECMPL_URL, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_ONLINECMPL_URL'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_ONLINECMPL_URL')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="div_CA_ONLINECMPL_AMOUNT" style="display: {{ (old('CA_CMPLCAT')? (old('CA_CMPLCAT') == 'BPGK 19'? 'block':'none') : ($model->CA_CMPLCAT == 'BPGK 19'? 'block':'none')) }};" class="form-group{{ $errors->has('CA_ONLINECMPL_AMOUNT') ? ' has-error' : '' }}">
                                <label for="CA_ONLINECMPL_AMOUNT" class="col-sm-4 control-label required">@lang('public-case.case.CA_ONLINECMPL_AMOUNT')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_ONLINECMPL_AMOUNT', $model->CA_ONLINECMPL_AMOUNT, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_ONLINECMPL_AMOUNT'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_ONLINECMPL_AMOUNT')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="div_CA_ONLINECMPL_ACCNO" style="display: {{ (old('CA_CMPLCAT')? (old('CA_CMPLCAT') == 'BPGK 19'? 'block':'none') : ($model->CA_CMPLCAT == 'BPGK 19'? 'block':'none')) }};" class="form-group{{ $errors->has('CA_ONLINECMPL_ACCNO') ? ' has-error' : '' }}">
                                <label for="CA_ONLINECMPL_ACCNO" class="col-sm-4 control-label required">@lang('public-case.case.CA_ONLINECMPL_ACCNO')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_ONLINECMPL_ACCNO', $model->CA_ONLINECMPL_ACCNO, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_ONLINECMPL_ACCNO'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_ONLINECMPL_ACCNO')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="div_CA_AGAINST_PREMISE" style="display: {{ (old('CA_CMPLCAT')? (old('CA_CMPLCAT') == 'BPGK 19'? 'none':'block') : ($model->CA_CMPLCAT == 'BPGK 19'? 'none':'block')) }};" class="form-group{{ $errors->has('CA_AGAINST_PREMISE') ? ' has-error' : '' }}">
                                <label for="CA_AGAINST_PREMISE" class="col-sm-4 control-label required">@lang('public-case.case.CA_AGAINST_PREMISE')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_AGAINST_PREMISE', $model->CA_AGAINST_PREMISE != ''? Ref::GetDescr('221', $model->CA_AGAINST_PREMISE) : '', ['class' => 'form-control input-sm', 'readonly' => true]) }}
                                    <!--{{-- Form::select('CA_AGAINST_PREMISE', Auth::user()->lang == 'ms' ? Ref::GetList('221', true) : Ref::GetList('221', true, 'en'), $model->CA_AGAINST_PREMISE, ['class' => 'form-control input-sm', 'id' => 'CA_AGAINST_PREMISE']) --}}-->
                                    @if ($errors->has('CA_AGAINST_PREMISE'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_AGAINST_PREMISE')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group" style="display: {{ (old('CA_CMPLCAT')? (old('CA_CMPLCAT') == 'BPGK 19'? 'block':'none') : ($model->CA_CMPLCAT == 'BPGK 19'? 'block':'none')) }};" id="checkpernahadu">
                                {{ Form::label(old('CA_ONLINECMPL_IND'), null, ['class' => 'col-md-4 control-label']) }}
                                <div class="col-sm-6">
                                    <div class="checkbox checkbox-success">
                                        <input name="CA_ONLINECMPL_IND" id="CA_ONLINECMPL_IND" type="checkbox" onclick="onlinecmplind()" {{ old('CA_ONLINECMPL_IND') == 'on'? 'checked':'' || $model->CA_ONLINECMPL_IND == '1'? 'checked':'' }}>
                                        <label for="CA_ONLINECMPL_IND">
                                            Pernah membuat aduan di pihak diadu?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="div_CA_ONLINECMPL_CASENO" style="display: {{ (old('CA_CMPLCAT') == 'BPGK 19'? (old('CA_CMPLCAT') == 'BPGK 19' && old('CA_ONLINECMPL_IND') == 'on'? 'block':($model->CA_CMPLCAT == 'BPGK 19' && $model->CA_ONLINECMPL_IND == '1'? 'block':'none')): old('CA_CMPLCAT') == '' && $model->CA_CMPLCAT == 'BPGK 19'? (old('CA_ONLINECMPL_IND') == '' && $model->CA_ONLINECMPL_IND == '1'? 'block':(old('CA_ONLINECMPL_IND') == 'on'? 'block':'none')):'none' ) }} ;" class="form-group{{ $errors->has('CA_ONLINECMPL_CASENO') ? ' has-error' : '' }}">
                                <label for="CA_ONLINECMPL_CASENO" class="col-sm-4 control-label required">@lang('public-case.case.CA_ONLINECMPL_CASENO')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_ONLINECMPL_CASENO',$model->CA_ONLINECMPL_CASENO, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_ONLINECMPL_CASENO'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_ONLINECMPL_CASENO')</strong></span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group{{ $errors->has('CA_AGAINST_TELNO') ? ' has-error' : '' }}">
                                <label for="CA_AGAINST_TELNO" class="col-sm-4 control-label">@lang('public-case.case.CA_AGAINST_TELNO')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_AGAINST_TELNO', $model->CA_AGAINST_TELNO, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_AGAINST_TELNO'))
                                    <span class="help-block"><strong>{{ $errors->first('CA_AGAINST_TELNO') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('CA_AGAINST_MOBILENO') ? ' has-error' : '' }}">
                                <label for="CA_AGAINST_MOBILENO" class="col-sm-4 control-label">@lang('public-case.case.CA_AGAINST_MOBILENO')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_AGAINST_MOBILENO', $model->CA_AGAINST_MOBILENO, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_AGAINST_MOBILENO'))
                                    <span class="help-block"><strong>{{ $errors->first('CA_AGAINST_MOBILENO') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('CA_AGAINST_EMAIL') ? ' has-error' : '' }}">
                                <label for="CA_AGAINST_EMAIL" class="col-sm-4 control-label">@lang('public-case.case.CA_AGAINST_EMAIL')</label>
                                <div class="col-sm-8">
                                    {{ Form::email('CA_AGAINST_EMAIL', $model->CA_AGAINST_EMAIL, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_AGAINST_EMAIL'))
                                    <span class="help-block"><strong>{{ $errors->first('CA_AGAINST_EMAIL') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group{{ $errors->has('CA_AGAINST_FAXNO') ? ' has-error' : '' }}">
                                <label for="CA_AGAINST_FAXNO" class="col-sm-4 control-label">@lang('public-case.case.CA_AGAINST_FAXNO')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_AGAINST_FAXNO', $model->CA_AGAINST_FAXNO, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_AGAINST_FAXNO'))
                                    <span class="help-block"><strong>{{ $errors->first('CA_AGAINST_FAXNO') }}</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group{{ $errors->has('CA_AGAINSTNM') ? ' has-error' : '' }}">
                                <label for="CA_AGAINSTNM" class="col-sm-4 control-label required">@lang('public-case.case.CA_AGAINSTNM')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_AGAINSTNM', $model->CA_AGAINSTNM, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_AGAINSTNM'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_AGAINSTNM')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="checkinsertadd" style="display: {{ (old('CA_CMPLCAT')? (old('CA_CMPLCAT') == 'BPGK 19'? 'block':'none') : ($model->CA_CMPLCAT == 'BPGK 19'? 'block':'none')) }};" class="form-group">
                                {{ Form::label(old('CA_ONLINEADD_IND'), null, ['class' => 'col-md-4 control-label']) }}
                                <div class="col-sm-6">
                                    <div class="checkbox checkbox-success">
                                        <input name="CA_ONLINEADD_IND" id="CA_ONLINEADD_IND" type="checkbox" onclick="onlineaddind()" {{ old('CA_ONLINEADD_IND') == 'on'? 'checked':'' || $model->CA_ONLINEADD_IND == '1'? 'checked':'' }}>
                                        <label for="CA_ONLINEADD_IND">
                                            Mempunyai alamat penuh pembekal perkhidmatan?
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div id="div_CA_AGAINSTADD" style="display: {{ (old('CA_CMPLCAT') == 'BPGK 19'? (old('CA_CMPLCAT') == 'BPGK 19' && old('CA_ONLINEADD_IND') == 'on'? 'block':($model->CA_CMPLCAT == 'BPGK 19' && $model->CA_ONLINEADD_IND == '1'? 'block':'none')): old('CA_CMPLCAT') == '' && $model->CA_CMPLCAT == 'BPGK 19'? (old('CA_ONLINEADD_IND') == '' && $model->CA_ONLINEADD_IND == '1'? 'block':(old('CA_ONLINEADD_IND') == 'on'? 'block':'none')):'block' ) }} ;" class="form-group{{ $errors->has('CA_AGAINSTADD') ? ' has-error' : '' }}">
                                <label for="CA_AGAINSTADD" class="col-sm-4 control-label required">@lang('public-case.case.CA_AGAINSTADD')</label>
                                <div class="col-sm-8">
                                    {{ Form::textarea('CA_AGAINSTADD', $model->CA_AGAINSTADD, ['class' => 'form-control input-sm', 'rows'=> '4']) }}
                                    @if ($errors->has('CA_AGAINSTADD'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_AGAINSTADD')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="div_CA_AGAINST_POSTCD" style="display: {{ (old('CA_CMPLCAT') == 'BPGK 19'? (old('CA_CMPLCAT') == 'BPGK 19' && old('CA_ONLINEADD_IND') == 'on'? 'block':($model->CA_CMPLCAT == 'BPGK 19' && $model->CA_ONLINEADD_IND == '1'? 'block':'none')): old('CA_CMPLCAT') == '' && $model->CA_CMPLCAT == 'BPGK 19'? (old('CA_ONLINEADD_IND') == '' && $model->CA_ONLINEADD_IND == '1'? 'block':(old('CA_ONLINEADD_IND') == 'on'? 'block':'none')):'block' ) }} ;" class="form-group{{ $errors->has('CA_AGAINST_POSTCD') ? ' has-error' : '' }}">
                                <label for="CA_AGAINST_POSTCD" class="col-sm-4 control-label required">@lang('public-case.case.CA_AGAINST_POSTCD')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_AGAINST_POSTCD', $model->CA_AGAINST_POSTCD, ['class' => 'form-control input-sm']) }}
                                    @if ($errors->has('CA_AGAINST_POSTCD'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_AGAINST_POSTCD')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="div_CA_AGAINST_STATECD" style="display: {{ (old('CA_CMPLCAT') == 'BPGK 19'? (old('CA_CMPLCAT') == 'BPGK 19' && old('CA_ONLINEADD_IND') == 'on'? 'block':($model->CA_CMPLCAT == 'BPGK 19' && $model->CA_ONLINEADD_IND == '1'? 'block':'none')): old('CA_CMPLCAT') == '' && $model->CA_CMPLCAT == 'BPGK 19'? (old('CA_ONLINEADD_IND') == '' && $model->CA_ONLINEADD_IND == '1'? 'block':(old('CA_ONLINEADD_IND') == 'on'? 'block':'none')):'block' ) }} ;" class="form-group{{ $errors->has('CA_AGAINST_STATECD') ? ' has-error' : '' }}">
                                <label class="col-sm-4 control-label required">@lang('public-case.case.CA_AGAINST_STATECD')</label>
                                <div class="col-sm-8">
                                    {{ Form::select('CA_AGAINST_STATECD', Ref::GetList('17', true), $model->CA_AGAINST_STATECD, ['class' => 'form-control input-sm', 'id' => 'CA_AGAINST_STATECD']) }}
                                    @if ($errors->has('CA_AGAINST_STATECD'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_AGAINST_STATECD')</strong></span>
                                    @endif
                                </div>
                            </div>
                            <div id="div_CA_AGAINST_DISTCD" style="display: {{ (old('CA_CMPLCAT') == 'BPGK 19'? (old('CA_CMPLCAT') == 'BPGK 19' && old('CA_ONLINEADD_IND') == 'on'? 'block':($model->CA_CMPLCAT == 'BPGK 19' && $model->CA_ONLINEADD_IND == '1'? 'block':'none')): old('CA_CMPLCAT') == '' && $model->CA_CMPLCAT == 'BPGK 19'? (old('CA_ONLINEADD_IND') == '' && $model->CA_ONLINEADD_IND == '1'? 'block':(old('CA_ONLINEADD_IND') == 'on'? 'block':'none')):'block' ) }} ;" class="form-group{{ $errors->has('CA_AGAINST_DISTCD') ? ' has-error' : '' }}">
                                <label class="col-sm-4 control-label required">@lang('public-case.case.CA_AGAINST_DISTCD')</label>
                                <div class="col-sm-8">
                                    {{ Form::text('CA_AGAINST_DISTCD', ($model->CA_AGAINST_DISTCD != '' ? Ref::GetDescr('18', $model->CA_AGAINST_DISTCD, 'ms') : ''), ['class' => 'form-control input-sm']) }}
                                    <!--{{-- Form::select('CA_AGAINST_DISTCD', ($model->CA_AGAINST_STATECD == '' ? ['' => '-- SILA PILIH --'] : PublicCase::GetDstrtList($model->CA_AGAINST_STATECD)), $model->CA_AGAINST_DISTCD, ['class' => 'form-control input-sm', 'id' => 'CA_AGAINST_DISTCD']) --}}-->
                                    @if ($errors->has('CA_AGAINST_DISTCD'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_AGAINST_DISTCD')</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group{{ $errors->has('CA_SUMMARY') ? ' has-error' : '' }}">
                                <label for="CA_SUMMARY" class="col-sm-2 control-label required">@lang('public-case.case.CA_SUMMARY')</label>
                                <div class="col-sm-10">
                                    {{ Form::textarea('CA_SUMMARY', $model->CA_SUMMARY, ['class' => 'form-control input-sm', 'rows'=> '5']) }}
                                    @if ($errors->has('CA_SUMMARY'))
                                    <span class="help-block"><strong>@lang('public-case.validation.CA_SUMMARY')</strong></span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <h4>Bukti Aduan</h4>
                        <div class="hr-line-solid"></div>
                        <table>
                            <tr>
                                @foreach($mCallCenterCaseDoc as $CallCenterCaseDoc)
                                <td style="max-width: 10%"><div class="p-sm"><img src="{{ Storage::disk('bahanpath')->url($CallCenterCaseDoc->CC_PATH.$CallCenterCaseDoc->CC_IMG) }}" class="img-lg img-thumbnail"/></div></td>
                                <td style="max-width: 10%">{{ $CallCenterCaseDoc->CC_REMARKS }}</td>
                                @endforeach
                            </tr>
                        </table>
                    </div>
                    <div class="form-group col-sm-12" align="center">
                        <a class="btn btn-info btn-sm" href="{{ url('call-center-case') }}">@lang('button.back')</a>
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
            <div id="transaction" class="tab-pane fade">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table id="admin-case-transaction-table" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>Bil.</th>
                                    <th>Status</th>
                                    <th>Daripada</th>
                                    <th>Kepada</th>
                                    <th>Tarikh Transaksi</th>
                                    <th>Saranan</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!-- Modal Create Attachment Start -->
<div class="modal fade" id="modal-create-attachment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" id='modalCreateContent'></div>
    </div>
</div>
<!-- Modal Edit Attachment Start -->
<div class="modal fade" id="modal-edit-attachment" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content" id='modalEditContent'></div>
    </div>
</div>
@stop

@section('script_datatable')
<script type="text/javascript">
    
    $( document ).ready(function() {
        var status = <?php echo $model->CA_INVSTS; ?>;
        if(status != '10') {
            $('.form-control').attr("disabled", true);
        }
    });
    
    function onlinecmplind() {
        if (document.getElementById('CA_ONLINECMPL_IND').checked)
        {
            $('#div_CA_ONLINECMPL_CASENO').show();
        }
        else
        {
            $('#div_CA_ONLINECMPL_CASENO').hide();
        }
    };
    
    function ModalAttachmentCreate(CASEID) {
        $('#modal-create-attachment').modal("show").find("#modalCreateContent").load("{{ route('public-case-doc.create','') }}" + "/" + CASEID);
        return false;
    }
    
    function ModalAttachmentEdit(ID) {;
        $('#modal-edit-attachment').modal("show").find("#modalEditContent").load("{{ route('public-case-doc.edit','') }}" + "/" + ID);
        return false;
    }
    
    var hash = document.location.hash;
    if (hash) {
        $('.nav-tabs a[href='+hash+']').tab('show');
    } 
    
    // Change hash for page-reload
    $('.nav-tabs a').on('shown.bs.tab', function (e) {
        window.location.hash = e.target.hash;
    });
    
    var CA_INVSTS = $('#CA_INVSTS').val();
    if(CA_INVSTS === 1){
        $('#deletebutton').hide();
    }
    
    function onlineaddind() {
        if (document.getElementById('CA_ONLINEADD_IND').checked) {
            $('#div_CA_AGAINSTADD').show();
            $('#div_CA_AGAINST_POSTCD').show();
            $('#div_CA_AGAINST_STATECD').show();
            $('#div_CA_AGAINST_DISTCD').show();
        }else{
            $('#div_CA_AGAINSTADD').hide();
            $('#div_CA_AGAINST_POSTCD').hide();
            $('#div_CA_AGAINST_STATECD').hide();
            $('#div_CA_AGAINST_DISTCD').hide();
        }
    };
    
    $(function () {
        
        $('#CA_AGAINST_STATECD').on('change', function (e) {
            var CA_AGAINST_STATECD = $(this).val();
            $.ajax({
                type: 'GET',
                url: "{{ url('sas-case/getdistrictlist') }}" + "/" + CA_AGAINST_STATECD,
                dataType: "json",
                success:function(data){
                    $('select[name="CA_AGAINST_DISTCD"]').empty();
                    $.each(data, function(key, value) {
                        if(value == '0')
                            $('select[name="CA_AGAINST_DISTCD"]').append('<option value="">'+ key +'</option>');
                        else
                            $('select[name="CA_AGAINST_DISTCD"]').append('<option value="'+ value +'">'+ key +'</option>');
                    });
                }
            });
        });
        
        $('#CA_ONLINECMPL_PROVIDER').on('change', function (e) {
            var CA_ONLINECMPL_PROVIDER = $(this).val();
            if(CA_ONLINECMPL_PROVIDER === '999')
                $( "label[for='CA_ONLINECMPL_URL']" ).addClass( "required" );
            else
                $( "label[for='CA_ONLINECMPL_URL']" ).removeClass( "required" );
        });
        
        $('#CA_CMPLCAT').on('change', function (e) {
            var CA_CMPLCAT = $(this).val();
            
            if(CA_CMPLCAT === 'BPGK 01' || CA_CMPLCAT === 'BPGK 03') {
                $( "#CA_CMPLKEYWORD" ).show();
            }else{
                $( "#CA_CMPLKEYWORD" ).hide();
            }
            
            if(CA_CMPLCAT === 'BPGK 19') {
                if (document.getElementById('CA_ONLINECMPL_IND').checked)
                    $('#div_CA_ONLINECMPL_CASENO').show();
                else
                    $('#div_CA_ONLINECMPL_CASENO').hide();
                
                $( "#checkpernahadu" ).show();
                $( "#checkinsertadd" ).show();
                $('#div_CA_ONLINECMPL_PROVIDER').show();
                $('#div_CA_ONLINECMPL_URL').show();
                $('#div_CA_ONLINECMPL_AMOUNT').show();
                $('#div_CA_ONLINECMPL_ACCNO').show();
                $('#div_CA_AGAINST_PREMISE').hide();
                $('#div_CA_AGAINSTADD').hide();
                $('#div_CA_AGAINST_POSTCD').hide();
                $('#div_CA_AGAINST_STATECD').hide();
                $('#div_CA_AGAINST_DISTCD').hide();
                $( "label[for='CA_ONLINECMPL_URL']" ).removeClass( "required" );
//                $( "label[for='CA_AGAINST_PREMISE']" ).removeClass( "required" );
//                $( "label[for='CA_AGAINSTADD']" ).removeClass( "required" );
//                $( "label[for='CA_AGAINST_POSTCD']" ).removeClass( "required" );
            }else{
                $( "#checkpernahadu" ).hide();
                $( "#checkinsertadd" ).hide();
                $('#div_CA_ONLINECMPL_CASENO').hide();
                $('#div_CA_ONLINECMPL_PROVIDER').hide();
                $('#div_CA_ONLINECMPL_URL').hide();
                $('#div_CA_ONLINECMPL_AMOUNT').hide();
                $('#div_CA_ONLINECMPL_ACCNO').hide();
                $('#div_CA_AGAINST_PREMISE').show();
                $('#div_CA_AGAINSTADD').show();
                $('#div_CA_AGAINST_POSTCD').show();
                $('#div_CA_AGAINST_STATECD').show();
                $('#div_CA_AGAINST_DISTCD').show();
//                $( "label[for='CA_AGAINST_PREMISE']" ).addClass( "required" );
//                $( "label[for='CA_AGAINSTADD']" ).addClass( "required" );
//                $( "label[for='CA_AGAINST_POSTCD']" ).addClass( "required" );
            }
            
            $.ajax({
                type: 'GET',
                url: "{{ url('public-case/getCmplCdList') }}" + "/" + CA_CMPLCAT,
                dataType: "json",
                success: function (data) {
                    console.log(data);
                    $('select[name="CA_CMPLCD"]').empty();
                    $.each(data, function (key, value) {
                        if (value == '0')
                            $('select[name="CA_CMPLCD"]').append('<option value="">' + key + '</option>');
                        else
                            $('select[name="CA_CMPLCD"]').append('<option value="' + value + '">' + key + '</option>');
                    });
                }
            });
        });
        
        $('#public-case-attachmnt-table').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            aaSorting: [],
            bLengthChange: false,
            bPaginate: false,
            bInfo: false,
            language: {
                zeroRecords: "@lang('datatable.infoEmpty')",
                infoEmpty: "@lang('datatable.infoEmpty')"
            },
            ajax: {
                url: "{{ url('public-case-doc/getDatatable',$model->CA_CASEID)}}"
            },
            columns: [
                {data: 'DT_Row_Index', name: 'id', 'width': '5%', searchable: false, orderable: false},
                {data: 'CC_IMG_NAME', name: 'CC_IMG_NAME'},
                {data: 'CC_REMARKS', name: 'CC_REMARKS'},
                {data: 'action', name: 'action', searchable: false, orderable: false}
            ]
        });
        
        $('#admin-case-transaction-table').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            aaSorting: [],
            bLengthChange: false,
            bPaginate: false,
            bInfo: false,
            language: {
                lengthMenu: 'Paparan _MENU_ rekod',
                zeroRecords: 'Tiada rekod ditemui',
                info: 'Memaparkan _START_-_END_ daripada _TOTAL_ rekod',
                infoEmpty: 'Tiada rekod ditemui',
                infoFiltered: '(Paparan daripada _MAX_ jumlah rekod)',
                paginate: {
                    previous: '<i class="fa fa-chevron-left" aria-hidden="true"></i>',
                    next: '<i class="fa fa-chevron-right" aria-hidden="true"></i>',
                    first: 'Pertama',
                    last: 'Terakhir'
                }
            },
            ajax: {
                url: "{{ url('admin-case/getdatatabletransaction', $model->CA_CASEID)}}",
            },
            columns: [
                {data: 'DT_Row_Index', name: 'id', 'width': '5%', searchable: false, orderable: false},
                {data: 'CD_INVSTS', name: 'CD_INVSTS'},
                {data: 'CD_ACTFROM', name: 'CD_ACTFROM'},
                {data: 'CD_ACTTO', name: 'CD_ACTTO'},
                {data: 'CD_CREDT', name: 'CD_CREDT'},
                {data: 'CD_DESC', name: 'CD_DESC'}
            ]
        });
    });

</script>
@stop
