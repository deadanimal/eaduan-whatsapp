@extends('layouts.main')
@section('content')
<h1>Simpanan Dokumen</h1>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
    Muat naik
</button>
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">Muat naik dokumen</h4>
            </div>
            <form action="https://murai.io/api/dokumens" method="POST" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label style="padding-left:0px; text-align: left;" class="col-sm-4 col-form-label">Nama dokumen</label>
                        <input type="text" class="form-control" name="nama">
                    </div>
                    <div class="form-group">
                        <label style="padding-left:0px; text-align: left;" class="col-sm-2 col-form-label">Fasa</label>
                        <select class="form-control m-b" name="fasa">
                            <option value="Fasa 1">Fasa 1</option>
                            <option value="Fasa 1">Fasa 2</option>
                            <option value="Fasa 1">Fasa 3</option>
                            <option value="Fasa 1">Fasa 4</option>
                            <option value="Fasa 1">Fasa 5</option>
                            <option value="Fasa 1">Fasa 6</option>
                            <option value="Fasa 1">Fasa 7</option>
                            <option value="Fasa 1">Fasa 8</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label style="padding-left:0px; text-align: left;" class="col-sm-2 col-form-label">Catatan</label>
                        <textarea class="form-control message-input" name="catatan"></textarea>
                    </div>
                    <div class="form-group ">
                        <label style="padding-left:0px; text-align: left;" class="col-sm-2 col-form-label">Lampiran</label>
                        <input type="file" name="dokumen" class="custom-file-input" id="chooseFile">
                    </div>
                    <div class="form-group">
                        <input type="hidden" class="form-control" name="jenis" value="dokumenfasa">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
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
                            <th>Nama dokumen</th>
                            <th>Fasa</th>
                            <th>Lampiran</th>
                            <th>Catatan</th>
                            <th>Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
			            @if($data['jenis'] == "dokumenfasa")
                        <tr>
                            <td>{{$data['nama']}}</td>
                            <td>{{$data['fasa']}}</td>
                            <td>{{$data['url']}}</td>
                            <td>{{$data['catatan']}}</td>
                            <td>
                                <a href="http://murai.io/storage/{{$data['url']}}" download>
                                    <button class="btn btn-success"><i class="fa fa-download" aria-hidden="true"></i></button>
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