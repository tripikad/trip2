@if(env('INVISIBLE_RECAPTCHA_SITEKEY','') && env('INVISIBLE_RECAPTCHA_SECRETKEY','')) 

@section('captcha', app('captcha')->renderPolyfill())

{!! app('captcha')->renderCaptchaHTML() !!}

@push('scripts')
    {!! app('captcha')->renderFooterJS(config('app.locale')) !!}
@endpush

@endif