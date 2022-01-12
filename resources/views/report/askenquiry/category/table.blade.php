<table class="table table-striped table-bordered table-hover" style="width: 100%">
    <thead>
        <tr>
            @isset($data['headings'])
            @foreach ($data['headings'] as $heading)
            <th style="text-align: center">{{$heading}}</th>
            @endforeach
            @endisset
        </tr>
    </thead>
    <tbody>
        @isset($data['refCategories'])
        @foreach ($data['refCategories'] as $key => $datum)
            @if($key !== 'total')
            <tr>
                <td style="text-align: center">{{ $loop->iteration }}</td>
                <td>{{ $datum ?? '' }}</td>
                @isset($data['template'])
                @foreach ($data['template'] as $keytemplate => $rowtemplate)
                <td style="text-align: center">{{ $data['count'][$key][$keytemplate] ?? '' }}</td>
                @endforeach
                @endisset
            </tr>
            @endif
        @endforeach
        @endisset
    </tbody>
    @isset($data['count']['total'])
    <tfoot>
        <tr>
            <th colspan="2" style="text-align:center">Jumlah</th>
            @isset($data['template'])
            @foreach ($data['template'] as $keytemplate => $rowtemplate)
            <th style="text-align:center">{{ $data['count']['total'][$keytemplate] ?? '' }}</th>
            @endforeach
            @endisset
        </tr>
    </tfoot>
    @endisset
</table>
