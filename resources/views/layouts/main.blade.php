<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>
    
    </head>
    <body>
        
        @include('component.header1')

        @include('component.header2')

        @include('component.header3')

        @yield('test_custom', view('component.test'))

        <div class="container utils-padding-top">

            <div class="text-center">
            
                @yield('navbar.bottom')
            
            </div>

            @yield('header4')

            @include('component.info.success')

            @include('component.info.error')

            @yield('content')

            <div class="text-center">
            
                @include('component.footer')
            
            </div>

        </div>

        <script type="text/javascript" src="/js/main.js"></script>

    </body>

</html>
