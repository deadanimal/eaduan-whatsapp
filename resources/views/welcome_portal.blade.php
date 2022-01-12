@extends('layouts.main_portal')
<?php
?>
@section('content')
    <div class="ibox floating-container">
        <div class="ibox-content" style="">
            <div class="container mt-4 mb-4 shadow-sm p-3 mb-5 bg-white rounded checkcase"
                 style="background-color: white; border: 1px solid #ccc;">
                <div class="row">
                    <div class="col-md-12">
                        @foreach($mArticles as $mArticle)
                            {!! app()->getLocale() == 'en' ? $mArticle->content_en : $mArticle->content_my !!}
                            <br>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
