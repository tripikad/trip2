<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <link href='http://fonts.googleapis.com/css?family=Lato:900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    
        <title>@yield('title') | {{ config('site.name') }}</title>
    </head>
    <body>
        <div class="container">

            @yield('menubar.top')
            
            @include('components.menubar')

            <hr />

            @yield('header.top')
            
            <div style="margin: 3em 0;">
                @yield('header', view('components.header.default'))
            </div>

            <hr />

            @yield('header.bottom')

            @yield('content')

            <hr />

            @yield('footer.top')

            @include('components.footer')

        </div>
    </body>
</html>
