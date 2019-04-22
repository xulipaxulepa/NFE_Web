<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>@lang("fields.product_name")</th>
        <th width="100px">@lang("fields.product_unit")</th>
        <th width="100px">@lang("fields.product_price_brev")</th>
        <th width="50px"></th>
        <th width="100px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($products) > 0)
        @foreach($products as $key => $value)
            <tr>
                <td>{{ $value->name }}</td>
                <td>{{ $value->unit }}</td>
                <td>{{ __("fields.price_coin") . " " . $value->price }}</td>
                <td align="center">
                    <button class="btn btn-sm btn-success" type="button" onclick="openProduct('{{ $value->id }}')">
                        <i class="fa fa-check"></i></button>
                </td>
                <td>
                    <button type="button" class="btn btn-sm btn-info" onclick="openEditProduct('{{ $value->id }}')"><i class="fa fa-edit"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="openTrashProduct('{{ $value->id }}')"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        @endforeach
    @else
        <tr>
            <th colspan="5" class="text-center">@lang("fields.empty_list")</th>
        </tr>
    @endif
    </tbody>
</table>
{{ $products->links() }}