<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>@lang("fields.user_name")</th>
        <th>@lang("fields.user_email")</th>
        <th width="50px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($users) > 0)
        @if(count($users) > 0)
            @foreach($users as $key => $value)
                <tr>
                    <td>{{ $value->name }}</td>
                    <td>{{ $value->email }}</td>
                    <td align="center">
                        <button class="btn btn-sm btn-danger" type="button"
                                onclick="destroy('{{ url("userenterprise/".$value->id) }}')">
                            <i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @endforeach
        @endif
    @else
        <tr>
            <th colspan="3" class="text-center">@lang("fields.empty_list")</th>
        </tr>
    @endif
    </tbody>
</table>
{{ $users->links() }}
