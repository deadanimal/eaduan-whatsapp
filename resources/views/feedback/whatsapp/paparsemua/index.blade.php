@extends('layouts.main')
<style>
	.bgnav {
		margin-bottom: 30px;
		background:url('/assets/images/phone_4.jpg');
		background-repeat: no-repeat;
		background-size: cover;
		height: 300px;
	}
    .hide {
        display: none;
    }
</style>
@section('content')
<div class="row bgnav p-xl">
    <div class="col-lg-4">
        <a href="{{route('whatsapp.aktifke')}}">
            <button class="btn btn-default btn-block" style="height:120px; border-radius: 12px;">
                <h1>Aktif <i class="fa fa-bell" aria-hidden="true"></i></h1>
            </button>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="{{route('whatsapp.tugasansaya')}}">
            <button class="btn btn-default btn-block" style="height:120px; border-radius: 12px;">
                <h1>Tugasan <i class="fa fa-tasks" aria-hidden="true"></i></h1>
            </button>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="{{route('whatsapp.semuaa')}}">
            <button class="btn btn-success btn-block" style="height:120px; border-radius: 12px;">
                <h1>Semua <i class="fa fa-circle-o-notch" aria-hidden="true"></i></h1>
            </button>
        </a>
    </div>
</div>
<div class="row">
    <div class="col">
        <div class="ibox">

        <div class="ibox-title text-center">
            <h1>{{$room['name']}}</h1>
            <h3>{{$room['phone']}}</h3>
        </div>

        </div>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col">

        <div class="ibox chat-view">
            <div class="chat-discussion">
                @foreach($mesejs as $mesej)
                @if ($mesej['direction'] == "receive")
                <div class="chat-message left">
                    <div class="message">
                        <a class="message-author" href="#"> {{$room['name']}} </a>
                        <span class="message-date">{{date('d-m-Y h:m:s', strtotime ($mesej['created_at']))}}</span>
                        <span class="message-content"> 
                            <?php
                            echo nl2br($mesej['message_text']);
                            ?>
                        </span>
                        @if($mesej['media_url'] != null)
                        <!-- <span class="message-content">
                            <img src="{{$mesej['media_url']}}" alt="picture" style="max-width: 500px;">
                        </span> -->
                        <span class="message-content">
                            <a href="{{$mesej['media_url']}}">Buka lampiran</a>
                        </span>
                        @endif
                    </div>
                </div>
                @else
                <div class="chat-message right">
                    <div class="message">
                        <a class="message-author" href="#"> Pegawai </a>
                        <span class="message-date"> {{date('d-m-Y h:m:s', strtotime ($mesej['created_at']))}} </span>
                        <span class="message-content">
                            <?php
                            echo nl2br($mesej['message_text']);
                            ?>
                        </span>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
@stop