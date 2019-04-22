@extends('layouts.app')

@section('title')- @lang("fields.enterprise_title_index") @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                <div class="card-body">
                    <h4 class="mt-0 header-title">
                        <a href="{{ url('enterpriselimit') }}"
                           class="btn btn-sm btn-success">@lang('fields.enterprise_limit_title')</a>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" class="btn btn-warning btn-sm"><i class="fa fa-eraser"></i>
                                </button>
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
                <div class="modal-body">
                    <div class="form-group">
                        {{ Form::label('enterprise_name', __("fields.enterprise_note_enterprise")."*") }}
                        {{ Form::text('enterprise_name', null, ['id' => 'enterprise_name', 'class' => 'form-control', 'disabled' => true]) }}
                        {{ Form::hidden('enterprise', null, ['id' => 'enterprise']) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('amount', __("fields.enterprise_note_amount")."*") }}
                        {{ Form::text('amount', null, ['class' => 'form-control']) }}
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
        allEnterprises();
        $("#btnEraser").hide();

        var page = '';
        var search = '';

        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            page = $(this).attr('href').split('page=')[1];
            search = $("#search_text").val();
            allEnterprises()
        });

        $(document).on('keyup', '#search_text', function (e) {
            page = '';
            search = $("#search_text").val();
            allEnterprises()
        });

        $(document).on('click', '#btnEraser', function (e) {
            page = '';
            search = "";
            allEnterprises();
        });

        function allEnterprises() {
            if (search == null || search.length == 0) {
                $("#search_text").val("");
                $("#btnEraser").hide();
            } else {
                $("#btnEraser").show();
            }

            $.ajax({
                type: "POST",
                url: "{{ url('server/enterprise_all') }}?page=" + page,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {search: search},
                success: function (data) {
                    if (data.count == 0 && page != '' && parseInt(page) > 1) {
                        page = parseInt(page) - 1;
                        allEnterprises();
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
                                allEnterprises()
                            });
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }

        function clickForm(id, name, amount) {
            $("#enterprise_name").val(name);
            $("#enterprise").val(id);
            $("#amount").val(amount);

            $("#modalUpdate").modal('show')
        }

        $("#registerForm").validate({
            rules: {
                amount: {
                    required: true,
                    verifyNumeric: true
                }
            },
            messages: {
                amount: {
                    required: "{{ __("validation_jquery.required") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var enterprise = $("#enterprise").val();
                var amount = $("#amount").val();
                $.ajax({
                    type: "POST",
                    url: "{{ url('api/enterprise_store_note') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                    },
                    async: false,
                    data: {enterprise: enterprise, amount: amount},
                    success: function (data) {
                        if (data.status == "OK") {
                            swal({
                                title: "{{ __("messages.success") }}",
                                type: "success",
                                confirmButtonText: "{{ __("fields.ok") }}"
                            }).then(function () {
                                $("#modalUpdate").modal('hide')
                                allEnterprises()
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