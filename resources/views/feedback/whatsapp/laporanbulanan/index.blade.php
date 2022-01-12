@extends('layouts.main')
@section('content')
<div class="row wrapper border-bottom white-bg page-heading mb-4">
    <div class="col-lg-10">
        <h2>Laporan Statistik Bulanan </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <strong>Maklumbalas Melalui Aplikasi Whatsapp</strong>
            </li>
        </ol>
    </div>
</div>
<div class="row text-center">
    <div class="col">
        <div class="ibox">
            <div class="ibox-content">
                <div class="form-group row">
                    <form action="/feedback/whatsapp/caribulanan" method="POST">
                        {{csrf_field()}}
                        <div class="col-lg-2">
                            <label class=" col-form-label">Pilih Tahun</label>
                        </div>
                        <div class="col-lg-8">
                            <select class="form-control m-b" name="tahun">
                                <option value="1">Sila pilih tahun</option>
                                <option value="2020">2020</option>
                                <option value="2021">2021</option>
                            </select>
                        </div>
                        <div class="col-lg-2">
                            <button class="btn btn-primary" type="submit">Jana</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@stop