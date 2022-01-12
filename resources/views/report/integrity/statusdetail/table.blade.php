<table class="table table-striped table-bordered table-hover" style="width: 100%">
    <thead>
        <tr>
            <th>Bil.</th>
            <th>No. Aduan</th>
            <th>Kategori Aduan</th>
            <th>Cara Penerimaan</th>
            <th>Tajuk Aduan</th>
            <th>Aduan</th>
            <th>Nama Pengadu</th>
            <th>Nama Diadu</th>
            <th>Nama Penyiasat</th>
            <th>Jantina</th>
            <th>Warganegara</th>
            <th>Negara</th>
            <th>Emel Pengadu</th>
            <th>Status Pengadu</th>
            <th>Status Aduan</th>
            <th>Tarikh Penerimaan</th>
            <th>Tarikh Selesai</th>
            <th>Tarikh Penutupan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['integritycomplaints'] as $key => $datum)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if(in_array($data['generate'], ['excel']))
                        {{ $datum->IN_CASEID }}
                    @else
                        <a onclick="showsummaryintegriti('{{ $datum->id }}')">
                            {{ $datum->IN_CASEID }}
                        </a>
                    @endif
                </td>
                <td>{{ $datum->cmplcat ? $datum->cmplcat->descr : '' }}</td>
                <td>{{ $datum->rcvtyp ? $datum->rcvtyp->descr : '' }}</td>
                <td>{{ $datum->IN_SUMMARY_TITLE }}</td>
                <td>{{ $datum->IN_SUMMARY }}</td>
                <td>{{ $datum->IN_NAME }}</td>
                <td>{{ $datum->IN_AGAINSTNM }}</td>
                <td>{{ $datum->invby ? $datum->invby->name : '' }}</td>
                <td>{{ $datum->sexcd ? $datum->sexcd->descr : '' }}</td>
                <td>
                    @if($datum->IN_NATCD != '')
                        @if($datum->IN_NATCD == 'mal')
                            Warganegara
                        @elseif($datum->natcd)
                            {{ $datum->natcd->descr }}
                        @endif
                    @endif
                </td>
                <td>{{ $datum->countrycd ? $datum->countrycd->descr : '' }}</td>
                <td>{{ $datum->IN_EMAIL }}</td>
                <td>{{ $datum->statuspengadu ? $datum->statuspengadu->descr : '' }}</td>
                <td>{{ $datum->invsts ? $datum->invsts->descr : '' }}</td>
                <td>{{ $datum->IN_RCVDT ? date('d-m-Y h:i A', strtotime($datum->IN_RCVDT)) : '' }}</td>
                <td>{{ $datum->IN_COMPLETEDT ? date('d-m-Y h:i A', strtotime($datum->IN_COMPLETEDT)) : '' }}</td>
                <td>{{ $datum->IN_CLOSEDT ? date('d-m-Y h:i A', strtotime($datum->IN_CLOSEDT)) : '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
