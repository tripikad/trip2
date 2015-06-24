<html>
    <head>
        <title>@yield('title')</title>
        <style>
            body {
                font-family: sans-serif;
                padding: 25px;
            }
            a {
                color: CadetBlue;
            }
            p {
                line-height: 1.3em;
                margin-bottom: 0.5em;
            }
            
        </style>
    </head>
    <body>
        <h1>Trip2</h1>

        <h2>@yield('title')</h2>
            
        @yield('content')
    
    </body>
</html>
