<table class="table table-striped table-bordered table-hover" style="width: 100%">
    <thead>
        <tr>
            @isset($data['headings'])
                @foreach ($data['headings'] as $heading)
                    <th class="text-center">{{ $heading }}</th>
                @endforeach
            @endisset
        </tr>
    </thead>
    @isset($data['count'])
        <tbody>
            @foreach ($data['count'] as $key => $value)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $value['provider'] ?? '' }}</td>
                    <td class="text-center">
                        {{ $value['total'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['belum agih'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['dalam siasatan'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['maklumat tak lengkap'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['selesai'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['tutup'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['agensi lain'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['tribunal'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['pertanyaan'] ?? '' }}
                    </td>
                    <td class="text-center">
                        {{ $value['luar bidang'] ?? '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    @endisset
    @isset($data['counttotal'])
        <tfoot>
            <tr>
                <th colspan="2" class="text-center">Jumlah</th>
                <th class="text-center">
                    {{ $data['counttotal']['total'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['belum agih'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['dalam siasatan'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['maklumat tak lengkap'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['selesai'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['tutup'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['agensi lain'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['tribunal'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['pertanyaan'] ?? '' }}
                </th>
                <th class="text-center">
                    {{ $data['counttotal']['luar bidang'] ?? '' }}
                </th>
            </tr>
        </tfoot>
    @endisset
</table>
