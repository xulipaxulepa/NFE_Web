@extends('layouts.app_login')

@section('content')
    <h4 class="text-muted text-center font-18"><b>@lang('fields.user_title_area_access')</b></h4>
    <div class="p-3">
        {{ Form::open(['id'=>'loginForm', 'route'=>'login', 'class'=>'form-horizontal m-t-20', 'method'=>'POST']) }}
        <div class="row form-group">
            <div class="col-md-12">
                {{ Form::text('email', null, ['id' => 'email', 'class'=>'form-control', 'placeholder' => (__('fields.user_email')), 'autofocus'=>true]) }}
            </div>
        </div>
        <div class="row form-group">
            <div class="col-md-12">
                {{ Form::password('password', ['id' => 'password', 'class'=>'form-control', 'placeholder' => (__('fields.user_password'))]) }}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-12">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="remember" name="remember">
                    <label class="custom-control-label font-weight-normal"
                           for="remember">@lang("fields.user_stay_connected")</label>
                </div>
            </div>
        </div>
        <div class="form-group text-center row m-t-20">
            <div class="col-12">
                <button class="btn btn-info btn-block waves-effect waves-light"
                        type="submit">@lang("fields.btn_sign")</button>
            </div>
        </div>
        <div class="form-group text-center row m-t-20">
            <div class="col-6">
                <a href="{{ url('register') }}"
                   class="btn btn-success btn-block waves-effect waves-light">@lang("fields.btn_register_enterprise")</a>
            </div>
            <div class="col-6">
                <a href="{{ route('password.request') }}"
                   class="btn btn-primary btn-block waves-effect waves-light">@lang("fields.btn_forgot_password")</a>
            </div>
        </div>
        {{ Form::close() }}
    </div>
@endsection

@section('script')
    <script>
        $("#loginForm").validate({
            rules: {
                email: {
                    required: true
                },
                password: {
                    required: true,
                    access_user: true
                }
            },
            messages: {
                email: {
                    required: "{{ __("validation_jquery.required") }}"
                },
                password: {
                    required: "{{ __("validation_jquery.required") }}"
                }
            },
            errorClass: 'text-danger bold'
        });

        jQuery.validator.addMethod("access_user", function (value, element, config) {
            var fieldEmail = $("#email").val();
            if (fieldEmail.length > 0) {
                var status = false;
                $.ajax({
                    type: "POST",
                    url: "{{ url('api/user_open_email_password') }}",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    async: false,
                    data: {email: fieldEmail, password: value},
                    success: function (data) {
                        if (data.data != null) {
                            status = true;
                        }
                    }, error: function (data) {
                        console.log("ERROR SERVER")
                    }
                });
                return status;
            } else {
                return true;
            }
        }, "{{ __("validation_jquery.date_invalid") }}");
    </script>
@endsection
