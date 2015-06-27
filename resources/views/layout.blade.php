<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <style>
            body {
                margin-top: 2em;
            }
            img {
                width: 100%;
            }
            h1, h2, h3, h4, h5, h6 {
                margin-top: 0;
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
