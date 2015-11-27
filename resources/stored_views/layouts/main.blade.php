<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>

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
