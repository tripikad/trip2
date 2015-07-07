<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="/css/app.css" rel='stylesheet' type='text/css'>

        <link href='http://fonts.googleapis.com/css?family=Lato:900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
    
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="container">
            
            <div class="row">
            
                <div class="col-sm-1 text-center">
                    <h1><a href="/">Trip2</a></h1>
                </div>
            
                <div class="col-sm-9 text-center">
            
                    <ul class="nav nav-pills">

                    @foreach (config('content.types') as $key => $type)
                        <li><a href="/content/index/{{ $key }}">{{ $type['title'] }}</a></li>
                    @endforeach

                    </ul>

                </div>

                <div class="col-sm-2 text-center">
                    
                    @include('components.placeholder', ['text' => 'Login&nbsp;&nbsp;&nbsp;Search'])
                
                </div>

            </div>

            <hr />

            <h2>@yield('title')</h2>

            {{--
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
