@if(!auth()->user())

<header class="c-header {{ $modifiers or '' }}">

@else

<header class="c-header m-logged-in {{ $modifiers or '' }}">

@endif

    <div class="c-header__logo">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.logo', [
                'modifiers' => 'm-small'
            ])

        @else

            @include('component.logo', [
                'modifiers' => 'm-small m-dark'
            ])

        @endif

    </div>

    <div class="c-header__search">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.search',[
            	'modifiers' => 'm-small m-red m-alternative',
            	'placeholder' => 'Search'
            ])

        @else

            @include('component.search',[
                'modifiers' => 'm-small m-red',
                'placeholder' => 'Search'
            ])

        @endif

    </div>

    <div class="c-header__nav">

        @if (isset($modifiers) && $modifiers === 'm-alternative')

            @include('component.navbar',[
                'modifiers' => 'm-alternative m-purple'
            ])

        @else

            @include('component.navbar',[
                'modifiers' => 'm-blue'
            ])

        @endif

    </div>
</header>