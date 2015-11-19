{{--

title: Button

code: |

    @include('component.button', [
        'title' => 'Button',
        'route' => '',
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

<a href="{{ $route }}" class="c-button {{ $modifiers or '' }}">
    @if (isset($title))

    {{ $title }}

    @endif

    @if (isset($icon) && !isset($title))

    {!! $icon !!}

    @endif
</a>