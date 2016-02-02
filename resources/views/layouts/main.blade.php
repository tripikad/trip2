<!DOCTYPE html>
<html lang="et">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="/css/main.css" rel='stylesheet' type='text/css'>
        <title>@yield('title') | {{ config('site.name') }}</title>
        <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}">
        <meta property="og:url" content="{{ Request::root() }}">
        <meta property="og:type" content="@yield('fb_type', 'website')">
        <meta property="og:title" content="@yield('title', config('site.name'))">
        <meta property="og:description" content="@yield('fb_description')">
        <meta property="og:image" content="@yield('fb_image')">
        <meta property="og:locale" content="et_EE">
    </head>
    <body>{{ Analytics::render() }}

        @include('component.alert.success')

        @include('component.alert.error')

        @yield('header', view('component.header'))

        @yield('content')

        @yield('footer', view('component.footer'))

        <script type="text/javascript" src="/js/main.js"></script>

        @yield('scripts')

    </body>

</html>
