<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{-- elixir('css/all.css') --}}" rel='stylesheet' type='text/css'>

        <link href='http://fonts.googleapis.com/css?family=Lato:900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <style>
            body {
                margin: 2em 0 8em 0;
                font-size: 1.4em;
                line-height: 1.6em;
                font-family: 'Open Sans', sans-serif;
            }
            img {
                width: 100%;
            }
            h1, h2, h3, h4, h5, h6 {
                margin-top: 0;
                font-weight: bold;
                font-family: 'Lato', sans-serif;
                line-height: 1.3em;
            }
            h1 {
                text-transform: uppercase;
                font-size: 1.8em;
            }
            h2 {
                font-size: 2.1em;
            }
            h3 {
                font-size: 22px;
            }
            h4 {
                font-size: 20px;
            }
                        
        </style>
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="container">
            
            <div class="row">
            
                <div class="col-sm-1 text-center">
                    <h1>Trip2</h1>
                </div>
            
                <div class="col-sm-9 text-center">
            
                    <ul class="nav nav-pills">

                    @foreach (config('content.types') as $key => $type)
                        <li><a href="/content/index/{{ $key }}">{{ $type['title'] }}</a></li>
                    @endforeach

                    </ul>

                </div>

                <div class="col-sm-2 text-center">
                    
                    @include('component.placeholder', ['text' => 'Login&nbsp;&nbsp;&nbsp;Search'])
                
                </div>

            </div>

            <hr />
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
            @yield('content')
        </div>
    </body>
</html>
