<?php
    use App\Ref;
?>

<div id="carian-penyiasat" class="modal fade" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                <h4 class="modal-title">Carian Pegawai Penyiasat/Serbuan</h4>
            </div>
            <div class="modal-body">
                {!! Form::open(['id' => 'search-form', 'class' => 'form-horizontal']) !!}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('icnew', 'No. Kad Pengenalan', ['class' => 'col-sm-5 control-label']) }}
                            <div class="col-sm-7">
                                {{ Form::text('icnew', '', ['class' => 'form-control input-sm']) }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('name', 'Nama Pengguna', ['class' => 'col-sm-5 control-label']) }}
                            <div class="col-sm-7">
                                {{ Form::text('name', '', ['class' => 'form-control input-sm']) }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            {{ Form::label('state_cd', 'Negeri', ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::select('state_cd', Ref::GetList('17', true), null, ['class' => 'form-control input-sm onmodal', 'id' => 'state_cd']) }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('brn_cd') ? ' has-error' : '' }}">
                            {{ Form::label('brn_cd', 'Cawangan', ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::select('brn_cd', ['' => '-- SILA PILIH --'], null, ['class' => 'form-control input-sm onmodal']) }}
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('role_cd') ? ' has-error' : '' }}">
                            {{ Form::label('role_cd', 'Peranan', ['class' => 'col-sm-3 control-label']) }}
                            <div class="col-sm-9">
                                {{ Form::select('role_cd', Ref::GetList('152', true), null, ['class' => 'form-control input-sm onmodal', 'id' => 'role_cd']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group" align="center">
                        {{ Form::submit('Carian', ['class' => 'btn btn-primary btn-sm']) }}
                        {{ Form::reset('Semula', ['class' => 'btn btn-default btn-sm', 'id' => 'resetbtn']) }}
                    </div>
                </div>
                {!! Form::close() !!}
                <div class="table-responsive">
                    <table id="users-table" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%">
                        <thead>
                            <tr>
                                <th>Bil.</th>
                                <th>No. Kad Pengenalan</th>
                                <th>Nama</th>
                                <th>Negeri</th>
                                <th>Cawangan</th>
                                <th>Peranan</th>
                                <th>Tindakan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>