<table width="100%">
    <tbody>
        <tr>
            <td width="25%">
            </td>
            <td rowspan="2" width="75%">
                <br />
                <p>
                    <strong>BORANG KAJIAN KEPUASAN PELANGGAN TERHADAP PENGURUSAN ADUAN KPDNHEP</strong>
                </p>
            </td>
        </tr>
        <tr>
            <td width="25%">
                <p>
                    {{-- <strong>KEMENTERIAN PERDAGANGAN DALAM NEGERI DAN HAL EHWAL PENGGUNA</strong> --}}
                </p>
            </td>
        </tr>
    </tbody>
</table>
<div class="row">
    <div class="col-lg-12">
        <div class="row">
            <!-- Case Number Field -->
            <div class="form-group col-lg-12">
                {{ Form::label('case_number', 'Nombor Aduan:') }}
                <p>{{ $data['casenumber'] ?? '' }}</p>
                {{ Form::hidden('case_number', $data['casenumber'] ?? null, ['class' => 'form-control', 'readonly' => 'true']) }}
            </div>

            <!-- Name Field -->
            <div class="form-group col-lg-12">
                {{ Form::label('name', 'Nama:') }}
                <p>{{ $user['name'] ?? '' }}</p>
            </div>

            <!-- Ic Number Field -->
            <div class="form-group col-lg-12">
                {{ Form::label('ic_number', 'Nombor Kad Pengenalan:') }}
                <p>{{ $user['icnew'] ?? '' }}</p>
            </div>

            <!-- Telephone Number Field -->
            <div class="form-group col-lg-12">
                {{ Form::label('telephone_number', 'Nombor Telefon Bimbit:') }}
                <p>{{ $user['mobile_no'] ?? '' }}</p>
            </div>

            <!-- Email Field -->
            <div class="form-group col-lg-12">
                {{ Form::label('email', 'Emel:') }}
                <p>{{ $user['email'] ?? '' }}</p>
            </div>

            <!-- Answer Date Field -->
            <div class="form-group col-lg-12">
                {{ Form::label('answer_date', 'Tarikh:') }}
                <p>{{ $data['answer_date'] ?? '' }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-12">
        <div class="row">
            <!-- Answer1 Field -->
            <div class="form-group col-lg-12{{ $errors->has('answer1') ? ' has-error' : '' }}">
                {{ Form::label('answer1',
                    '1.  Apakah medium yang anda gunakan untuk menyalurkan aduan kepada kementerian ini?',
                    ['class' => 'control-label required'])
                }}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="radio radio-success">
                            <input type="radio" name="answer1" id="answer1radio1" value="1">
                            <label for="answer1radio1">
                                Portal e-Aduan
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-success">
                            <input type="radio" name="answer1" id="answer1radio2" value="2">
                            <label for="answer1radio2">
                                Emel
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-success">
                            <input type="radio" name="answer1" id="answer1radio3" value="3">
                            <label for="answer1radio3">
                                Aplikasi Ez Adu
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-success">
                            <input type="radio" name="answer1" id="answer1radio4" value="4">
                            <label for="answer1radio4">
                                Enforcement Command Centre (ECC) / Bilik Gerakan Negeri
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-success">
                            <input type="radio" name="answer1" id="answer1radio5" value="5">
                            <label for="answer1radio5">
                                WhatsApp
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-success">
                            <input type="radio" name="answer1" id="answer1radio6" value="6">
                            <label for="answer1radio6">
                                Hadir Sendiri
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-success">
                            <input type="radio" name="answer1" id="answer1radio7" value="7">
                            <label for="answer1radio7">
                                Surat
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="radio radio-success">
                            <input type="radio" name="answer1" id="answer1radio8" value="8">
                            <label for="answer1radio8">
                                Telefon
                            </label>
                        </div>
                    </div>
                </div>
                @if ($errors->has('answer1'))
                    <span class="help-block">
                        <strong>{{ $errors->first('answer1') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Scale Field -->
            <div class="form-group col-lg-12">
                <label>(Sila pilih jawapan berdasarkan skala di bawah.)</label>
                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-2">
                        <p class="text-center">
                            <span class="label">1</span><br>
                            Tidak Memuaskan
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <p class="text-center">
                            <span class="label">2</span><br>
                            Kurang Memuaskan
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <p class="text-center">
                            <span class="label">3</span><br>
                            Sederhana
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <p class="text-center">
                            <span class="label">4</span><br>
                            Memuaskan
                        </p>
                    </div>
                    <div class="col-sm-2">
                        <p class="text-center">
                            <span class="label">5</span><br>
                            Sangat Memuaskan
                        </p>
                    </div>
                    <div class="col-sm-1">
                    </div>
                </div>
            </div>

            <!-- Answer2 Field -->
            <div class="form-group col-lg-12{{ $errors->has('answer2') ? ' has-error' : '' }}">
                {{ Form::label('answer2',
                    '2.   Sejauh manakah anda berpuas hati dengan perkhidmatan pengurusan aduan yang telah diberikan?',
                    ['class' => 'control-label required'])
                }}
                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer2" id="answer2radio1" value="1">
                            <label for="answer2radio1">
                                1
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer2" id="answer2radio2" value="2">
                            <label for="answer2radio2">
                                2
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer2" id="answer2radio3" value="3">
                            <label for="answer2radio3">
                                3
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer2" id="answer2radio4" value="4">
                            <label for="answer2radio4">
                                4
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer2" id="answer2radio5" value="5">
                            <label for="answer2radio5">
                                5
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                </div>
                @if ($errors->has('answer2'))
                    <span class="help-block">
                        <strong>{{ $errors->first('answer2') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Answer3 Field -->
            <div class="form-group col-lg-12{{ $errors->has('answer3') ? ' has-error' : '' }}">
                {{ Form::label('answer3',
                    '3.   Sejauh manakah anda berpuas hati dengan maklum balas yang telah diberikan?',
                    ['class' => 'control-label required'])
                }}
                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer3" id="answer3radio1" value="1">
                            <label for="answer3radio1">
                                1
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer3" id="answer3radio2" value="2">
                            <label for="answer3radio2">
                                2
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer3" id="answer3radio3" value="3">
                            <label for="answer3radio3">
                                3
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer3" id="answer3radio4" value="4">
                            <label for="answer3radio4">
                                4
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer3" id="answer3radio5" value="5">
                            <label for="answer3radio5">
                                5
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                </div>
                @if ($errors->has('answer3'))
                    <span class="help-block">
                        <strong>{{ $errors->first('answer3') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Answer4 Field -->
            <div class="form-group col-lg-12{{ $errors->has('answer4') ? ' has-error' : '' }}">
                {{ Form::label('answer4',
                    '4.   Sejauh manakah anda berpuas hati dengan tempoh masa maklum balas yang diterima?',
                    ['class' => 'control-label required'])
                }}
                <div class="row">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer4" id="answer4radio1" value="1">
                            <label for="answer4radio1">
                                1
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer4" id="answer4radio2" value="2">
                            <label for="answer4radio2">
                                2
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer4" id="answer4radio3" value="3">
                            <label for="answer4radio3">
                                3
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer4" id="answer4radio4" value="4">
                            <label for="answer4radio4">
                                4
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-2">
                        <div class="radio radio-success">
                            <input type="radio" name="answer4" id="answer4radio5" value="5">
                            <label for="answer4radio5">
                                5
                            </label>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                </div>
                @if ($errors->has('answer4'))
                    <span class="help-block">
                        <strong>{{ $errors->first('answer4') }}</strong>
                    </span>
                @endif
            </div>

            <!-- Feedback Field -->
            <div class="form-group col-lg-12{{ $errors->has('feedback') ? ' has-error' : '' }}">
                {{ Form::label('feedback',
                    '5.  Jika anda mempunyai sebarang maklum balas / cadangan, sila nyatakan: ',
                    ['class' => 'control-label'])
                }}
                {!! Form::textarea('feedback', null, ['class' => 'form-control']) !!}
                @if ($errors->has('feedback'))
                    <span class="help-block">
                        <strong>{{ $errors->first('feedback') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
