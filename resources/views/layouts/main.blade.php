<!DOCTYPE html>
<html lang="et">
    <head>
        <title>{{ (trim($__env->yieldContent('head_title')) ? trim($__env->yieldContent('head_title')) . ' - ' : (trim($__env->yieldContent('title')) ? trim($__env->yieldContent('title')) .' - ' : '')) . config('site.name') }}</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="@yield('head_description')">
        <meta property="og:title" content="{{ (trim($__env->yieldContent('head_title')) ? trim($__env->yieldContent('head_title')) . ' - ' : (trim($__env->yieldContent('title')) ? trim($__env->yieldContent('title')) .' - ' : '')) . config('site.name') }}">
        <meta property="og:description" content="@yield('head_description')">
        <meta property="og:image" content="@yield('head_image')">
        <meta property="og:url" content="{{ Request::url() }}">
        <meta property="og:type" content="@yield('fb_type', 'website')">
        <meta property="og:locale" content="et_EE">
        <meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}">
        <meta name="twitter:card" content="summary_large_image">
        <meta property="promos" content="{{ rawurlencode(json_encode(config('promo'))) }}">
        <link rel="sitemap" type="application/xml" title="Sitemap" href="/sitemap.xml" />
        <link rel="apple-touch-icon" sizes="57x57" href="/apple-touch-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="/apple-touch-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="/apple-touch-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="/apple-touch-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="/apple-touch-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="/apple-touch-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="/apple-touch-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon-180x180.png">
        <link rel="icon" type="image/png" href="/favicon-32x32.png" sizes="32x32">
        <link rel="icon" type="image/png" href="/android-chrome-192x192.png" sizes="192x192">
        <link rel="icon" type="image/png" href="/favicon-96x96.png" sizes="96x96">
        <link rel="icon" type="image/png" href="/favicon-16x16.png" sizes="16x16">
        <link href="/V1dist/main.css" rel="stylesheet" type="text/css">
        <meta id="globalprops" name="globalprops" content="
            {{
                rawurlencode(json_encode([
                    'token' => csrf_token(),
                    'info' => session('info'),
                    'allowedTags' => config('site.allowedtags'),
                    'maxfilesize' => config('site.maxfilesize'),
                    'promo' => config('promo'),
                    'imageUploadRoute' => route('image.store'),
                    'imageUploadTitle' => trans('image.drop.title'),
                ]))
            }}
                ">
    </head>
    <body>
        @include('component.alert.success')
        @include('component.alert.error')
        @yield('header', view('component.header'))
        @yield('content')
        @yield('footer', view('component.footer'))
        <script defer type="text/javascript" src="/V1dist/main.js"></script>
        @yield('scripts')
        {!! Analytics::render() !!}
        <div id="fb-root"></div>
        <script>(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0];if (d.getElementById(id)) return;js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";fjs.parentNode.insertBefore(js, fjs);}(document, 'script', 'facebook-jssdk'));</script>
    </body>
</html>