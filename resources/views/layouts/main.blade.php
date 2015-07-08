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

            @yield('subheader')

            {{--

            <h2>@yield('title')</h2>

            <div class="row" style="margin: 3em 0;">
            
                <div class="col-sm-6 col-sm-push-3 text-center">
                    <h2>@yield('title')</h2>
                </div>
            
                <div class="col-sm-3 col-sm-pull-6">
                    @yield('action.secondary')
                </div>
            
                <div class="col-sm-3">
                    @yield('action.primary')
                </div>
            
            </div>
            --}}
            @yield('content')

        </div>
    </body>
</html>
