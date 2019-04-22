<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>@lang("fields.user_name")</th>
        <th>@lang("fields.user_email")</th>
        <th width="75px">@lang("fields.enterprise_limit_limit")</th>
        <th width="50px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($users) > 0)
        @foreach($users as $key => $value)
            <tr>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ !is_null($value->getEnterpriseLimit()) ? $value->getEnterpriseLimit()->amount : __("fields.enterprise_limit_single") }}</td>
                <td align="center">
                    <a href="#"
                       onclick="clickForm('{{ $value->id }}', '{{ $value->name }}', '{{ !is_null($value->getEnterpriseLimit()) ? $value->getEnterpriseLimit()->amount : __("fields.enterprise_limit_single") }}')"
                       class="btn btn-success btn-sm"><i class="fa fa-check"></i></a>
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
{{ $users->links() }}