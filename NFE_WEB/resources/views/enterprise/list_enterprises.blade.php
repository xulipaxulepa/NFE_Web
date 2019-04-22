<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>@lang("fields.enterprise_user")</th>
        <th>@lang("fields.enterprise_name")</th>
        <th width="160px">@lang("fields.enterprise_cnpj")</th>
        <th width="100px">@lang("fields.enterprise_ie")</th>
        <th width="60px">@lang("fields.enterprise_state")</th>
        <th width="60px">@lang("fields.enterprise_nfe")</th>
        <th width="100px"></th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($enterprises) > 0)
        @foreach($enterprises as $key => $value)
            <tr>
                <td>{{ $value->getUser()->name }}</td>
                <td>{{ !is_null($value->social_name) ? $value->social_name : (!is_null($value->fantasy_name) ? $value->fantasy_name : "") }}</td>
                <td>{{ $value->cnpj }}</td>
                <td>{{ $value->state_registration }}</td>
                <td>{{ $value->state }}</td>
                <td>{{ $value->getAmount() }}</td>
                <td align="center">
                    <a href="#"
                       onclick="clickForm('{{ $value->id }}', '{{ !is_null($value->social_name) ? $value->social_name : (!is_null($value->fantasy_name) ? $value->fantasy_name : "") }}', '{{ $value->getAmount() }}')"
                       class="btn btn-dark btn-sm">@lang("fields.enterprise_invoice")</a>
                </td>
                <td align="center">
                    <a href="{{ url('enterprise/'.$value->id) }}" class="btn btn-info btn-sm"><i class="fa fa-eye"></i></a>
                    <button class="btn btn-sm btn-danger" type="button"
                            onclick="destroy('{{ url("enterprise/".$value->id) }}')"><i class="fa fa-trash"></i>
                    </button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <th colspan="8" class="text-center">@lang("fields.empty_list")</th>
        </tr>
    @endif
    </tbody>
</table>
{{ $enterprises->links() }}
