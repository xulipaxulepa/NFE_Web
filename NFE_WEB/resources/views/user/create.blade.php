@extends('layouts.app')

@section('title')- @lang('fields.user_title_register_administrator') @endsection

@section('content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card m-b-30">
                {{ Form::open(['url' => 'user', 'method' => 'POST', 'id' => 'registerForm']) }}
                <div class="card-body">
                    @include('layouts.flashMessages')
                    <div class="form-group">
                        {{ Form::label('name', __("fields.user_name").'*') }}
                        {{ Form::text('name', null, ['class'=>'form-control', 'autofocus'=>true]) }}
                    </div>
                    <div class="form-group">
                        {{ Form::label('email', __("fields.user_email").'*') }}
                        {{ Form::text('email', null, ['class'=>'form-control']) }}
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('password', __("fields.user_password").'*') }}
                                {{ Form::password('password', ['class'=>'form-control']) }}
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                {{ Form::label('password_confirmation', __("fields.user_confirmed_password").'*') }}
                                {{ Form::password('password_confirmation', ['id'=>'password_confirmation', 'class'=>'form-control']) }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary waves-effect waves-light">
                        @lang("fields.btn_save")
                    </button>
                    <a href="{{ url('user') }}" class="btn btn-secondary waves-effect waves-light pull-right">
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
        $("#registerForm").validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255
                },
                email: {
                    required: true,
                    maxlength: 255,
                    email: true,
                    uniqueEmail: true
                },
                password: {
                    required: true,
                    minlength: 6,
                    maxlength: 12
                },
                password_confirmation: {
                    required: true,
                    confirmation: true
                }
            },
            messages: {
                name: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                email: {
                    required: "{{ __("validation_jquery.required") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}",
                    email: "{{ __("validation_jquery.email") }}"
                },
                password: {
                    required: "{{ __("validation_jquery.required") }}",
                    minlength: "{{ __("validation_jquery.minlength") }}",
                    maxlength: "{{ __("validation_jquery.maxlength") }}"
                },
                password_confirmation: {
                    required: "{{ __("validation_jquery.required") }}"
                }
            },
            errorClass: 'text-danger bold'
        });

        jQuery.validator.addMethod("uniqueEmail", function (value, element, config) {
            var status = false;
            $.ajax({
                type: "POST",
                url: "{{ url('api/user_open_email') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {email: value},
                success: function (data) {
                    if (data.data == null) {
                        status = true;
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.unique") }}");

        jQuery.validator.addMethod("confirmation", function (value, element, config) {
            var password = $("#password").val();
            if (password.length == 0 || password == value) {
                return true;
            } else {
                return false;
            }
        }, "{{ __("validation_jquery.equalto") }}");
    </script>
@endsection
