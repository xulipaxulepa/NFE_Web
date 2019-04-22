@extends('layouts.app')

@section('title')- @lang('fields.cst_title_edit') #{{ $cst->id }} @endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card m-b-30">
                {{ Form::model($cst, ['route' => ['cst.update', $cst], 'method' => 'PUT', 'enctype' => 'multipart/form-data', 'id' => 'editForm']) }}
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                {{ Form::label('code', __("fields.cst_code").'*') }}
                                {{ Form::text('code', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                {{ Form::label('description', __("fields.cst_description")) }}
                                {{ Form::text('description', null, ['class'=>'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        @lang("fields.btn_save")
                    </button>
                    <a href="{{ url('cst') }}" class="btn btn-secondary waves-effect waves-light pull-right">
                        @lang("fields.btn_back")
                    </a>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $("#editForm").validate({
            rules: {
                code: {
                    required: true,
                    maxlength: 25,
                    uniqueCode: true
                },
                description: {
                    maxlength: 255
                }
            },
            messages: {
                code: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                description: {
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                }
            },
            errorClass: 'text-danger bold'
        });
        jQuery.validator.addMethod("uniqueCode", function (value, element, config) {
            var status = false;
            $.ajax({
                type: "POST",
                url: "{{ url('api/cst_open_code') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {code: value, enterprise: "{{ Session::has('enterprise') ? Session::get('enterprise')->id : "" }}"},
                success: function (data) {
                    if (data.data == null || data.data.id == "{{ $cst->id }}") {
                        status = true;
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.unique") }}");
    </script>
@endsection