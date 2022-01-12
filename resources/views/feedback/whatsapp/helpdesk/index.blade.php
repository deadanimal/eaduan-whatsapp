@extends('layouts.main')
<style>
    th{
        text-overflow: ellipsis;
        overflow: hidden;  
        height: 1.2em; 
        white-space: nowrap;
    }
    td{
        text-overflow: ellipsis;
        overflow: hidden;
        height: 1.2em; 
        white-space: nowrap;
    }
</style>
@section('content')
<h1>Laporan Helpdesk</h1>

@if($jenis_user == '800')
    <button style="margin-bottom: 20px; " type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
        Tambah laporan
    </button>
@endif

<!-- @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif -->
<div class="modal inmodal" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content animated bounceInRight">
            <div class="modal-header">
                <h4 class="modal-title">Tambah laporan</h4>
            </div>
            <form name="helpdesk" action="https://murai.io/api/dokumens" method="POST" enctype="multipart/form-data" onsubmit="return validateForm(this)" required>
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="form-group">
                        <label style="padding-left:0px; text-align: left;" class="col-sm-2 col-form-label">Nama isu</label>
                        <input type="text" class="form-control" name="isu">
                    </div>
                    <div class="form-group">
                        <label style="padding-left:0px; text-align: left;" class="col-sm-2 col-form-label">Tahap</label>
                        <select class="form-control m-b" name="tahap">
                            <option value="Rendah">Rendah</option>
                            <option value="Sederhana">Sederhana</option>
                            <option value="Tinggi">Tinggi</option>
                        </select>
                    </div>
                    <div class="form-group ">
                        <label style="padding-left:0px; text-align: left;" class="col-sm-2 col-form-label">Keterangan</label>
                        <textarea class="form-control message-input" name="keterangan"></textarea>
                    </div>
                    <div class="form-group ">
                        <label style="padding-left:0px; text-align: left;" class="col-sm-2 col-form-label">Lampiran</label>
                        <input type="file" name="dokumen" class="custom-file-input" id="chooseFile">
                    </div>
					<div class="form-group">
                        <input type="hidden" class="form-control" name="jenis" value="helpdesk">
                    </div>
					<div class="form-group">
                        <input type="hidden" class="form-control" name="status" value="Baru">
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
                            <th style="max-width: 150px;">Nama isu</th>
                            <th style="max-width: 150px;">Tahap</th>
                            <th style="max-width: 240px;">Keterangan</th>
                            <th style="max-width: 200px;">Lampiran</th>
                            <th style="max-width: 150px;">Status</th>
                            <th style="max-width: 240px;">Keterangan Vendor</th>

                            <th></th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($datas as $data)
			            @if($data['jenis'] == "helpdesk")
                        <tr>
                            <td style="max-width: 150px;">{{$data['isu']}}</td>
                            <td style="max-width: 150px;">{{$data['tahap']}}</td>
                            <td style="max-width: 200px;">{{$data['keterangan']}}</td>
                            <td style="max-width: 200px;">{{$data['url']}}</td>
                            <td style="max-width: 150px;">{{$data['status']}}</td>
                            <td style="max-width: 200px;">{{$data['keterangan_vendor']}}</td>

                            <td class="text-center">
                                @if($jenis_user == '999')
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#kemaskini-{{$data['id']}}">
                                        Kemaskini
                                    </button>
                                @endif
                                
                                <div class="modal inmodal" id="kemaskini-{{$data['id']}}" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content animated bounceInRight">
                                            <div class="modal-header">
                                                <h4 class="modal-title">Kemaskini laporan</h4>
                                            </div>
                                            <form action="https://murai.io/api/dokumens/{{$data['id']}}" method="post">
                                                {{csrf_field()}}
                                                <div class="modal-body">
                                                    <div class="form-group  row">
                                                        <label style="padding-left:0px; text-align: left;" class="col-sm-2 col-form-label">Status</label>
                                                        <select class="form-control m-b" name="status">
                                                            <option value="Dalam tindakan">Dalam tindakan</option>
                                                            <option value="Selesai">Selesai</option>
                                                            <option value="Baru">Baru</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group  row">
                                                        <label style="padding-left:0px; text-align: left;" class="col-sm-4 col-form-label">Keterangan vendor</label>
                                                        <textarea class="form-control message-input" name="keterangan_vendor"></textarea>
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
                                <a href="http://murai.io/storage/{{$data['url']}}" download>
                                    <button class="btn btn-primary"><i class="fa fa-download" aria-hidden="true"></i></button>
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

<script>
    function validateForm(oForm) {
        var a = document.forms["helpdesk"]["isu"].value;
        var b = document.forms["helpdesk"]["tahap"].value;
        var c = document.forms["helpdesk"]["keterangan"].value;
        var d = document.forms["helpdesk"]["dokumen"].value;
        if (a == "") {
            alert("Ruang isu perlu diisikan");
            return false;
        }else if (b == "") {
            alert("Ruang tahap perlu diisikan");
            return false;
        }else if (c == "") {
            alert("Ruang keterangan perlu diisikan");
            return false;
        }else if (d == "") {
            alert("Sila muatnaik lampiran");
            return false;
        }

        var _validFileExtensions = [".jpg", ".jpeg", ".png", ".pdf"];
        var arrInputs = oForm.getElementsByTagName("input");
        for (var i = 0; i < arrInputs.length; i++) {
            var oInput = arrInputs[i];
            if (oInput.type == "file") {
                var sFileName = oInput.value;
                if (sFileName.length > 0) {
                    var blnValid = false;
                    for (var j = 0; j < _validFileExtensions.length; j++) {
                        var sCurExtension = _validFileExtensions[j];
                        if (sFileName.substr(sFileName.length - sCurExtension.length, sCurExtension.length).toLowerCase() == sCurExtension.toLowerCase()) {
                            blnValid = true;
                            break;
                        }
                    }
                    
                    if (!blnValid) {
                        alert(sFileName + " bukan jenis lampiran yang dibenarkan, sila muat naik jenis berikut: " + _validFileExtensions.join(", "));
                        return false;
                    }
                }
            }
        }
    }
</script>