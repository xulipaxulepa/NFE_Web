<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="200px">@lang("fields.cst_code")</th>
        <th>@lang("fields.cst_description")</th>
        <th width="50px"></th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($csts as $key => $value)
        <tr>
            <td>{{ $value->code }}</td>
            <td>{{ $value->description }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-success" onclick="openCst('{{ $value->id }}')"><i
                            class="fa fa-check"></i></button>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-info" onclick="openEditCst('{{ $value->id }}')"><i
                            class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-sm btn-danger" onclick="openTrashCst('{{ $value->id }}')"><i
                            class="fa fa-trash"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $csts->links() }}