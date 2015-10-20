<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link href="/css/main.css" rel='stylesheet' type='text/css'>

        <title>@yield('title') | {{ config('site.name') }}</title>

    </head>
    <body>{{ Analytics::render() }}

        @include('component.header')

{{--         @yield('masthead', view('component.masthead'))

        <div class="utils-padding-bottom">

            @yield('header2', view('component.header2'))

            @yield('header3', view('component.header3'))

        </div>

        <div class="container"> --}}

            @include('component.info.success')

            @include('component.info.error')

            @yield('content')

{{--         </div> --}}

        @include('component.footer')

        <script type="text/javascript" src="/js/main.js"></script>

        <script type="text/javascript">
    (function() {
        var path = '//easy.myfonts.net/v2/js?sid=260918(font-family=Sailec+Bold)&sid=260923(font-family=Sailec+Light)&sid=260924(font-family=Sailec+Medium)&sid=260929(font-family=Sailec+Regular+Italic)&key=eTFuMvz2lk',
            protocol = ('https:' == document.location.protocol ? 'https:' : 'http:'),
            trial = document.createElement('script');
        trial.type = 'text/javascript';
        trial.async = true;
        trial.src = protocol + path;
        var head = document.getElementsByTagName("head")[0];
        head.appendChild(trial);
    })();
</script>

    </body>

</html>
