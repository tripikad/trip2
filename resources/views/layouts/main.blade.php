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
            
            @include('components.header')

            <hr />
            
            <div style="margin: 3em 0;">
                @yield('hero', view('components.hero.default'))
            </div>

            @yield('content')

        </div>
    </body>
</html>
