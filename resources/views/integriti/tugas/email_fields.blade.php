<div class="row">
    <!-- From Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('from', 'Daripada:') }}
        <p class="form-control-static">{{ $user->email ?? '' }}</p>
    </div>

    <!-- To Field -->
    <div class="form-group col-sm-12{{ $errors->has('to') ? ' has-error' : '' }}">
        {{ Form::label('to', 'Kepada:', ['class' => 'control-label required']) }}
        {{ Form::text('to', null, ['class' => 'form-control']) }}
        @if ($errors->has('to'))
            <span class="help-block">
                <strong>{{ $errors->first('to') }}</strong>
            </span>
        @endif
        @if (isset($data['envProduction']) && $data['envProduction'])
        <span class="help-block m-b-none">
            <strong>
                (E-mel juga akan dihantar kepada e-mel aduan pengguna : e-aduan@kpdnhep.gov.my).
            </strong>
        </span>
        @endif
    </div>

    <!-- Cc Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('cc', 'Cc:', ['class' => 'control-label']) }}
        {{ Form::text('cc', null, ['class' => 'form-control']) }}
    </div>

    <!-- Bcc Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('bcc', 'Bcc:', ['class' => 'control-label']) }}
        {{ Form::text('bcc', null, ['class' => 'form-control']) }}
    </div>

    <!-- Title Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('title', 'Tajuk:', ['class' => 'control-label']) }}
        {{ Form::text('title', null, ['class' => 'form-control']) }}
    </div>

    <!-- Message Field -->
    <div class="form-group col-sm-12">
        {{ Form::label('message', 'Keterangan:', ['class' => 'control-label']) }}
        {{ Form::textarea('message', null, ['class' => 'form-control']) }}
    </div>
</div>
