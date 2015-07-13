<div class="row">

    <div class="col-xs-4 col-sm-5">
    </div>

    <div class="col-xs-4 col-sm-2">

        @if (isset($link))<a href="{{ $link }}">@endif
        
        @include('components.image.circle', ['image' => $image])
        
        @if (isset($link))</a>@endif

    </div>

    <div class="col-xs-4 col-sm-5">
    </div>

</div>

<h2>@yield('title')</h2>

<p class="text-center">@yield('subtitle')</p>

<div class="row">

    <div class="col-sm-3">
    </div>

    <div class="col-xs-6 col-sm-3">

        @yield('header.left')
    
    </div>

    <div class="col-xs-6 col-sm-3">

        @yield('header.right')
    
    </div>

    <div class="col-sm-3">
    </div>


</div>