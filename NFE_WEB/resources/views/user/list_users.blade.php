<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>@lang("fields.user_name")</th>
        <th>@lang("fields.user_email")</th>
        <th width="150px">@lang("fields.user_level")</th>
        <th width="50px"></th>
        <th width="50px"></th>
        <th width="50px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($users) > 0)
        @foreach($users as $key => $value)
            <tr>
                <td>{{ $value->name }}</td>
                <td>{{ $value->email }}</td>
                <td>{{ $value->rolesJumpSTR() }}</td>
                <td align="center">
                    <button onclick="change('{{ $value->status ? __("messages.disabled") : __("messages.enabled") }}', '{{ $value->id }}')"
                            class="btn {{ $value->status ? "btn-warning" : "btn-success" }} btn-sm"><i
                                class="fa {{ $value->status ? "fa-lock" : "fa-unlock" }}"></i></button>
                </td>
                <td align="center">
                    <a href="{{ url(!is_null($value->getProfile()) ? 'profile/'.$value->getProfile()->id : "#") }}"
                       class="btn {{ is_null($value->getProfile()) ? "btn-dark disabled" : "btn-primary" }} btn-sm"><i
                                class="fa fa-address-card"></i></a>
                </td>
                <td align="center">
                    <button class="btn btn-sm btn-danger" type="button"
                            onclick="destroy('{{ url("user/".$value->id) }}')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <th colspan="6" class="text-center">@lang("fields.empty_list")</th>
        </tr>
    @endif
    </tbody>
</table>
{{ $users->links() }}
