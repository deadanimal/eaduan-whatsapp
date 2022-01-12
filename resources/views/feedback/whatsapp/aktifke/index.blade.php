@extends('layouts.main')
<style>
.bgnav {
		margin-bottom: 30px;
		background:url('/assets/images/phone_4.jpg');
		background-repeat: no-repeat;
		background-size: cover;
		height: 300px;
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
<h1>Senarai maklumbalas aktif</h1>

<div class="row">
    <div class="col">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Tapisan</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <form action="/feedback/whatsapp/cariaktif" method="POST">
                        {{csrf_field()}}
                        <div class="col-lg-2">
                            <input type="text" placeholder="No telefon" class="form-control" name="phone">
                        </div>
                        <div class="col-lg-2">
                            <input type="text" placeholder="Nama" class="form-control" name="name">
                        </div>
                        <div class="col-lg-2">
                            <input type="text" placeholder="Nama Pegawai" class="form-control" name="officer_name">
                        </div>
                        <div class="col-lg-2">
                            <button type="submit" class="btn btn-w-m btn-success">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col">
        <div class="ibox ">
            <div class="ibox-content">

                <table class="table">
                    <thead>
                        <tr>
                            <th>No telefon</th>
                            <th>Nama</th>
                            <th>Mesej terakhir</th>
                            <th>Tarikh Mula</th>
                            <th>Pegawai</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($biliks as $bilik)
                        @if($bilik['officer_name'] != "Selesai")
                        <tr>
                            <td>{{$bilik['phone']}}</td>
                            <td>{{$bilik['name']}}</td>
                            <td>{{ date('d-m-Y h:m:s', strtotime($bilik['updated_at'])) }}</td>
                            <td>{{ date('d-m-Y h:m:s', strtotime($bilik['created_at'])) }}</td>
                            <td>
                                @if($bilik['officer_name'] == "Tiada")
                                Tiada
                                @elseif ($bilik['officer_name'] == null)
                                Tiada
                                @else
                                {{$bilik['officer_name']}}
                                @endif
                            </td>
                            <td>
                                <a href="/feedback/whatsapp/hantaraktif/{{$bilik['id']}}">
                                    <button class="btn btn-success">Papar</button>
                                </a>

                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


@stop