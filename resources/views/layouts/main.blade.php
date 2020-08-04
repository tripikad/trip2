<!DOCTYPE html>
<html>
    <head>
        @include('utils.sharing')
        @include('utils.favicons')
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        @if (app()->environment() === 'staging')
            <meta name="robots" content="noindex">
        @endif
        <meta name="google-site-verification" content="GJ69HgdyknrZZGmanskWCP9TqPNDJGR5OshtRDwZHJ0" />
        <meta id="globalprops" name="globalprops" content="
            {{
                rawurlencode(json_encode([
                    'token' => csrf_token(),
                    'info' => session('info'),
                    'allowedTags' => config('site.allowedtags'),
                    'maxfilesize' => config('site.maxfilesize'),
                    'promo' => config('promo'),
                    'imageUploadRoute' => route('image.store'),
                    'imageUploadTitle' => trans('image.drop.title'),
                    'imagePickerRoute' => route('image.index'),
                    'formatRoute' => route('utils.format')
                ])) 
            }}
        ">
        <link rel="stylesheet" href="{{ dist('css') }}">
        <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml" />
        <script data-ad-client="ca-pub-7068052549547391" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- TradeDoubler site verification 2960089 -->
        @yield('captcha')
    </head>
    <body>
        @include('utils.svg')
        <div
          id="app"
          class="background-{{ $color }}"
          style="position: relative; min-height: 100vh;"
        >
            @yield('background')
            @yield('promobar')
            {!! component('PhotoFullscreen') !!}
            @yield('header')
            {!! component('HeaderError') !!}
            @yield('content')
            @yield('footer')
            {!! component('Editor')!!}
            {!! component('ImagePicker') !!}
            {!! component('Alert') !!}
        </div>
        <script defer src="{{ dist('js') }}"></script>
        @include('utils.promo')
        @include('utils.facebook')
        @include('utils.googleTag')
        @include('utils.analytics')
        {{--@include('utils.adsense')--}}
        {{--@include('utils.hotjar')--}}
        {{--@include('utils.viglink')--}}
        @stack('scripts')
    </body>
</html>
