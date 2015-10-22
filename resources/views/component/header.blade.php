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