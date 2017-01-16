<!DOCTYPE html>
<html>
    <head>
        @include('v2.utils.sharing')
        @include('v2.utils.favicons')
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta http-equiv="content-type" content="text/html; charset=UTF-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta id="globalprops" name="globalprops" content="
            {{
                rawurlencode(json_encode([
                    'token' => csrf_token(),
                    'alertRoute' => route('utils.alert'),
                    'allowedTags' => config('site.allowedtags'),
                    'maxfilesize' => config('site.maxfilesize'),
                    'promo' => config('promo')
                ])) 
            }}
        ">
        <link rel="stylesheet" href="/v2/css/main.css">
        <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml" />
    </head>
    <body>
        @include('v2.utils.svg')
        <div id="app">
            @yield('promobar')
            @yield('header')
            @yield('content')
            @yield('footer')
            <photo-fullscreen></photo-fullscreen>
            <alert></alert>
        </div>
        <script src="/v2/js/main.js"></script>
        @include('v2.utils.promo')
        @include('v2.utils.facebook')
        @include('v2.utils.analytics')
        @stack('scripts')
    </body>
</html>
