<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>
    
    </head>
    <body>
        
        <div class="utils-padding-bottom">

            @yield('header1', view('component.header1'))

            @yield('header2', view('component.header2'))

            @yield('header3', view('component.header3'))

        </div>

        <div class="container">

            @include('component.info.success')

            @include('component.info.error')

            @yield('content')
            
            @include('component.footer')
            
        </div>

        <script type="text/javascript" src="/js/main.js"></script>

    </body>

</html>
