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
            <button class="btn btn-success btn-block" style="height:120px; border-radius: 12px;">
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
            <button class="btn btn-default btn-block" style="height:120px; border-radius: 12px;">
                <h1>Semua <i class="fa fa-circle-o-notch" aria-hidden="true"></i></h1>
            </button>
        </a>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-lg-8">

        <div class="ibox chat-view">
            <div class="chat-discussion">
                @foreach($mesejs as $mesej)
                @if ($mesej['direction'] == "receive")
                <div class="chat-message left">
                    <div class="message">
                        <a class="message-author" href="#"> {{$rooms['name']}} </a>
                        <span class="message-date">{{date('d-m-Y h:i:s', strtotime ($mesej['created_at']))}}</span>
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
                        <span class="message-date"> {{date('d-m-Y h:i:s', strtotime ($mesej['created_at']))}} </span>
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

        <div class="form-group text-right">
            @if($jenis_user == '800')
                @if ($rooms['officer_name'] == "Tiada")
                <form action="/feedback/whatsapp/room/{{$rooms['id']}}/tambah_tugas" method="POST">
                {{csrf_field()}}
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                    <button type="submit" class="btn btn-primary">Tambah tugas</button>
                    
                </form>
                @elseif ($rooms['officer_name'] == null)
                <form action="/feedback/whatsapp/room/{{$rooms['id']}}/tambah_tugas" method="POST">
                {{csrf_field()}}
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                    <button type="submit" class="btn btn-primary">Tambah tugas</button> 
                </form>
                @else
                <form action="/feedback/whatsapp/room/{{$rooms['id']}}/buang_tugas" method="POST">
                    {{csrf_field()}}
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                    <button type="submit" class="btn btn-danger">Buang tugas</button>
                    
                </form>
                @endif
            @elseif($jenis_user == '120')
                @if ($rooms['officer_name'] == "Tiada")
                <form action="/feedback/whatsapp/room/{{$rooms['id']}}/tambah_tugasr" method="POST">
                    {{csrf_field()}}
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                    <button type="submit" class="btn btn-primary">Tambah tugas</button>
                    
                </form>
                @elseif ($rooms['officer_name'] == null)
                <form action="/feedback/whatsapp/room/{{$rooms['id']}}/tambah_tugas" method="POST">
                    {{csrf_field()}}
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                    <button type="submit" class="btn btn-primary">Tambah tugas</button> 
                </form>
                @else
                <form action="/feedback/whatsapp/room/{{$rooms['id']}}/buang_tugas" method="POST">
                    {{csrf_field()}}
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                    <button type="submit" class="btn btn-danger">Buang tugas</button>
                    
                </form>
                @endif
            @elseif($jenis_user == '700')
                @if ($rooms['officer_name'] == "Tiada")
                <form action="/feedback/whatsapp/room/{{$rooms['id']}}/tambah_tugas" method="POST">
                    {{csrf_field()}}
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                    <button type="submit" class="btn btn-primary">Tambah tugas</button>
                    
                </form>
                @elseif ($rooms['officer_name'] == null)
                <form action="/feedback/whatsapp/room/{{$rooms['id']}}/tambah_tugas" method="POST">
                    {{csrf_field()}}
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                    <button type="submit" class="btn btn-primary">Tambah tugas</button> 
                </form>
                @else
                    @if($rooms['officer_name'] == Auth::user()->name)
                    <form action="/feedback/whatsapp/room/{{$rooms['id']}}/buang_tugas" method="POST">
                        {{csrf_field()}}
                        <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>

                        <button type="submit" class="btn btn-danger">Buang tugas</button>
                        
                    </form>
                    @else
                    <a href="{{route('whatsapp.aktifke')}}" class="btn btn-success">Kembali</a>
                    @endif
                @endif
            @endif
        </div>

    </div>

    <div class="col-lg-4">

        <div class="ibox">

            <div class="ibox-title text-center">
                <h1>{{$rooms['name']}}</h1>
                <h3>{{$rooms['phone']}}</h3>
            </div>

        </div>

    </div>
</div>
@stop