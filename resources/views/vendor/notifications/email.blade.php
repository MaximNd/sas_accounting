@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level == 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
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
    $pass_pos = strpos($actionUrl, '/password');
    $passwordResetUrl = substr($actionUrl, 0, $pass_pos).'/#'.substr($actionUrl, $pass_pos);
    $api_pos = strpos($passwordResetUrl, '/api');
    $passwordResetUrl = substr($passwordResetUrl, 0, $api_pos).substr($passwordResetUrl, $api_pos + 4);
?>
@component('mail::button', ['url' => $passwordResetUrl, 'color' => $color])
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
@lang('Regards'),<br>{{ config('app.name') }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@component('mail::subcopy')
@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser: [:actionURL](:passwordResetUrl)',
    [
        'actionText' => $actionText,
        'actionURL' => $passwordResetUrl
    ]
)
@endcomponent
@endisset
@endcomponent
