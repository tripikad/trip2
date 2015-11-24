{{--

title: Button

code: |

    @include('component.button', [
        'title' => 'Button',
        'route' => '#',
        'target' => '_blank',
        'modifiers' => $modifiers
    ])

modifiers:

- m-secondary
- m-tertiary
- m-block
- m-secondary m-block
- m-tertiary m-block
- m-small
- m-large
- m-loading
- m-shadow m-secondary
- m-border
- m-round

--}}

@if(isset($route) && $route!='')

    <a href="{{ $route }}" target="{{ $target or '_parent' }}" class="c-button {{ $modifiers or '' }}">

@else

    <span class="c-button {{ $modifiers or '' }}">

@endif

    @if (isset($title))

    {{ $title }}

    @endif

    @if (isset($icon) && !isset($title))

    {!! $icon !!}

    @endif

@if(isset($route) && $route!='')

    </a>

@else

    </span>

@endif
