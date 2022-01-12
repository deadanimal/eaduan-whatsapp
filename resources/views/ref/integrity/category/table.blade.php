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
        @isset($data['refIntegrityCategories'])
        @foreach ($data['refIntegrityCategories'] as $key => $datum)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $datum->code ?? $datum['code'] ?? '' }}</td>
                <td>{{ $datum->descr ?? $datum['descr'] ?? '' }}</td>
                <td>{{ $datum->descr_en ?? $datum['descr_en'] ?? '' }}</td>
                <td>{{ $datum->sort ?? $datum['sort'] ?? '' }}</td>
                <td>{{ $datum->statusDescription ?? $datum['statusDescription'] ?? '' }}</td>
                <td>
                    <a href="{{ route('ref.integrity.categories.edit', $datum->id ?? $datum['sort'] ?? '') }}" class='btn btn-primary btn-sm'>
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
        @endforeach
        @endisset
    </tbody>
</table>
{{ isset($data['refIntegrityCategories']) ? $data['refIntegrityCategories']->links() : '' }}