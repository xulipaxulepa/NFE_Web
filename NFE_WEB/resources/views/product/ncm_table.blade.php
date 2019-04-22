<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th width="200px">@lang("fields.ncm_code")</th>
        <th>@lang("fields.ncm_description")</th>
        <th width="100">@lang("fields.ncm_ipi")</th>
        <th width="50px"></th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @foreach($ncms as $key => $value)
        <tr>
            <td>{{ $value->code }}</td>
            <td>{{ $value->description }}</td>
            <td>{{ !is_null($value->ipi) ? $value->ipi : number_format(0, 2) }}</td>
            <td>
                <button type="button" class="btn btn-sm btn-success" onclick="openNcm('{{ $value->id }}')"><i
                            class="fa fa-check"></i></button>
            </td>
            <td>
                <button type="button" class="btn btn-sm btn-info" onclick="openEditNcm('{{ $value->id }}')"><i class="fa fa-edit"></i></button>
                <button type="button" class="btn btn-sm btn-danger" onclick="openTrashNcm('{{ $value->id }}')"><i class="fa fa-trash"></i></button>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $ncms->links() }}