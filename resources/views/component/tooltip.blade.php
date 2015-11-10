{{--

title: Tooltip

code: |

    @include('component.tooltip', [
        'modifiers' => $modifiers,
        'text' => ''
    ])

modifiers:

- m-red
- m-blue
- m-green
- m-yellow
- m-orange
- m-purple
- m-inverted m-red
- m-inverted m-blue
- m-inverted m-green
- m-inverted m-yellow
- m-inverted m-orange
- m-inverted m-purple

--}}

<div class="c-tooltip {{ $modifiers or '' }}">
    {{ $text }}
    @if (isset($link))
        {!! $link !!}
    @endif
</div>