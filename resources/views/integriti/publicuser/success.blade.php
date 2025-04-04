@extends('layouts.app')
<?php
    use App\Ref;
    use App\User;
?>
@section('content')
<style>
    textarea {
        resize: vertical;
    }    
</style>
<div class="ibox floating-container">
    <div class="ibox-content" style="padding: 0px;">
        <nav class="navbar navbar-static-top" role="navigation" style="margin:0;background: #115272 !important;border-bottom: 3px solid #fac626; ">
            <div class="navbar-header">
                <button aria-controls="navbar" aria-expanded="false" data-target="#navbarmenu" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <div class="navbar-collapse collapse" id="navbarmenu" style="padding-left:15px;padding-right:15px;">
                <ul class="nav navbar-top-links navbar-left">
                    <li>
                        <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAGQAAABkCAYAAABw4pVUAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMC1jMDYwIDYxLjEzNDc3NywgMjAxMC8wMi8xMi0xNzozMjowMCAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNSBNYWNpbnRvc2giIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6RUI5NjZBOTZBOTc0MTFFNzhDMTNFOTlBNEUyRUVBMDgiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6RUI5NjZBOTdBOTc0MTFFNzhDMTNFOTlBNEUyRUVBMDgiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpFQjk2NkE5NEE5NzQxMUU3OEMxM0U5OUE0RTJFRUEwOCIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpFQjk2NkE5NUE5NzQxMUU3OEMxM0U5OUE0RTJFRUEwOCIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PqPhDOYAADxxSURBVHja3H15kGZX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" style="max-height:30px;min-height:30px;" alt="eAduanV2">
                    </li>
                    <li style="background-color: #115272 !important;"><a style="background-color: #115272; color: white; " href="{{ url('/') }}">{{ app()->getLocale() == 'en' ? 'HOME' : 'HALAMAN UTAMA' }}</a></li>
                </ul>
            </div>
        </nav>
        <div class="loginColumns" style="padding : 20px 20px 20px">
            <div class="row">
                <div class="col-lg-12">
                    {{-- Form::open(['class' => 'form-horizontal']) --}}
                    {{-- csrf_field() --}}
                    <div class="form-horizontal">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <span style="font-size: 14px;" class="label label-success">4</span>
                                {{-- Semakan Aduan Integriti --}}
                                @lang('button.success')
                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div 
                                        class="col-sm-6 col-sm-offset-3 widget text-center"
                                        style="color: #1c84c6;">
                                        <div class="m-b-md">
                                            <p>
                                                @lang('public-case.success.receivenote')
                                            </p>
                                            <p>
                                                @lang('public-case.case.CA_CASEID') : 
                                                <strong>{{ $model->IN_CASEID }}</strong>
                                            </p>
                                            @if($model->IN_EMAIL)
                                            <p>
                                                @lang('public-case.success.emailnotify') 
                                                <strong>{{ $model->IN_EMAIL }}</strong>
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-footer">
                                <div class="text-center">
                                    <!-- a href="{{ url('')}}" type="button" class="btn btn-default">@lang('button.back')</a -->
                                    {{-- Form::button('Simpan & Seterusnya'.' <i class="fa fa-chevron-right"></i>', ['type' => 'submit', 'class' => 'btn btn-success']) --}}
                                    <a type="button" href="{{ url('integriti')}}" 
                                        class="btn btn-success">
                                        <i class="fa fa-home"></i> 
                                        @lang('public-case.case.dashboard')
                                    </a>
                                    <a type="button" 
                                        href="{{ url('integritipublicuser/create') }}" 
                                        class="btn btn-success">
                                        <i class="fa fa-plus"></i>
                                        @lang('public-case.case.newcomplaint')
                                    </a>
                                    <a type="button" target="_blank" 
                                        href="{{ url('integritipublicuser/printsuccess', $model->id) }}" 
                                        class="btn btn-success">
                                        <i class="fa fa-print"></i> 
                                        @lang('public-case.case.print')
                                    </a>
                                </div>
                            </div>
                        </div>
                    {{-- Form::close() --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Confirmation Start -->
<div class="modal inmodal" id="confirm-submit" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content animated bounceIn" id='modalEditContent' style="border-radius: 30px;">
            <div class="modal-header" style="border-radius: 25px 25px 0px 0px; background: #115272; background: -moz-linear-gradient(#115272, white); color: black; text-align: center;">
                <strong>{{ trans('public-case.confirmation.service') }}</strong>
            </div>
            {!! Form::open(['route' => ['integritipublicuser.submit',$model->id], 'class' => 'form-horizontal', 'method' => 'POST']) !!}
            {{ csrf_field() }}
            {{-- method_field('POST') --}}
            <div class="modal-body" style="background: white; ">
                    <div class="row">
                        <div class="col-sm-4 text-center">
                            <label for="rating3"><img for="rating3" style="width: 50% !important;" src="{{ url('img/perform5.png') }}" /></label>
                            <div class="radio radio-primary">
                                <input id="rating3" type="radio" value="3" name="rating" checked><label for="rating3"></label>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <label for="rating2"><img alt="image" style="width: 50% !important;" src="{{ url('img/perform4.png') }}" /></label>
                            <div class="radio radio-primary">
                                <input id="rating2" type="radio" value="2" name="rating"><label for="rating2"></label>
                            </div>
                        </div>
                        <div class="col-sm-4 text-center">
                            <label for="rating1"><img alt="image" style="width: 50% !important;" src="{{ url('img/perform3.png') }}" /></label>
                            <div class="radio radio-primary">
                                <input id="rating1" type="radio" value="1" name="rating"><label for="rating1"></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer" style="border-radius:0px 0px 25px 25px; background: #115272; background: -moz-linear-gradient(bottom, #115272, white); color: black;">
                    <p class="text-center">
                        <strong>{{ trans('public-case.confirmation.submit') }}</strong>
                    </p>
                    <!--<strong class="center">{{-- trans('public-case.confirmation.submit') --}}</strong>-->
                    <p class="text-center">
                        <button type="button" class="btn btn-sm btn-warning" data-dismiss="modal">@lang('public-case.confirmation.btncancel')</button>
                        <button type="submit" class="btn btn-sm btn-success" >@lang('public-case.confirmation.btnsubmit')</button>
                    </p>
                </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", () => {
        var radio = $('input[name=citizen]:checked').val();
        if (radio === '1') {
//            $('#lbl_ic').show();
            $('#div_icnew').show();
//            $('#lbl_passport').hide();
            $('#div_passport').hide();
            $('#gender').hide();
            $('#age').hide();
            $('#address').hide();
            $('#ctry_cd').hide();
            $('#state').hide();
            $('#district_cd').hide();
            $('#postcode').hide();
        } else {
//            $('#lbl_ic').hide();
            $('#div_icnew').hide();
//            $('#lbl_passport').show();
            $('#div_passport').show();
            $('#gender').show();
            $('#age').show();
            $('#address').show();
            $('#ctry_cd').show();
            $('#state').show();
            $('#district_cd').show();
            $('#postcode').show();
        }
        $(document).on("change","input[name=citizen]",function(){
            check(this.value);
        });
    });
    
    function checkrepeatpassword(){
        if($('#password').val()!== $('#password-confirm').val()){
            alert("@lang('auth.register.password_check')");
            $('#password-confirm').val('');
        }
    }
    
    function reloadcaptcha() {
        document.getElementById("captcha").setAttribute('src','/captcha?'+Math.random());
    }
