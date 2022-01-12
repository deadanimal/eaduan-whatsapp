<table class="table table-striped table-bordered table-hover" style="width: 100%">
    <thead>
        <tr>
            @isset($data['headings'])
            @foreach ($data['headings'] as $heading)
            <th class="text-center">{{$heading}}</th>
            @endforeach
            @endisset
        </tr>
    </thead>
    <tbody>
        @isset($data['count'])
        @foreach ($data['count'] as $key => $datum)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $datum['branchName'] ?? '' }}</td>
                <td class="text-center">
                    {{ $datum['totalconsumercase'] ?? '' }}
                </td>
                <td class="text-center">
                    {{ $datum['totalbecomecase'] ?? '' }}
                </td>
                <td class="text-center">
                    {{ $datum['totalnotbecomecase'] ?? '' }}
                </td>
            </tr>
        @endforeach
        @endisset
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-center">Jumlah</th>
            <th class="text-center">
                {{ $data['countTotal']['totalconsumercase'] ?? '' }}
            </th>
            <th class="text-center">
                {{ $data['countTotal']['totalbecomecase'] ?? '' }}
            </th>
            <th class="text-center">
                {{ $data['countTotal']['totalnotbecomecase'] ?? '' }}
            </th>
        </tr>
    </tfoot>
</table>
