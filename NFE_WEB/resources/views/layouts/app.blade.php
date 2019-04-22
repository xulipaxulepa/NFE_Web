<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@lang('fields.app_name')</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('plugins/morris/morris.css') }}">
    <link href="{{ asset('plugins/sweet-alert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/icons.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <style>
        th {
            font-weight: bold;
        }
    </style>
</head>
<body class="fixed-left">
<div id="wrapper">
    <div class="left side-menu">
        <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
            <i class="ion-close"></i>
        </button>
        <div class="topbar-left">
            <div class="text-center">
                <a href="{{ url('home') }}" class="logo"><img src="{{ asset('images/logo.png') }}" height="24"
                                                              alt="logo"></a>
            </div>
        </div>
        <div class="sidebar-inner slimscrollleft">
            <div class="user-details">
                <div class="text-center">
                    <img src="{{ asset('images/gnfe.png') }}" alt="" class="rounded-circle">
                </div>
                <div class="user-info">
                    <h4 class="font-16">{{ Auth::user()->name }}</h4>
                </div>
            </div>
            <div id="sidebar-menu">
                <ul>
                    @if(Session::has('profile') && (Auth::user()->permissionBoolean('ROLE_ADMIN') || ((Auth::user()->permissionBoolean('ROLE_ENTERPRISE') || Auth::user()->permissionBoolean('ROLE_MANAGER')) && Session::has('enterprise'))))
                        <li>
                            <a href="{{ url('home') }}" class="waves-effect"><i class="ti-home"></i>
                                <span> @lang('fields.menu_home')</span>
                            </a>
                        </li>
                    @endif
                    @if(!Session::has('profile'))
                        <li>
                            <a href="{{ url('profile/create') }}" class="waves-effect"><i
                                        class="fa fa-address-card"></i>
                                <span> @lang('fields.menu_profile')</span>
                            </a>
                        </li>
                    @endif
                    @if((Auth::user()->permissionBoolean('ROLE_ENTERPRISE') || Auth::user()->permissionBoolean('ROLE_MANAGER')) && Session::has('profile') && !Session::has('enterprise'))
                        <li>
                            <a href="{{ url('enterprise') }}" class="waves-effect"><i class="fa fa-university"></i>
                                <span> @lang('fields.menu_enterprises')</span>
                            </a>
                        </li>
                    @endif
                    @if(Auth::user()->status && Session::has('profile'))
                        @if(Auth::user()->permissionBoolean('ROLE_ADMIN'))
                            <li><a href="{{ url('user') }}" class="waves-effect"><i
                                            class="ti-user"></i><span> @lang('fields.menu_users')</span></a></li>
                            <li><a href="{{ url('enterprise') }}" class="waves-effect"><i
                                            class="fa fa-university"></i><span> @lang('fields.menu_enterprises')</span></a>
                            </li>
                            <li><a href="{{ url('cfop') }}" class="waves-effect"><i
                                            class="fa fa-list-alt"></i><span> @lang('fields.menu_cfops')</span></a></li>
                            <li><a href="{{ url('ncm') }}" class="waves-effect"><i
                                            class="fa fa-list-alt"></i><span> @lang('fields.menu_ncms')</span></a></li>
                            <li><a href="{{ url('cst') }}" class="waves-effect"><i
                                            class="fa fa-list-alt"></i><span> @lang('fields.menu_csts')</span></a></li>
                        @endif
                        @if(Auth::user()->permissionBoolean('ROLE_ENTERPRISE') && Session::has('enterprise'))
                            <li><a href="{{ url('userenterprise') }}"><i
                                            class="fa fa-users"></i> @lang("fields.menu_users_enterprise")</a></li>
                        @endif
                        @if(Session::has('enterprise'))
                            <li><a href="{{ url('product') }}"><i
                                            class="fa fa-shopping-basket"></i> @lang("fields.menu_products")</a></li>
                            <li><a href="{{ url('note') }}"><i class="fa fa-cart-plus"></i> @lang("fields.menu_notes")
                                </a></li>
                            <li>
                                <a href="#" class="waves-effect"
                                   onclick="changeEnterprise()">
                                    <i class="fa fa-exchange"></i> @lang("fields.menu_change_of_enterprise")
                                </a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="content-page">
        <div class="content">
            <div class="topbar">
                <nav class="navbar-custom">
                    <ul class="list-inline float-right mb-0">
                        <li class="list-inline-item dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown"
                               href="#" role="button"
                               aria-haspopup="false" aria-expanded="false">
                                <i class="mdi mdi-account noti-icon"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                @if(Session::has('enterprise'))
                                    @if(Auth::user()->permissionBoolean('ROLE_ENTERPRISE'))
                                        <a class="dropdown-item"
                                           href="{{ url('enterprise/'.Session::get('enterprise')->id.'/edit') }}"><i
                                                    class="fa fa-university m-r-5 text-muted"></i> @lang("fields.menu_enterprise")
                                        </a>
                                    @elseif(Auth::user()->permissionBoolean('ROLE_MANAGER'))
                                        <a class="dropdown-item"
                                           href="{{ url('enterprise/'.Session::get('enterprise')->id) }}"><i
                                                    class="fa fa-university m-r-5 text-muted"></i> @lang("fields.menu_enterprise")
                                        </a>
                                    @endif
                                @endif
                                @if(Auth::user()->permissionBoolean('ROLE_ADMIN'))
                                    <a class="dropdown-item" href="{{ url('soon') }}"><i
                                                class="fa fa-image m-r-5 text-muted"></i> @lang('fields.menu_soon')</a>
                                @endif
                                @if(Session::has('profile'))
                                    <a class="dropdown-item"
                                       href="{{ url('profile/'.Session::get('profile')->id.'/edit') }}"><i
                                                class="fa fa-address-card m-r-5 text-muted"></i> @lang('fields.menu_profile')
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ url('user/'.Auth::id().'/edit') }}"><i
                                            class="mdi mdi-account-circle m-r-5 text-muted"></i> @lang('fields.menu_user')
                                </a>
                                <button class="dropdown-item" onclick="logout()"><i
                                            class="mdi mdi-logout m-r-5 text-muted"></i> @lang('fields.menu_exit')
                                </button>
                                {{ Form::open(['route' => 'logout', 'method' => 'POST', 'id' => 'logout-form', 'style' => 'display: none;']) }}{{ Form::close() }}
                            </div>
                        </li>
                    </ul>
                    <ul class="list-inline menu-left mb-0">
                        <li class="list-inline-item">
                            <button type="button" class="button-menu-mobile open-left waves-effect">
                                <i class="ion-navicon"></i>
                            </button>
                        </li>
                        <li class="hide-phone list-inline-item app-search">
                            <h3 class="page-title">@lang("fields.app_name") @yield('title')</h3>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </nav>
            </div>
            <div class="page-content-wrapper ">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>
        <footer class="footer">
            © 2018 {{ date("Y") != 2018 ? " - " . date("Y") : "" }} CopyRight {{ __("fields.app_enterprise_name") }}.
        </footer>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
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
<script src="{{ asset('plugins/morris/morris.min.js') }}"></script>
<script src="{{ asset('plugins/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('pages/dashborad.js') }}"></script>
<script src="{{ asset('js/jquery_validate/jquery.validate.js') }}"></script>
<script src="{{ asset('js/jquery.maskedinput.js') }}"></script>
<script src="{{ asset('plugins/sweet-alert2/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
<script>
    function logout() {
        swal({
            title: "{{ __("messages.exit_system") }}",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "{{ __("fields.exit_yes") }}",
            cancelButtonText: "{{ __("fields.exit_not") }}",
            closeOnConfirm: false
        }).then(function () {
            event.preventDefault();
            document.getElementById('logout-form').submit();
        });
    }

    function changeEnterprise() {
        swal({
            title: '{{ __("messages.change_enterprise") }}',
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: "{{ __("fields.change_yes") }}",
            cancelButtonText: "{{ __("fields.change_not") }}"
        }).then(function () {
            $.ajax({
                type: 'GET',
                url: '{{ url('enterprise/process/change') }}',
                async: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (data) {
                    if (data.status == "OK") {
                        location.href = '{{ url('home') }}'
                    }
                }, error: function (data) {
                    alert('ERROR NO SERVER.')
                }
            });
        });
    }

    {{--function destroy(url_delete, url_redirect) {--}}
    {{--swal({--}}
    {{--title: "{{ __("messages.destroy") }}",--}}
    {{--type: "error",--}}
    {{--showCancelButton: true,--}}
    {{--confirmButtonText: "{{ __("fields.delete_yes") }}",--}}
    {{--cancelButtonText: "{{ __("fields.delete_not") }}"--}}
    {{--}).then(function () {--}}
    {{--$.ajax({--}}
    {{--type: "DELETE",--}}
    {{--url: url_delete,--}}
    {{--async: false,--}}
    {{--data: {'_method': 'DELETE'},--}}
    {{--headers: {--}}
    {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
    {{--},--}}
    {{--success: function (data) {--}}
    {{--if (data.status == "OK") {--}}
    {{--swal({--}}
    {{--title: "{{ __("messages.delete") }}",--}}
    {{--type: "success",--}}
    {{--confirmButtonText: "{{ __("fields.ok") }}"--}}
    {{--}).then(function () {--}}
    {{--location.href = url_redirect--}}
    {{--});--}}
    {{--}--}}
    {{--}, error: function (data) {--}}
    {{--alert('ERROR NO SERVER.')--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}
    {{--}--}}

    {{--function change(msg, type, method, url_form, datas, url_redirect) {--}}
    {{--swal({--}}
    {{--title: msg,--}}
    {{--type: type,--}}
    {{--showCancelButton: true,--}}
    {{--confirmButtonText: "{{ __("fields.change_yes") }}",--}}
    {{--cancelButtonText: "{{ __("fields.change_not") }}"--}}
    {{--}).then(function () {--}}
    {{--$.ajax({--}}
    {{--type: method,--}}
    {{--url: url_form,--}}
    {{--async: false,--}}
    {{--data: datas,--}}
    {{--headers: {--}}
    {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
    {{--},--}}
    {{--success: function (data) {--}}
    {{--if (data.status == "OK") {--}}
    {{--swal({--}}
    {{--title: "{{ __("messages.success") }}",--}}
    {{--type: "success",--}}
    {{--confirmButtonText: "{{ __("fields.ok") }}"--}}
    {{--}).then(function () {--}}
    {{--location.href = url_redirect--}}
    {{--});--}}
    {{--} else if (data.status == "OK_NOT_MESSAGE") {--}}
    {{--location.href = url_redirect--}}
    {{--}--}}
    {{--}, error: function (data) {--}}
    {{--alert('ERROR NO SERVER.')--}}
    {{--}--}}
    {{--});--}}
    {{--});--}}
    {{--}--}}
</script>
@yield('script')
</body>
</html>