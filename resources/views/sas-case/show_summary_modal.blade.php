<?php

use App\Ref;
use App\User;
use App\Branch;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
?>

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Maklumat Aduan</h4>
</div>
<div class="modal-body">
    <div class="row">
        <!--<div class="col-sm-6">-->
        <table style="width: 100%; " class="table-bordered table-stripped">
            <tr>
                <th>No. Aduan</th>
                <th> : </td>
                <th>{{$model->CA_CASEID}}</th>
                <th>Nama Cawangan</th>
                <th> : </th>
                <th>@if($model->CA_BRNCD!=''){{ Branch::GetBranchName($model->CA_BRNCD) }}@endif</th>

            </tr>
            <tr>
                <th>Tarikh Cipta</th>
                <th> : </th>
                <th>{{Carbon::parse($model->CA_CREDT)->format('d-m-Y h:i A')}}</th>
                <th>Tarikh Penerimaan</th>
                <th> : </th>
                <th>{{Carbon::parse($model->CA_RCVDT)->format('d-m-Y h:i A')}}</th>

            </tr>
        </table>
        <br />
        <table style="width: 100%; " class="table-bordered table-stripped">
            <tr style="background: #115272; color: white; "><th colspan="6">Aduan</th></tr>
            <tr>
                <td style="width: 18%; ">Cara Penerimaan</td>
                <td style="width: 1%;"> : </td>
                <td>@if($model->CA_RCVTYP!=''){{Ref::GetDescr('259',$model->CA_RCVTYP)}}@endif</td>
            </tr>
            <tr>
                <td>Penerima</td>
                <td> : </td>
                <td>@if($model->CA_RCVBY!=''){{$model->RcvBy->name}}@endif</td>
            </tr>
            <tr>
                <td>Aduan</td>
                <td> : </td>
                <td>{{$model->CA_SUMMARY}}</td>
            </tr>
        </table>
        <br />
        <table style="width: 100%; " class="table-bordered table-stripped">
            <tr style="background: #115272; color: white; "><th colspan="6">Pengadu</th></tr>
            <tr>
                <td style="width: 18%;">Nama Pengadu</td>
                <td style="width: 1%;">:</td>
                <td>@if($model->CA_NAME!=''){{$model->CA_NAME}}@endif</td>
            </tr>
            <tr>
                <td >No Kad Pengenalan</td>
                <td> : </td>
                <td>{{$model->CA_DOCNO}}</td>
            </tr>
            <tr>
                <td>Bangsa</td>
                <td> : </td>
                <td>@if($model->CA_RACECD!=''){{Ref::GetDescr('580',$model->CA_RACECD)}}@endif</td>
            </tr>
            <tr>
                <td>Warganegara</td>
                <td> : </td>
                <td>@if($model->CA_NATCD!=''){{Ref::GetDescr('947',$model->CA_NATCD)}}@endif</td>
            </tr>
            <tr>
                <td>Jantina</td>
                <td> : </td>
                <td>@if($model->CA_SEXCD!='')
                    {{Ref::GetDescr('202',$model->CA_SEXCD)}}@endif</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td> : </td>
                <td>@if($model->CA_ADDR!=''){{$model->CA_ADDR}}@endif</td>
            </tr>
            <tr>
                <td>Poskod</td>
                <td> : </td>
                <td>{{$model->CA_POSCD}}</td>
            </tr>
            <tr>
                <td>Daerah</td>
                <td> : </td>
                <td>@if($model->CA_DISTCD!=''){{Ref::GetDescr('18',$model->CA_DISTCD)}}
                    @endif</td>
            </tr>
            <tr>
                <td>Negeri</td>
                <td> : </td>
                <td>@if($model->CA_STATECD!=''){{Ref::GetDescr('17',$model->CA_STATECD)}}@endif</td>
            </tr>
            <tr>
                <td>No.Tel</td>
                <td> : </td>
                <td>{{$model->CA_TELNO}}</td>
            </tr>
            <tr>
                <td>No.Faks</td>
                <td> : </td>
                <td>{{$model->CA_FAXNO}}</td>
            </tr>
            <tr>
                <td>No.Telefon Bimbit</td>
                <td> : </td>
                <td>{{$model->CA_MOBILENO}}</td>
            </tr>
            <tr>
                <td>Emel</td>
                <td> : </td>
                <td>{{$model->CA_EMAIL}}</td>
            </tr>
        </table>
        <br />
        <table style="width: 100%; " class="table-bordered table-stripped">
            <tr style="background: #115272; color: white; "><th colspan="6">Maklumat Yang Diadu</th></tr>
            <tr>
                <td style="width: 18%;">Nama (Syarikat/Premis)</td>
                <td style="width: 1%;"> : </td>
                <td>{{$model->CA_AGAINSTNM}}</td>
            </tr>
            <tr>
                <td >Alamat</td>
                <td> : </td>
                <td>{{$model->CA_AGAINSTADD}}</td>
            </tr>
            <tr>
                <td>Poskod</td>
                <td> : </td>
                <td>{{$model->CA_AGAINST_POSTCD}}</td>
            </tr>
            <tr>
                <td>Daerah</td>
                <td> : </td>
                <td>@if($model->CA_AGAINST_DISTCD!=''){{Ref::GetDescr('18',$model->CA_AGAINST_DISTCD)}}@endif</td>
            </tr>
            <tr>
                <td>Negeri</td>
                <td> : </td>
                <td>@if($model->CA_AGAINST_STATECD!=''){{Ref::GetDescr('17',$model->CA_AGAINST_STATECD)}}@endif</td>
            </tr>
            <tr>
                <td>No.Tel</td>
                <td> : </td>
                <td>{{$model->CA_AGAINST_TELNO}}</td>
            </tr>
            <tr>
                <td>No.Faks</td>
                <td> : </td>
                <td>{{$model->CA_AGAINST_FAXNO}}</td>
            </tr>
            <tr>
                <td>No.Telefon Bimbit</td>
                <td> : </td>
                <td>{{$model->CA_AGAINST_MOBILENO}}</td>
            </tr>
            <tr>
                <td>Emel</td>
                <td> : </td>
                <td>{{$model->CA_AGAINST_EMAIL}}</td>
            </tr>
            <tr>
                <td>Bahan Bukti</td>
                <td> : </td>

                <td>
                    <?php $t = 1; ?>
                    @foreach ($img as $pic)
                    @if($pic->CC_IMG_NAME!='')
                    {!! '<a href='.Storage::disk('bahanpath')->url($pic->CC_PATH.$pic->CC_IMG).' target="_blank">'.$t++.') '.$pic->CC_IMG_NAME.'</a><br />' !!}
                  @endif
                    @endforeach
                </td>
            </tr>
        </table>
        <br />
        <table style="width: 100%; " class="table-bordered table-stripped">
            <tr style="background: #115272; color: white; "><th colspan="6">Penugasan</th></tr>
            <tr>
                <td style="width: 18%;"> Penugasan Aduan Oleh</td>
                <td style="width: 1%;">:</td>
                <td>@if($model->CA_ASGBY!=''){{$model->namaPemberiTugas->name}}@endif</td>
                <td>Tarikh Penugasan</td>
                <td> : </td>
                <td>{{Carbon::parse($model->CA_ASGDT)->format('d-m-Y h:i A')}}</td>
            </tr>
            <tr>
                 <td>Penyiasat</td>
                <td> : </td>
                <td>@if($model->CA_INVBY!=''){{$model->invby->name}}@endif</td>
                <td>Tarikh Selesai </td>
                <td> : </td>
                <td>{{Carbon::parse($model->CA_COMPLETEDT)->format('d-m-Y h:i A')}}</td>
            </tr>
        </table>
        <br />
        <table style="width: 100%; " class="table-bordered table-stripped">
            <tr style="background: #115272; color: white; "><th colspan="6">Siasatan</th></tr>
            <tr>
                <td style="width: 18%;">Status Aduan</td>
                <td style="width: 1%;"> : </td>
                <td>@if($model->CA_INVSTS!=''){{Ref::GetDescr('292',$model->CA_INVSTS)}}@endif</td>
            </tr>
            <tr>
                <td >Kategori</td>
                <td> : </td>
                <td>@if($model->CA_CMPLCAT!=''){{Ref::GetDescr('244',$model->CA_CMPLCAT)}}@endif</td>
            </tr>
            <tr>
                <td>Subkategori</td>
                <td> : </td>
                <td>@if($model->CA_CMPLCD!=''){{Ref::GetDescr('634',$model->CA_CMPLCD)}}@endif</td>
            </tr>
            @if($model->CA_CMPLCAT=='BPGK 19')
            <tr>
                <td>Pembekal Perkhidmatan</td>
                <td> : </td>
                <td>@if($model->CA_ONLINECMPL_PROVIDER!=''){{Ref::GetDescr('1091',$model->CA_ONLINECMPL_PROVIDER)}}@endif</td>
            </tr>
            <tr>
                <td>Laman Atas Talian/URL</td>
                <td> : </td>
                <td>{{$model->CA_ONLINECMPL_URL}}</td>
            </tr>
            <tr>
                <td>Nama Bank</td>
                <td> : </td>
                <td>@if($model->CA_ONLINECMPL_BANKCD!=''){{Ref::GetDescr('1106',$model->CA_ONLINECMPL_BANKCD)}}@endif</td>
            </tr>
            <tr>
                <td>No Akaun</td>
                <td> : </td>
                <td>{{$model->CA_ONLINECMPL_ACCNO}}</td>
            </tr>
            <tr>
                <td>No Aduan Rujukan</td>
                <td> : </td>
                <td>@if($model->CA_ONLINECMPL_ACCNO!=''){{$model->CA_ONLINECMPL_ACCNO}}@endif</td>
            </tr>
            @elseif(($model->CA_CMPLCAT == 'BPGK 01') || ($model->CA_CMPLCAT == 'BPGK 03')) 
            <tr>
                <td>Jenis Barangan</td>
                <td> : </td>
                <td>@if($model->CA_CMPLKEYWORD!=''){{Ref::GetDescr('1051',$model->CA_CMPLKEYWORD)}}@endif</td>
            </tr>
            @elseif($model->CA_CMPLCAT=='BPGK 08')
            <tr>
                <td>Penuntut/Penentang</td>
                <td> : </td>
                <td>{{$model->CA_TTPMTYP}}</td>
            </tr>
            <tr>
                <td>No TTPM</td>
                <td> : </td>
                <td>{{$model->CA_TTPMNO}}</td>
            </tr>
            @endif
            <tr>
                <td>Jumlah Kerugian (RM)</td>
                <td> : </td>
                <td>{{$model->CA_ONLINECMPL_AMOUNT}}</td>
            </tr>
            <tr>
                <td>Jenis Premis</td>
                <td> : </td>
                <td>@if($model->CA_AGAINST_PREMISE!=''){{ Ref::GetDescr('221',$model->CA_AGAINST_PREMISE)}}@endif</td>
            </tr>
            <tr>
                <td>Nama Premis</td>
                <td> : </td>
                <td>{{ $model->CA_AGAINSTNM}}</td>
            </tr>
        </table>
        <br/>
        <table style="width: 100%; " class="table-bordered table-stripped">
            <tr style="background: #115272; color: white; "><th colspan="6">Hasil Siasatan</th></tr>
            <tr>
                <td style="width: 18%;">Hasil Siasatan</td>
                <td style="width: 1%;"> : </td>
                <td>{{ $model->CA_RESULT }}</td>
            </tr>
        </table>
        <br />
        <table style="width: 100%; " class="table-bordered table-stripped">
            <tr style="background: #115272; color: white; "><th colspan="8">Sorotan Transaksi</th></tr>
            <tr>
                <th>Bil.</th>
                <th>Status</th>
                <th>Daripada</th>
                <th>Kepada</th>
                <th>Saranan</th>
                <th>Tarikh Transaksi</th>
                <th>Surat Pengadu</th>
                <th>Surat Pegawai</th>
            </tr>

            <tbody>
                <?php $i = 1; ?>
                @foreach ($trnsksi as $sorotan)
                <tr>
                    <td> {{ $i++ }} </td>
                    <td>@if($sorotan->CD_INVSTS!=''){{ Ref::GetDescr('292',$sorotan->CD_INVSTS)}}@endif</td>
                    <td> 
                        @if($sorotan->CD_ACTFROM != '')
                        {{$sorotan->UserDaripada->name}}
                        @endif</td>
                    <td>   @if($sorotan->CD_ACTTO != '')
                        {{$sorotan->UserKepada->name}}
                        @endif</td>
                    <td> {{$sorotan->CD_DESC}}</td>
                    <td> {{Carbon::parse($sorotan->CD_CREDT)->format('d-m-Y h:i A')}}</td>
                    <td>
                        @if($sorotan->CD_DOCATTCHID_PUBLIC != '')
                        {!! '<a href='.Storage::disk('letter')->url($sorotan->SuratPublic->file_name_sys).' target="_blank">'.$sorotan->SuratPublic->file_name.'</a>' !!}
                        @endif
                    </td>
                    <td> 
                        @if($sorotan->CD_DOCATTCHID_ADMIN != '')
                        {!! '<a href='.Storage::disk('letter')->url($sorotan->SuratAdmin->file_name_sys).' target="_blank">'.$sorotan->SuratAdmin->file_name.'</a>' !!}
                        @endif
                    </td>

                </tr>
                @endforeach
            </tbody>

        </table>
        <br />
        <a href="{{route('sas-case.printsummary', $model->CA_CASEID)}}" target="_blank" class="btn btn-success btn-sm">Cetak</a>
        <!--</div>-->
        <!--<div class="col-sm-6">-->

        <!--</div>-->
    </div>
</div>