//    $('#captcha').click(function(){
//        alert('berjaya');
//    $('#captcha').attr('src','/captcha/default?'+Math.random());
//    document.getElementsByTagName("H1")[0].setAttribute("class", "democlass");
//    });
    function statecd(statecd) {
        $.ajax({
            type:'GET',
            url:"{{ url('getdistlist') }}" + "/" + statecd,
            dataType: "json",
            success:function(data){
                $('select[name="distrinct_cd"]').empty();
                $.each(data, function(key, value) {
                    $('select[name="distrinct_cd"]').append('<option value="'+ value +'">'+ key +'</option>');
                });
            }
        });
    }

//$('#state_cd').on('change', function (e) {
//        alert('berjaya');
//        var state_cd = $(this).val();
//        $.ajax({
//            type:'GET',
//            url:"{{ url('admin-case/getdistlist') }}" + "/" + state_cd,
//            dataType: "json",
//            success:function(data){
//                $('select[name="distrinct_cd"]').empty();
//                $.each(data, function(key, value) {
//                    $('select[name="distrinct_cd"]').append('<option value="'+ value +'">'+ key +'</option>');
//                });
//            }
//        });
//    });
    
    function check(value) {
        if (value === '1') {
            $.get( "locale/ms", function( ) {
                location.reload();
            });
        } else {
            $.get( "locale/en", function( ) {
                location.reload();
            });
        }
    }
    
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>

@endsection
