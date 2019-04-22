@extends('layouts.app')

@section('title')- @lang('fields.product_title_register') @endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card m-b-30">
                {{ Form::open(['url' => 'product', 'method' => 'POST', 'id' => 'registerForm', 'enctype' => 'multipart/form-data']) }}
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {{ Form::label('name', __("fields.product_name").'*') }}
                                        {{ Form::text('name', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('value', __("fields.product_value").'*') }}
                                        {{ Form::text('value', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('price', __("fields.product_price").'*') }}
                                        {{ Form::text('price', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('ncm', __("fields.product_ncm").'*') }}
                                        <div class="input-group">
                                            {{ Form::text('ncm_str', null, ['id' => 'ncm_str', 'class'=>'form-control', 'style'=>'margin-right: 3px', 'readonly' => true]) }}
                                            {{ Form::hidden('ncm', null, ['id'=>'ncm']) }}
                                            <button type="button" onclick="allNcm()"
                                                    class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        {{ Form::label('cfop', __("fields.product_cfop").'*') }}
                                        <div class="input-group">
                                            {{ Form::text('cfop_str', null, ['id' => 'cfop_str', 'class'=>'form-control', 'style'=>'margin-right: 3px', 'readonly' => true]) }}
                                            {{ Form::hidden('cfop', null, ['id'=>'cfop']) }}
                                            <button type="button" onclick="allCfop()"
                                                    class="btn btn-success btn-sm"><i class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('aliquota', __("fields.product_aliquota").'*') }}
                                        {{ Form::text('aliquota', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('ipi', __("fields.product_ipi").'*') }}
                                        {{ Form::text('ipi', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('unit', __("fields.product_unit").'*') }}
                                        {{ Form::text('unit', null, ['class'=>'form-control']) }}
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        {{ Form::label('photo', __("fields.product_photo").'') }}
                                        {{ Form::file('photo', ['class'=>'form-control']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <br/>
                            <a href="#" data-toggle="modal" data-target="#modalPhoto">
                                <div class="img-responsive img-thumbnail" style="width: 100%; height: 215px">
                                    <img id="visualizar_img" src="{{ asset('sem_imagem.jpg') }}"
                                         style="height: 100%; width: 100%" class="img-responsive img-thumbnail"/>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        @lang("fields.btn_save")
                    </button>
                    <a href="{{ url('product') }}" class="btn btn-secondary waves-effect waves-light pull-right">
                        @lang("fields.btn_back")
                    </a>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNcm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang("fields.ncm_title_index")</h4>
                </div>
                <div class="modal-body">
                    <h4 class="mt-0 header-title">
                        <button type="button" onclick="newNcm()"
                                class="btn btn-sm btn-success">@lang('fields.btn_register_new')</button>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="button" class="btn btn-warning btn-sm"><i class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                    </h4>
                    <div class="table-responsive" id="ncmTABLE">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNcmUpdate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            {{ Form::open(['url' => '#', 'id' => 'updateForm']) }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleUpdateNcm"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::hidden('ncm_id', null, ['id' => 'ncm_id']) }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('ncm_code', __("fields.ncm_code")."*") }}
                                {{ Form::text('ncm_code', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-7">
                            <div class="form-group">
                                {{ Form::label('ncm_description', __("fields.ncm_description")) }}
                                {{ Form::text('ncm_description', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                {{ Form::label('ncm_ipi', __("fields.ncm_ipi")) }}
                                {{ Form::text('ncm_ipi', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
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

    <div class="modal fade" id="modalCfop" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalLabel">@lang("fields.cfop_title_index")</h4>
                </div>
                <div class="modal-body">
                    <h4 class="mt-0 header-title">
                        <button type="button" onclick="newCfop()"
                                class="btn btn-sm btn-success">@lang('fields.btn_register_new')</button>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                {{ Form::text('search_text', null, ['id' => 'search_text', 'class' => 'form-control', 'placeholder' => __("fields.placeholder_search"), 'style' => 'margin-right: 3px']) }}
                                <button id="btnEraser" type="button" class="btn btn-warning btn-sm"><i class="fa fa-eraser"></i></button>
                            </div>
                        </div>
                    </h4>
                    <div class="table-responsive" id="cfopTABLE">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCfopUpdate" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            {{ Form::open(['url' => '#', 'id' => 'updateForm']) }}
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="titleUpdateCfop"></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ Form::hidden('cfop_id', null, ['id' => 'cfop_id']) }}
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('cfop_code', __("fields.cfop_code")."*") }}
                                {{ Form::text('cfop_code', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{ Form::label('cfop_description', __("fields.cfop_description")) }}
                                {{ Form::text('cfop_description', null, ['class' => 'form-control']) }}
                            </div>
                        </div>
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

    <div id="modalPhoto" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body" align="center">
                    <div class="img-responsive img-thumbnail" style="width: 75%; height: 275px">
                        <img id="visualizar_img_modal" src="{{ asset('sem_imagem.jpg') }}"
                             style="height: 100%; width: 100%" class="img-responsive img-thumbnail"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary"
                            data-dismiss="modal">@lang("fields.btn_close")</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        var pageNcm = '';
        var searchNcm = '';

        $(document).on('click', '#modalNcm .pagination a', function (e) {
            e.preventDefault();
            pageNcm = $(this).attr('href').split('page=')[1];
            searchNcm = $("#modalNcm #search_text").val();
            allNcm()
        });

        $(document).on('keyup', '#modalNcm #search_text', function (e) {
            pageNcm = '';
            searchNcm = $("#modalNcm #search_text").val();
            allNcm()
        });

        $(document).on('click', '#modalNcm #btnEraser', function (e) {
            pageNcm = '';
            searchNcm = '';
            allNcm()
        });

        function allNcm() {
            if(searchNcm == null || searchNcm.length == 0) {
                $("#modalNcm #search_text").val("")
                $("#modalNcm #btnEraser").hide();
            } else {
                $("#modalNcm #btnEraser").show();
            }
            $("#modalNcm").modal('show')

            $.ajax({
                type: "POST",
                url: "{{ url('api/ncm_all_select') }}?page=" + pageNcm,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    search: searchNcm,
                    select: 'product.ncm_table',
                    enterprise: '{{ Session::get('enterprise')->id }}'
                },
                success: function (data) {
                    if (data.count == 0 && pageNcm != '' && parseInt(pageNcm) > 1) {
                        pageNcm = parseInt(pageNcm) - 1;
                        allNcm();
                    } else {
                        $("#ncmTABLE").html(data.html);
                    }
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function openNcm(ncm) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/ncm_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: ncm, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#modalNcm").modal('hide')
                    $('#ncm_str').val(data.data.code + ((data.data.description != null && data.data.description.length > 0) ? " - " + data.data.description : ""))
                    $('#ncm').val(data.data.id)
                    $('#ipi').val(data.data.ipi != null ? data.data.ipi : 0)
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function newNcm() {
            $("#ncm_id").val("");
            $("#ncm_code").val("");
            $("#ncm_description").val("");
            $("#ncm_ipi").val("");
            $("#titleUpdateNcm").html("{{ __("fields.ncm_title_register") }}");
            $("#modalNcmUpdate").modal('show');
        }

        $("#modalNcmUpdate #updateForm").validate({
            rules: {
                ncm_code: {
                    required: true,
                    maxlength: 25,
                    uniqueNcmCode: true
                },
                ncm_description: {
                    maxlength: 255
                },
                ncm_ipi: {
                    validateDigits: true
                }
            },
            messages: {
                ncm_code: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                ncm_description: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var id = $("#ncm_id").val();
                var code = $("#ncm_code").val();
                var description = $("#ncm_description").val();
                var ipi = $("#ncm_ipi").val();
                if (id == null || (id != null && id.length == 0)) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/ncm_store') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            code: code,
                            description: description,
                            ipi: ipi,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openNcm(data.data.id)
                            $("#modalNcmUpdate").modal('hide');
                            $("#modalNcm").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/ncm_update') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            id: id,
                            code: code,
                            description: description,
                            ipi: ipi,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openNcm(data.data.id)
                            $("#modalNcmUpdate").modal('hide');
                            $("#modalNcm").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                }
            }
        });

        jQuery.validator.addMethod("uniqueNcmCode", function (value, element, config) {
            var status = false;
            $.ajax({
                type: "POST",
                url: "{{ url('api/ncm_open_code') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    code: value,
                    enterprise: "{{ Session::has('enterprise') ? Session::get('enterprise')->id : "" }}"
                },
                success: function (data) {
                    var id = $("#ncm_id").val();
                    if (id == null || (id != null && id.length == 0)) {
                        if (data.data == null) {
                            status = true;
                        }
                    } else {
                        if (data.data == null || data.data.id == id) {
                            status = true;
                        }
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.unique") }}");

        function openTrashNcm(ncm) {
            swal({
                title: "{{ __("messages.destroy") }}",
                type: "error",
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.delete_yes") }}",
                cancelButtonText: "{{ __("fields.delete_not") }}"
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: '{{ url('api/ncm_destroy') }}',
                    async: false,
                    data: {id: ncm, enterprise: '{{ Session::get('enterprise')->id }}' },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            if (ncm == $("#ncm").val()) {
                                $("#ncm_str").val("")
                                $("#ncm").val("")
                            }
                            allNcm();
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }

        function openEditNcm(ncm) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/ncm_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: ncm, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#ncm_id").val(data.data.id);
                    $("#ncm_code").val(data.data.code);
                    $("#ncm_description").val(data.data.description);
                    $('#ncm_ipi').val(data.data.ipi != null ? data.data.ipi : 0)
                    $("#titleUpdateNcm").html("{{ __("fields.ncm_title_edit") }} #" + data.data.id);
                    $("#modalNcmUpdate").modal('show');
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        var pageCfop = '';
        var searchCfop = '';

        $(document).on('click', '#modalCfop .pagination a', function (e) {
            e.preventDefault();
            pageCfop = $(this).attr('href').split('page=')[1];
            searchCfop = $("#modalCfop #search_text").val();
            allCfop();
        });

        $(document).on('keyup', '#modalCfop #search_text', function (e) {
            pageCfop = '';
            searchCfop = $("#modalCfop #search_text").val();
            allCfop();
        });

        $(document).on('click', '#modalCfop #btnEraser', function (e) {
            pageCfop = '';
            searchCfop = '';
            allCfop()
        });

        function allCfop() {
            if(searchCfop == null || searchCfop.length == 0) {
                $("#modalCfop #search_text").val("");
                $("#modalCfop #btnEraser").hide();
            } else {
                $("#modalCfop #btnEraser").show();
            }
            $("#modalCfop").modal('show')

            $.ajax({
                type: "POST",
                url: "{{ url('api/cfop_all_select') }}?page=" + pageCfop,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    search: searchCfop,
                    select: 'product.cfop_table',
                    enterprise: '{{ Session::get('enterprise')->id }}'
                },
                success: function (data) {
                    if (data.count == 0 && pageCfop != '' && parseInt(pageCfop) > 1) {
                        pageCfop = parseInt(pageCfop) - 1;
                        allCfop();
                    } else {
                        $("#modalCfop #cfopTABLE").html(data.html)
                    }
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function openCfop(cfop) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/cfop_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: cfop, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#modalCfop").modal('hide')
                    $('#cfop_str').val(data.data.code + ((data.data.description != null && data.data.description.length > 0) ? " - " + data.data.description : ""))
                    $('#cfop').val(data.data.id)
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function newCfop() {
            $("#cfop_id").val("");
            $("#cfop_code").val("");
            $("#cfop_description").val('');
            $("#titleUpdateCfop").html("{{ __("fields.cfop_title_register") }}");
            $("#modalCfopUpdate").modal('show');
        }

        $("#modalCfopUpdate #updateForm").validate({
            rules: {
                cfop_code: {
                    required: true,
                    maxlength: 25,
                    uniqueCfopCode: true
                },
                cfop_description: {
                    maxlength: 255
                }
            },
            messages: {
                cfop_code: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                cfop_description: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold',
            submitHandler: function (form) {
                event.preventDefault();
                var id = $("#cfop_id").val();
                var code = $("#cfop_code").val();
                var description = $("#cfop_description").val();

                if (id == null || (id != null && id.length == 0)) {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/cfop_store') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            code: code,
                            description: description,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openCfop(data.data.id)
                            $("#modalCfopUpdate").modal('hide');
                            $("#modalCfop").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                } else {
                    $.ajax({
                        type: "POST",
                        url: "{{ url('api/cfop_update') }}",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[register="csrf-token"]').attr('content')
                        },
                        async: false,
                        data: {
                            id: id,
                            code: code,
                            description: description,
                            enterprise: "{{ Session::get('enterprise')->id }}"
                        },
                        success: function (data) {
                            openCfop(data.data.id)
                            $("#modalCfopUpdate").modal('hide');
                            $("#modalCfop").modal('hide');
                        }, error: function (data) {
                            console.log("ERROR SERVER")
                        }
                    });
                }
            }
        });

        jQuery.validator.addMethod("uniqueCfopCode", function (value, element, config) {
            var status = false;
            $.ajax({
                type: "POST",
                url: "{{ url('api/cfop_open_code') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {
                    code: value,
                    enterprise: "{{ Session::has('enterprise') ? Session::get('enterprise')->id : "" }}"
                },
                success: function (data) {
                    var id = $("#cfop_id").val();
                    if (id == null || (id != null && id.length == 0)) {
                        if (data.data == null) {
                            status = true;
                        }
                    } else {
                        if (data.data == null || data.data.id == id) {
                            status = true;
                        }
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.unique") }}");

        function openTrashCfop(cfop) {
            swal({
                title: "{{ __("messages.destroy") }}",
                type: "error",
                showCancelButton: true,
                confirmButtonText: "{{ __("fields.delete_yes") }}",
                cancelButtonText: "{{ __("fields.delete_not") }}"
            }).then(function () {
                $.ajax({
                    type: "DELETE",
                    url: '{{ url('api/cfop_destroy') }}',
                    async: false,
                    data: {id: cfop, enterprise: "{{ Session::get('enterprise')->id }}"},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        if (data.status == "OK") {
                            if (cfop == $("#cfop").val()) {
                                $("#cfop_str").val("")
                                $("#cfop").val("")
                            }
                            allCfop();
                        }
                    }, error: function (data) {
                        alert('ERROR NO SERVER.')
                    }
                });
            });
        }

        function openEditCfop(cfop) {
            $.ajax({
                type: "POST",
                url: "{{ url('api/cfop_show/') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {id: cfop, enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    $("#cfop_id").val(data.data.id);
                    $("#cfop_code").val(data.data.code);
                    $("#cfop_description").val(data.data.description);
                    $("#titleUpdateCfop").html("{{ __("fields.cfop_title_edit") }} #" + data.data.id);
                    $("#modalCfopUpdate").modal('show');
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
        }

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#visualizar_img').attr('src', e.target.result);
                    $('#visualizar_img_modal').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#photo").change(function () {
            readURL(this);
        });

        $("#registerForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                value: {
                    required: true,
                    validateDigits: true
                },
                price: {
                    required: true,
                    validateDigits: true
                },
                ncm_str: {
                    required: true
                },
                cfop_str: {
                    required: true
                },
                aliquota: {
                    required: true,
                    validateDigits: true
                },
                ipi: {
                    required: true,
                    validateDigits: true
                },
                unit: {
                    required: true,
                    maxlength: 255
                },
                photo: {
                    validateImg: true
                }
            },
            messages: {
                name: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                value: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                price: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                ncm_str: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                cfop_str: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                aliquota: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                ipi: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                unit: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold'
        });

        jQuery.validator.addMethod("validateDigits", function (value, element, config) {
            if (value.length > 0) {
                var countPoint = 0, status = true;
                for (var l = 0; l < value.length; l++) {
                    if (!$.isNumeric(value[l]) && value[l] != "." && value[l] != ",") {
                        status = false;
                    } else if (!$.isNumeric(value[l]) && (value[l] == "." || value[l] == ",")) {
                        countPoint++;
                    }
                }
                if (status && countPoint <= 1) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }, "{{ __("validation_jquery.digits") }}");

        jQuery.validator.addMethod("validateImg", function (value, element, config) {
            if (value.length > 0) {
                var status = false, extension = "", point = false;
                for (var i = 0; i < value.length; i++) {
                    if (point) {
                        extension += value[i];
                    }
                    if (value[i] == ".") {
                        point = true;
                    }
                }
                if (extension == "png" || extension == "jpeg" || extension == "jpg" || extension == "gif" || extension == "PNG" || extension == "JPEG" || extension == "JPG" || extension == "GIF") {
                    status = true;
                }
                return status;
            } else {
                return true;
            }
        }, "{{ __("validation_jquery.valid_img") }}");
    </script>
@endsection