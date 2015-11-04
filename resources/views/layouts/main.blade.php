<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>

    </head>
    <body>{{ Analytics::render() }}

        @yield('header', view('component.header'))

        @include('component.info.success')

        @include('component.info.error')

        @yield('content')

        @yield('footer', view('component.footer'))

        <script type="text/javascript" src="/js/main.js"></script>

    </body>

</html>
