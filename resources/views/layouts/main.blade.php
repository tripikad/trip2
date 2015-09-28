<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>
    
    </head>
    <body>
        
        @include('component.background')
{{--
        
        @yield('navbar.bottom')
--}}
        <div class="container">
            
            @include('component.info.success')

            @include('component.info.error')

            @yield('content')

            @include('component.footer')

        </div>

        <script type="text/javascript" src="/js/main.js"></script>

    </body>

</html>
