<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>@lang("fields.note_recipient")</th>
        <th width="175px">@lang("fields.note_date")</th>
        <th width="50px"></th>
        <th width="50px"></th>
        <th width="50px"></th>
    </tr>
    </thead>
    <tbody>
    @if(count($notes) > 0)
        @foreach($notes as $key => $value)
            <tr>
                <td>{{ $value->recipient }}</td>
                <td>{{ date("d/m/Y H:i:s", strtotime($value->date)) }}</td>
                <td align="center">
                    <a href="{{ url('note/xmls/'.$value->id) }}"
                       class="btn btn-info btn-sm">@lang("fields.note_xml")</a>
                </td>
                <td align="center">
                    <a href="{{ url('note/pdfs/'.$value->id) }}"
                       class="btn btn-info btn-sm">@lang("fields.note_pdf")</a>
                </td>
                <td align="center">
                    <button class="btn btn-sm btn-danger" type="button"
                            onclick="destroy('{{ url("note/".$value->id) }}')">
                        <i class="fa fa-trash"></i></button>
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
{{ $notes->links() }}