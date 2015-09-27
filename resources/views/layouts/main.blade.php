<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>
    
    </head>
    <body>
        
        @yield('header.background')
        
        <div class="container">
            
            <div class="container" style="
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                z-index: 1000;
            ">

            @include('component.navbar')

            </div>
            
            @yield('navbar.bottom')

            @include('component.info.success')
            
            @yield('header', view('component.header'))

            @include('component.info.error')

            @yield('content')

            @include('component.footer')

        </div>

        <script type="text/javascript" src="/js/main.js"></script>

    </body>

</html>
