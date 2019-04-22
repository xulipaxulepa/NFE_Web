@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
{{--# {{ $greeting }}--}}
@else
@if ($level == 'error')
# {{ __("fields.reset_email_fail") }}
@else
# {{ __("fields.reset_email_title_recovery") }}
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
            $color = 'green';
            break;
        case 'error':
            $color = 'red';
            break;
        default:
            $color = 'blue';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
{{--Regards,<br>{{ config('app.name') }}--}}
@endif

@endcomponent