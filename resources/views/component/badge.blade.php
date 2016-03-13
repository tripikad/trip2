{{--

title: Badge

code: |

    @include('component.badge', [
        'modifiers' => $modifiers,
        'count' => 4
    ])

modifiers:

- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple
- m-inverted m-red
- m-inverted m-blue
- m-inverted m-green
- m-inverted m-orange
- m-inverted m-yellow
- m-inverted m-purple

--}}

<div class="c-badge {{ $modifiers or '' }}">

    @if(isset($count))

        <span class="c-badge__count">

    	    {{ $count }}

        </span>

    @endif

    @if(isset($title) && !isset($count))

        <span class="c-badge__text">

            {{ $title }}

        </span>

    @endif

</div>
