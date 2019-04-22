@extends('layouts.app_login')

@section('content')
    <h4 class="text-muted text-center">
        <b>@lang('fields.process_loading')</b>
        <img src="{{ asset('images/loading.gif') }}" />
    </h4>
@endsection

@section('script')
    <script>
		$(window).load(function(){
			loadDates();
		});
		function loadDates(){
            $.ajax({
                type: "POST",
                url: "{{ url('api/process/ajax') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                async: false,
                data: {enterprise: '{{ Session::get('enterprise')->id }}'},
                success: function (data) {
                    setTimeout(redirect(), 100000)
                }, error: function (data) {
                    alert('ERROR SERVER')
                }
            });
		}

        function redirect(){
            location.href = '{{ url('home') }}'
        }
    </script>
@endsection
