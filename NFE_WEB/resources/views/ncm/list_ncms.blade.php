<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="100px">@lang("fields.ncm_code")</th>
        <th>@lang("fields.ncm_description")</th>
        <th width="100px">@lang("fields.ncm_ipi")</th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($ncms) > 0)
        @foreach($ncms as $key => $value)
            <tr>
                <td>{{ $value->code }}</td>
                <td>{{ $value->description }}</td>
                <td>{{ $value->ipi }}</td>
                <td align="center">
                    <a href="{{ url('ncm/'.$value->id.'/edit') }}"
                       class="btn btn-info btn-sm"><i class="fa fa-edit"></i></a>
                    <button class="btn btn-sm btn-danger" type="button"
                            onclick="destroy('{{ url("ncm/".$value->id) }}')">
                        <i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <th colspan="4" class="text-center">@lang("fields.empty_list")</th>
        </tr>
    @endif
    </tbody>
</table>
{{ $ncms->links() }}