<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="100px">@lang("fields.cfop_code")</th>
        <th>@lang("fields.cfop_description")</th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($cfops) > 0)
        @foreach($cfops as $key => $value)
            <tr>
                <td>{{ $value->code }}</td>
                <td>{{ $value->description }}</td>
                <td align="center">
                    <a href="{{ url('cfop/'.$value->id.'/edit') }}" class="btn btn-info btn-sm"><i
                                class="fa fa-edit"></i></a>
                    <button class="btn btn-sm btn-danger" type="button"
                            onclick="destroy('{{ url("cfop/".$value->id) }}')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <th colspan="3" class="text-center">@lang("fields.empty_list")</th>
        </tr>
    @endif
    </tbody>
</table>
{{ $cfops->links() }}