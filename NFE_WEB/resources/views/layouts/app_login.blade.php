<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>@lang('fields.app_name')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
@if(!is_null(\App\Model\Soon::first()))
    <div class="accountbg"
         style="background-image: url('{{ asset('upload/photo_soon/'.(\App\Model\Soon::first()->photo)) }}')"></div>
@else
    <div class="accountbg"></div>
@endif
<div class="wrapper-page">
    <div class="card">
        <div class="card-body">
            <h3 class="text-center mt-0 m-b-15">
                <a href="{{ url('/') }}" class="logo logo-admin">
                    <img src="{{ asset('images/logo.png') }}" alt="logo">
                </a>
            </h3>
            @yield('content')
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/jquery_validate/jquery.validate.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/modernizr.min.js') }}"></script>
<script src="{{ asset('js/detect.js') }}"></script>
<script src="{{ asset('js/fastclick.js') }}"></script>
<script src="{{ asset('js/jquery.slimscroll.js') }}"></script>
<script src="{{ asset('js/jquery.blockUI.js') }}"></script>
<script src="{{ asset('js/waves.js') }}"></script>
<script src="{{ asset('js/jquery.nicescroll.js') }}"></script>
<script src="{{ asset('js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
@yield('script')
</body>
</html>