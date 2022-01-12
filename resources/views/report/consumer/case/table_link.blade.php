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
                    <a href="{{ ($data['urldetail'] ?? '').'&branch='.$key }}" target="_blank" onclick="changeTextColor(this)">
                        {{ $datum['totalconsumercase'] ?? '' }}
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{ ($data['urldetail'] ?? '').'&branch='.$key.'&case=1' }}" target="_blank" onclick="changeTextColor(this)">
                        {{ $datum['totalbecomecase'] ?? '' }}
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{ ($data['urldetail'] ?? '').'&branch='.$key.'&case=2' }}" target="_blank" onclick="changeTextColor(this)">
                        {{ $datum['totalnotbecomecase'] ?? '' }}
                    </a>
                </td>
            </tr>
        @endforeach
        @endisset
    </tbody>
    <tfoot>
        <tr>
            <th colspan="2" class="text-center">Jumlah</th>
            <th class="text-center">
                <a href="{{ $data['urldetail'] ?? '' }}" target="_blank" onclick="changeTextColor(this)">
                    {{ $data['countTotal']['totalconsumercase'] ?? '' }}
                </a>
            </th>
            <th class="text-center">
                <a href="{{ ($data['urldetail'] ?? '').'&case=1' }}" target="_blank" onclick="changeTextColor(this)">
                    {{ $data['countTotal']['totalbecomecase'] ?? '' }}
                </a>
            </th>
            <th class="text-center">
                <a href="{{ ($data['urldetail'] ?? '').'&case=2' }}" target="_blank" onclick="changeTextColor(this)">
                    {{ $data['countTotal']['totalnotbecomecase'] ?? '' }}
                </a>
            </th>
        </tr>
    </tfoot>
</table>
