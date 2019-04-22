@extends('layouts.app_login')

@section('content')
    <h4 class="text-muted text-center font-18"><b>@lang('fields.user_title_reset_password')</b></h4>
    <div class="p-3">
        @if (session('status'))
            <div class="alert alert-success alert-dismissible text-center" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <b>{{ session('status') }}</b>
            </div>
        @endif
        {{ Form::open(['id'=>'recoveryForm', 'route'=>'password.email', 'class'=>'form-horizontal m-t-20', 'method'=>'POST']) }}
        <div class="row form-group">
            <div class="col-md-12">
                {{ Form::text('email', null, ['class'=>'form-control', 'placeholder' => __('fields.user_email'), 'autofocus' => true]) }}
            </div>
        </div>
        <div class="form-group text-center row m-t-20">
            <div class="col-12">
                <button class="btn btn-info btn-block waves-effect waves-light"
                        type="submit">@lang("fields.btn_send_password")</button>
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
                }
            },
            messages: {
                email: {
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
    </script>
@endsection