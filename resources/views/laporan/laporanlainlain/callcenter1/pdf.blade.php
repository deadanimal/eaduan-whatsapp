<?php
    use App\Ref;
?>
<table style="width: 100%;">
    <tr><td><center><h5>LAPORAN CALL CENTER</h5></center></td></tr>
    <tr><td><center><h5>TAHUN {{ $year }}</h5></center></td></tr>
    <tr><td><center><h5>{{ $titlemonth }}</h5></center></td></tr>
    <tr><td><center><h5>NAMA: {{ $mUser->name }}</h5></center></td></tr>
</table>
<table style="width: 100%; border:1px solid; border-collapse: collapse" border="1">
    <thead>
        <tr>
            <th>Bil.</th>
            <th>No. Aduan</th>
            <th>Aduan</th>
            <th>Nama Pengadu</th>
            <th>Nama Diadu</th>
            <th>Kategori Aduan</th>
            <th>Tarikh Terima</th>
            <th>Tarikh Penugasan</th>
            <th>Tarikh Selesai</th>
            <th>Tarikh Penutupan</th>
            <th>Penyiasat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($query as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->CA_CASEID }}</td>
                <td>{{ implode(' ', array_slice(explode(' ', ucfirst($data->CA_SUMMARY)), 0, 7)).'...' }}</td>
                <td>{{ $data->CA_NAME }}</td>
                <td>{{ $data->CA_AGAINSTNM }}</td>
                <td>{{ $data->CA_CMPLCAT != '' ? Ref::GetDescr('244', $data->CA_CMPLCAT, 'ms') : '' }}</td>
                <td>{{ $data->CA_RCVDT ? date('d-m-Y h:i A', strtotime($data->CA_RCVDT)):'' }}</td>
                <td>{{ $data->CA_ASGDT ? date('d-m-Y h:i A', strtotime($data->CA_ASGDT)):'' }}</td>
                <td>{{ $data->CA_COMPLETEDT ? date('d-m-Y h:i A', strtotime($data->CA_COMPLETEDT)):'' }}</td>
                <td>{{ $data->CA_CLOSEDT ? date('d-m-Y h:i A', strtotime($data->CA_CLOSEDT)):'' }}</td>
                <td>{{ $data->CA_INVBY ? $data->InvBy->name : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<br />
<table style="width: 100%;">
    <tbody>
        <tr>
            <td style="font-size: 11px;">Tarikh Dijana : </td>
            <td style="font-size: 11px;"><?php echo date("d/m/Y h:i A") ?></td>
        </tr>
    </tbody>
</table>