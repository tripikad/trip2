<!DOCTYPE html>
<html>
    <head>
        @include('utils.sharing')
        @include('utils.favicons')
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
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
                ])) 
            }}
        ">
        <link rel="stylesheet" href="{{ dist('css') }}">
        <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml" />
        <!-- TradeDoubler site verification 2960089 -->
    </head>
    <body>
        @include('utils.svg')
        @stack('prescripts')
        <div id="app" class="background-{{ $color }}">
            @yield('background')
            @yield('promobar')
            {!! component('PhotoFullscreen') !!}
            @yield('header')
            {!! component('HeaderError') !!}
            @yield('content')
            @yield('footer')
            {!! component('ImagePicker')
                ->with('route', route('image.index'))
            !!}
            {!! component('Editor')
                ->with('route', route('utils.format'))
            !!}
            {!! component('Alert') !!}

        </div>
        <script defer src="{{ dist('js') }}"></script>
        @include('utils.promo')
        @include('utils.facebook')
        @include('utils.googleTag')
        @include('utils.analytics')
        @include('utils.hotjar')
        @stack('scripts')
    </body>
</html>
