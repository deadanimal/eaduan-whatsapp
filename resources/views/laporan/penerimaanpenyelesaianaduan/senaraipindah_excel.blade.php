<?php
use App\Ref;
use App\Laporan\ReportYear;
use App\Laporan\TerimaSelesaiAduan;
?>

<?php
$filename = 'Raw-Data.xls';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=" . $filename);
$fp = fopen('php://output', 'w');
?>
<style>
    th, td {
        text-align: center;
        font-size: 12px;
    }
    </style>
    
    <table style="width: 100%; font-size: 16px; text-align: center">
        <tr><td><center><h3>LAPORAN PINDAH ADUAN MENGIKUT NEGERI BAGI TAHUN {{ $CA_RCVDT_YEAR }}</h3></center></td></tr>
        <tr><td><center><h3>  DARI <?php echo $CA_RCVDT_MONTH_FROM != '' ? Ref::GetDescr('206', $CA_RCVDT_MONTH_FROM) : '' ?> HINGGA 
                                <?php echo $CA_RCVDT_MONTH_TO != '' ? Ref::GetDescr('206', $CA_RCVDT_MONTH_TO) : '' ?></h3></center></td></tr>
        <tr><td><center><h3><?php echo $CA_DEPTCD != '' ?  Ref::GetDescr('315',$CA_DEPTCD) : 'Semua Bahagian'?></h3></center></td></tr>
        
    </table>
        <table id="senaraitable" class="table table-striped table-bordered table-hover dataTables-example" style="width: 100%; font-size: 10px;border:1px solid; border-collapse: collapse" border="1">
            <thead>
                <tr>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Bil.</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">No. Aduan</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Keterangan Aduan</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Nama Pengadu</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Nama Diadu</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Negeri</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Kategori</th>
                    <th width="1%" style="border: 1px solid #000; background: #f3f3f3;">Tarikh Penerimaan</th>
                    <!--<th width="1%">Penyiasat</th>-->
                </tr>
            </thead>
            <tbody>
                @foreach($lists as $senaraiaduan)
                <tr>
                    <td width="3px">{{ $i ++ }}</td>
                    <!--<td width="1%">{{-- $senaraiaduan->CA_CASEID --}}</td>-->
                    <td width="1%">
                            <a onclick="ShowSummary('{{ $senaraiaduan->CA_CASEID }}')">{!! $senaraiaduan->CA_CASEID !!}</a>
                        </td>
                        <td width="1%">
                            {{  $senaraiaduan->CA_SUMMARY }}
                            {{-- substr($senaraiaduan->CA_SUMMARY, 0, 50).'...' --}}
                        </td>
                        <td width="1%">{{ $senaraiaduan->CA_NAME }} </td>
                        <td width="1%">{{ $senaraiaduan->CA_AGAINSTNM }} </td>
                        <td width="1%">
                            {{ $senaraiaduan->BR_STATECD != '' ? Ref::GetDescr('17', $senaraiaduan->BR_STATECD, 'ms') : '' }}
                        </td>
                        <td width="1%">
                            {{ $senaraiaduan->CA_CMPLCAT != '' ? Ref::GetDescr('244', $senaraiaduan->CA_CMPLCAT, 'ms') : '' }}
                        </td>
                        <td width="1%">
                            {{ $senaraiaduan->CA_RCVDT != '' ? date('d-m-Y h:i A', strtotime($senaraiaduan->CA_RCVDT)) : '' }}
                        </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    
        <?php 
exit;
fclose($fp);
?>

