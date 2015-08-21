<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>
    
    </head>
    <body>
        
        <div class="container">
            
            <div class="utils-border-bottom">          
                
                @include('component.navbar')
            
            </div>  

            @include('component.status.success')
            
            @yield('header', view('component.header'))

            @include('component.status.error')

            @yield('content')

            @include('component.footer')


        </div>

        <script type="text/javascript" src="/js/main.js"></script>

    </body>

</html>
