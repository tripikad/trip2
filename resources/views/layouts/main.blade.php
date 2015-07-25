<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="/css/main.css" rel='stylesheet' type='text/css'>
        <link href="/css/selectize.bootstrap3.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>
    
    </head>
    <body>
        
        <div class="container">
            
            <div class="utils-border-bottom">          
                
                @include('components.navbar')
            
            </div>  

            @include('components.status.success')
            
            @include('components.header')

            @include('components.status.error')

            @yield('content')

            <hr style="margin-top:6em;">

            @include('components.footer')

        </div>

        <script type="text/javascript" src="/js/main.js"></script>

    </body>

</html>
