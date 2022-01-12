<div class="row">
    <div class="col-md-2">
    </div>
    <div class="col-md-8">
        <div class="row">
            <!-- Code Field -->
            <div class="form-group col-lg-12{{ $errors->has('code') ? ' has-error' : '' }}">
                <div class="input-group">
                    {{ Form::label('code', 'Kod:', ['class' => 'control-label required']) }}
                    {{ Form::text('code', null, ['class' => 'form-control']) }}
                </div>
                @if ($errors->has('code'))
                    <span class="help-block"><strong>{{ $errors->first('code') }}</strong></span>
                @endif
            </div>
            <!-- Descr Field -->
            <div class="form-group col-lg-12{{ $errors->has('descr') ? ' has-error' : '' }}">
                {{ Form::label('descr', 'Penerangan:', ['class' => 'control-label required']) }}
                {{ Form::text('descr', null, ['class' => 'form-control']) }}
                @if ($errors->has('descr'))
                    <span class="help-block"><strong>{{ $errors->first('descr') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="row">
            <!-- Descr En Field -->
            <div class="form-group col-lg-12{{ $errors->has('descr_en') ? ' has-error' : '' }}">
                {{ Form::label('descr_en', 'Penerangan Inggeris:', ['class' => 'control-label required']) }}
                {{ Form::text('descr_en', null, ['class' => 'form-control']) }}
                @if ($errors->has('descr_en'))
                    <span class="help-block"><strong>{{ $errors->first('descr_en') }}</strong></span>
                @endif
            </div>
            <!-- Sort Field -->
            <div class="form-group col-lg-12{{ $errors->has('sort') ? ' has-error' : '' }}">
                <div class="input-group">
                    {{ Form::label('sort', 'Susunan:', ['class' => 'control-label required']) }}
                    {{ Form::text('sort', null, ['class' => 'form-control']) }}
                </div>
                @if ($errors->has('sort'))
                    <span class="help-block"><strong>{{ $errors->first('sort') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="row">
            <!-- Status Field -->
            <div class="form-group col-lg-12{{ $errors->has('status') ? ' has-error' : '' }}">
                <div class="input-group">
                    {{ Form::label('status', 'Status:', ['class' => 'control-label required']) }}
                    {{-- {{ Form::text('status', null, ['class' => 'form-control']) }} --}}
                    {{ Form::select('status', $data['statuses'] ?? [], null, ['class' => 'form-control', 'placeholder' => '-- SILA PILIH --']) }}
                </div>
                @if ($errors->has('status'))
                    <span class="help-block"><strong>{{ $errors->first('status') }}</strong></span>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-2">
    </div>
</div>
