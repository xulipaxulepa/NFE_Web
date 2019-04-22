@extends('layouts.app_login')

@section('content')
    <h4 class="text-muted text-center font-18"><b>@lang('fields.user_title_change_password')</b></h4>
    <div class="p-3">
        {{ Form::open(['id'=>'recoveryForm', 'route'=>'password.request', 'class'=>'form-horizontal m-t-20', 'method'=>'POST']) }}
        {{ Form::hidden('token', $token) }}
        <div class="row form-group">
            <div class="col-md-12">
                {{ Form::text('email', null, ['class'=>'form-control', 'placeholder' => __('fields.user_email'), 'autofocus' => true]) }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-6">
                {{ Form::password('password', ['id' => 'password', 'class'=>'form-control', 'placeholder' => __('fields.user_password')]) }}
            </div>
            <div class="col-md-6">
                {{ Form::password('password_confirmation', ['id' => 'password_confirmation', 'class'=>'form-control', 'placeholder' => __('fields.user_confirmed_password')]) }}
            </div>
        </div>
        <div class="form-group text-center row m-t-20">
            <div class="col-12">
                <button class="btn btn-info btn-block waves-effect waves-light"
                        type="submit">@lang("fields.btn_change_password")</button>
            </div>
        </div>
        <div class="form-group text-center row m-t-20">
            <div class="col-12">
                <a class="btn btn-primary btn-block waves-effect waves-light"
                   href="{{ url("login") }}">@lang("fields.btn_area_access")</a>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection

@section('script')
    <script>
        $("#recoveryForm").validate({
            rules: {
                email: {
                    required: true,
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
                email: {
                    required: "{{ __("validation_jquery.required") }}"
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
                    if (data.data != null) {
                        status = true;
                    }
                }, error: function (data) {
                    console.log("ERROR SERVER")
                }
            });
            return status;
        }, "{{ __("validation_jquery.email_null") }}");

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
