<title>{{ config('site.name') }} | @yield('title')</title>
<meta name="description" content="@yield('head_description')">
<meta property="og:title" content="@yield('head_title')">
<meta property="twitter:text:title" content="@yield('head_title')">
<meta property="og:description" content="@yield('head_description')">
<meta property="twitter:description" content="@yield('head_description')">
<meta property="og:image" content="@yield('head_image')">
<meta property="og:image:width" content="@yield('head_image_width')">
<meta property="og:image:height" content="@yield('head_image_height')">
<meta property="og:url" content="{{ Request::url() }}">
<meta property="og:type" content="website">
<meta property="og:locale" content="et_EE">
<meta name="twitter:card" content="summary_large_image">
<meta property="fb:app_id" content="{{ config('services.facebook.client_id') }}">
<meta name="robots" content="@yield('head_robots')">
