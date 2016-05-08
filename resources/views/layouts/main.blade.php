<!DOCTYPE html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/css/main.css" rel='stylesheet' type='text/css'>
        @if(Request::is('/'))
        <title>{{ config('site.name') }}</title>
        @else
        <title>@yield('title') – {{ config('site.name') }}</title>
        @endif
        <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}">
        <meta property="og:url" content="{{ Request::root() }}">
        <meta property="og:type" content="@yield('fb_type', 'website')">
        <meta property="og:title" content="@yield('title', config('site.name'))">
        <meta property="og:description" content="@yield('fb_description')">
        <meta property="og:image" content="@yield('fb_image')">
        <meta property="og:locale" content="et_EE">
        <meta property="promos" content="{{ rawurlencode(json_encode(config('promo'))) }}">
    </head>
    <body>{{ Analytics::render() }}
        @include('component.alert.success')
        @include('component.alert.error')
        @yield('header', view('component.header'))
        @yield('content')
        @yield('footer', view('component.footer'))
        <script type="text/javascript" src="/js/main.js"></script>
        @yield('scripts')
        <!-- Load Facebook SDK for JavaScript -->
        <div id="fb-root"></div>
        <script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
    </body>
</html>