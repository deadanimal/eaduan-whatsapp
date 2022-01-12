@extends('layouts.main')
@section('content')

<div class="row" style="margin-bottom: 30px;">
    <div class="col-lg-4">
        <a href="/aktif">
            <button class="btn btn-default btn-block" style="height:120px; border-radius: 12px;">
                <h1>Aktif <i class="fa fa-bell" aria-hidden="true"></i></h1>
            </button>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="/tugasans">
            <button class="btn btn-success btn-block" style="height:120px; border-radius: 12px;">
                <h1>Tugasan <i class="fa fa-tasks" aria-hidden="true"></i></h1>
            </button>
        </a>
    </div>
    <div class="col-lg-4">
        <a href="/room">
            <button class="btn btn-default btn-block" style="height:120px; border-radius: 12px;">
                <h1>Semua <i class="fa fa-circle-o-notch" aria-hidden="true"></i></h1>
            </button>
        </a>
    </div>
</div>

<h1>Senarai maklumbalas</h1>

<div class="row">
    <div class="col">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Tapisan</h5>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <form action="/caritugasan" method="POST">
                        @csrf
                        <div class="col-lg-2">
                            <input type="text" placeholder="No telefon" class="form-control" name="phone">
                        </div>
                        <div class="col-lg-2">
                            <input type="text" placeholder="Nama" class="form-control" name="name">
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
                            <th>Tarikh</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($biliks as $bilik)
                        @if ($bilik['officer_name'] == Auth::user()->name)
                        <tr>
                            <td>{{$bilik['phone']}}</td>
                            <td>{{$bilik['name']}}</td>
                            <td>{{date('d-m-Y h:m:s', strtotime($bilik['updated_at']))}}</td>
                            <td>
                                <a href="/hantar/{{$bilik['id']}}">
                                    <button class="btn btn-success">Kemaskini maklumbalas</button>
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