<header class="c-header {{ $modifiers or '' }}">

    <div class="c-header__search">

        @include('component.search',[
        	'modifiers' => 'm-small m-red',
        	'placeholder' => 'Search'
        ])

    </div>

    <div class="c-header__nav">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.navbar',[
                'modifiers' => 'm-alternative'
            ])

        @else

            @include('component.navbar')

        @endif

    </div>
</header>