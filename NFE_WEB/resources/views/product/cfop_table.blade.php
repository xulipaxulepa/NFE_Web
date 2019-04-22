<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="200px">@lang("fields.cfop_code")</th>
        <th>@lang("fields.cfop_description")</th>
        <th width="50px"></th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($cfops as $key => $value)
        <tr>
            <td>{{ $value->code }}</td>
            <td>{{ $value->description }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-success" onclick="openCfop('{{ $value->id }}')"><i
                            class="fa fa-check"></i></button>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-info" onclick="openEditCfop('{{ $value->id }}')"><i
                            class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-sm btn-danger" onclick="openTrashCfop('{{ $value->id }}')"><i
                            class="fa fa-trash"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $cfops->links() }}