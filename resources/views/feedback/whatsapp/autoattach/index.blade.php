@extends('layouts.main')
@section('content')
<style>
    textarea {
        resize: vertical;
    }
</style>
<h2>Lampiran Aduan</h2>
<div class="tabs-container">
    <ul class="nav nav-tabs">
        <li class="">
            <a href='{{ $model->CA_INVSTS == "10" ? route("admin-case.edit", $model->id) : "" }}'>
                <span class="fa-stack">
                    <span style="font-size: 14px;" class="badge badge-danger">1</span>
                </span>
                MAKLUMAT ADUAN
            </a>
        </li>
        <li class="active">
            <a>
                <span class="fa-stack">
                    <span style="font-size: 14px;" class="badge badge-danger">2</span>
                </span>
                LAMPIRAN
            </a>
        </li>
        <li class="">
            <a href='{{ $model->CA_INVSTS == "10" ? "feedback/whatsapp/preview_aduanws/".$model->id."/".$mesej_id : "" }}'>
                <span class="fa-stack">
                    <span style="font-size: 14px;" class="badge badge-danger">3</span>
                </span>
                SEMAKAN ADUAN
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane active">
            <div class="panel-body">
                <h4>( Maksimum 5 Lampiran sahaja )</h4>
                <input type="hidden" name="mesej_id" value="{{$mesej_id}}">
                @if($countDoc < 5)
                    <div class="row">
                        <div class="col-sm-12">
                            <a onclick="ModalAttachmentCreate('{{ $model->id }}')" class="btn btn-success btn-sm"><i class="fa fa-plus"></i> Lampiran</a>
                        </div>
                    </div>
                    <br />
                @endif
                <div class="table-responsive">
                    <table id="admin-case-attachment-table" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>Nama Fail</th>
                                <th>Catatan</th>
                                <th>Tarikh Muatnaik</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mAdminCaseDoc as $key => $data)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td><a href="{{$data->CC_PATH}}">{{$data->CC_IMG_NAME}}</a></td>
                                <td>{{$data->CC_REMARKS}}</td>
                                <td>{{$data->created_at}}</td>
                                <td>
                                    <form action="/feedback/whatsapp/deleteattach/{id}/{mesej_id}" method="POST">
                                    {{csrf_field()}}
                                    <input type="hidden" name="mesej_id" value="{{$mesej_id}}">
                                    <input type="hidden" name="aduan_id" value="{{$aduan_id}}">
                                    <input type="hidden" name="aduandoc_id" value="{{$data->id}}"> 
                                    <button type="submit" class="btn btn-xs btn-danger"> <i class="fa fa-trash"></i></button>
                                    </form>
                                    <!-- <a href="/feedback/whatsapp/deleteattach/{id}/{mesej_id}" class="btn btn-xs btn-danger" data-toggle="tooltip" data-placement="right" title="Hapus">
                                        <i class="fa fa-trash"></i>
                                    </a> -->
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="form-group col-sm-12" align="center">
                        <a class="btn btn-success btn-sm" href="{{ route('admin-case.edit',$model->id) }}"><i class="fa fa-chevron-left"></i> Sebelum</a>
                        <a class="btn btn-warning btn-sm" href="{{ url('admin-case') }}">Kembali</a>
                        <a class="btn btn-success btn-sm" href="/feedback/whatsapp/preview_aduanws/{{$model->id}}/{{$mesej_id}}">Simpan & Seterusnya <i class="fa fa-chevron-right"></i></a>
                    </div>
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
    
</script>
@stop
