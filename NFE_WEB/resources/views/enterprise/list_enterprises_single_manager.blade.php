<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>@lang("fields.enterprise_name")</th>
        <th width="160px">@lang("fields.enterprise_cnpj")</th>
        <th width="50px"></th>
        <th width="50px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($enterprises) > 0)
        @foreach($enterprises as $key => $value)
            <tr>
                <td>{{ !is_null($value->social_name) ? $value->social_name : (!is_null($value->fantasy_name) ? $value->fantasy_name : "") }}</td>
                <td>{{ $value->cnpj }}</td>
                <td align="center">
                    @if((!is_null(\App\Model\EnterpriseLimit::where('user', $value->user)->first()) ? \App\Model\EnterpriseLimit::where('user', $value->user)->first()->amount : __("fields.enterprise_limit_single")) <= $key)
                        <a href="#" class="btn btn-sm btn-dark disabled"><i class="fa fa-lock"></i></a>
                    @else
                        <a href="#" class="btn btn-sm btn-success" onclick="change('{{ $value->id }}')"><i
                                    class="fa fa-check"></i></a>
                    @endif
                </td>
                <td align="center">
                    <button class="btn btn-sm btn-danger" type="button"
                            onclick="destroy('{{ url("enterprise/list/destroy/".$value->id) }}')"><i
                                class="fa fa-trash"></i></button>
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