<header class="c-header">

    <div class="c-header__search">

        @include('component.search',[
        	'modifiers' => 'm-small m-red',
        	'placeholder' => 'Search'
        ])

    </div>

    <div class="c-header__nav">

        <nav class="c-nav">

            @include('component.navbar')

        </nav>
    </div>
</header>

@yield('title')

@yield('header1.left')
@yield('header1.top')
@yield('header1.bottom')
@yield('header1.right')

@yield('header2.content')
@yield('header3.content')