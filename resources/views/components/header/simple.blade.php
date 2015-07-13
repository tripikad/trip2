<div class="row">

    <div class="col-sm-6 col-sm-push-3 text-center">
        <h2>@yield('title')</h2>
        <p>@yield('subtitle')</p>
    </div>

    <div class="col-sm-3 col-sm-pull-6">
        @yield('header.left')
    </div>

    <div class="col-sm-3 text-right">
        @yield('header.right')
    </div>

</div>