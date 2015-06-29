<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        
        <link href="{{-- elixir('css/all.css') --}}" rel='stylesheet' type='text/css'>

        <link href='http://fonts.googleapis.com/css?family=Lato:900&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700&subset=latin,latin-ext' rel='stylesheet' type='text/css'>

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <style>
            body {
                margin-top: 2em;
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
                text-align: center;
                margin: 1.5em 0;
            }
            h3 {
                font-size: 1.6em;
            }
            h4 {
                font-size: 1.4em;
            }
            h5 {
                font-size: 1.2em;
            }
                        
        </style>
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="container">
            
            <div class="row">
            
                <div class="col-xs-2">
                    <h1>Trip2</h1>
                </div>
            
                <div class="col-xs-10">
            
                    <ul class="nav nav-pills">

                    @foreach (config('content.types') as $key => $type)
                        <li><a href="/content/index/{{ $key }}">{{ $type['title'] }}</a></li>
                    @endforeach

                    </ul>
                    
                </div>

            </div>

            <hr />

            <h2>@yield('title')</h2>

            @yield('content')
        </div>
    </body>
</html>
