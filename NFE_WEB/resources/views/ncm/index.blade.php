@extends('layouts.app')

@section('title')- @lang("fields.ncm_title_index") @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        <a href="{{ url('ncm/create') }}"
                           class="btn btn-sm btn-success">@lang('fields.btn_register_new')</a>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="button" class="btn btn-warning btn-sm"><i
                                            class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </h4>
                    <div class="table-responsive" id="tblDATES">
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        allNcms();
        $("#btnEraser").hide();

        var page = '';
        var search = '';

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search = $("#search_text").val();
            allNcms()
        });

        $(document).on('keyup', '#search_text', function (e) {
            page = '';
            search = $("#search_text").val();
            allNcms()
        });

        $(document).on('click', '#btnEraser', function (e) {
            page = '';
            search = "";
            allNcms();
        });

        function allNcms() {
            if (search == null || search.length == 0) {
                $("#search_text").val("");
                $("#btnEraser").hide();
            } else {
                $("#btnEraser").show();
            }

            $.ajax({
                type: "POST",
                url: "{{ url('server/ncm_all') }}?page=" + page,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {search: search},
                success: function (data) {
                    if (data.count == 0 && page != '' && parseInt(page) > 1) {
                        page = parseInt(page) - 1;
                        allNcms();
                    } else {
                        $("#tblDATES").html(data.html);
                    }
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function destroy(url) {
            swal({
                title: "{{ __("messages.destroy") }}",
                type: "error",
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.delete_yes") }}",
                cancelButtonText: "{{ __("fields.delete_not") }}"
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    async: false,
                    data: {'_method': 'DELETE'},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            swal({
                                title: "{{ __("messages.delete") }}",
                                type: "success",
                                confirmButtonText: "{{ __("fields.ok") }}"
                            }).then(function () {
                                allNcms()
                            });
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }
    </script>
@endsection