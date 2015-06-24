<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <style>
            body {
            }
        </style>
        <title>@yield('title')</title>
    </head>
    <body>
        <div class="container">
            <h1>Trip2</h1>

            <h2>@yield('title')</h2>
                
            @yield('content')
        </div>
    </body>
</html>
