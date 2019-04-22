@extends('layouts.app')

@section('title')- @lang("fields.user_title_index") @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        <a href="{{ url('enterprise') }}" class="btn btn-sm btn-secondary">@lang('fields.btn_back')</a>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="submit" class="btn btn-warning btn-sm"><i
                                            class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                    </h4>
                    <div class="table-responsive" id="tblDATES">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalUpdate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            {{ Form::open(['url' => '#', 'id' => 'registerForm']) }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang("fields.enterprise_limit_title")</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::label('user_name', __("fields.enterprise_limit_user")."*") }}
                        {{ Form::text('user_name', null, ['id' => 'user_name', 'class' => 'form-control', 'disabled' => true]) }}
                        {{ Form::hidden('user', null, ['id' => 'user']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('limit', __("fields.enterprise_limit_limit")."*") }}
                        {{ Form::text('limit', null, ['class' => 'form-control']) }}
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">@lang("fields.btn_save")</button>
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
@endsection

@section('script')
    <script>
        allLimits();
        $("#btnEraser").hide();

        var page = '';
        var search = '';

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search = $("#search_text").val();
            allLimits()
        });

        $(document).on('keyup', '#search_text', function (e) {
            page = '';
            search = $("#search_text").val();
            allLimits()
        });

        $(document).on('click', '#btnEraser', function (e) {
            page = '';
            search = "";
            allLimits();
        });

        function allLimits() {
            if (search == null || search.length == 0) {
                $("#search_text").val("");
                $("#btnEraser").hide();
            } else {
                $("#btnEraser").show();
            }

            $.ajax({
                type: "POST",
                url: "{{ url('server/enterprise_all_limits') }}?page=" + page,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {search: search},
                success: function (data) {
                    $("#tblDATES").html(data.html);
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function clickForm(id, name, limit) {
            $("#user_name").val(name);
            $("#user").val(id);
            $("#limit").val(limit);

            $("#modalUpdate").modal('show')
        }

        $("#registerForm").validate({
            rules: {
                limit: {
                    required: true,
                    verifyNumeric: true
                }
            },
            messages: {
                limit: {
                    required: "{{ __("validation_jquery.required") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var user = $("#user").val();
                var limit = $("#limit").val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('api/enterprise_store_limit') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                    },
                    async: false,
                    data: {user: user, limit: limit},
                    success: function (data) {
                        if (data.status == "OK") {
                            swal({
                                title: "{{ __("messages.success") }}",
                                type: "success",
                                confirmButtonText: "{{ __("fields.ok") }}"
                            }).then(function () {
                                $("#modalUpdate").modal('hide')
                                allLimits()
                            });
                        }
                    }, error: function (data) {
                        console.log("ERROR SERVER")
                    }
                });
            }
        });

        jQuery.validator.addMethod("verifyNumeric", function (value, element, config) {
            var status = true;
            for (var v = 0; v < value.length; v++) {
                if (!$.isNumeric(value[v])) {
                    status = false;
                }
            }
            return status;
        }, "{{ __("validation_jquery.digits") }}");
    </script>
@endsection