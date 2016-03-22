{{--

title: Map

description: An SVG background map

code: |

    @include('component.map', [
        'modifiers' => '',
        'map_top' => 0,
        'map_left' => 0
    ])

--}}

<div class="c-map {{ $modifiers or '' }}">

    @if (isset($map_top) && isset($map_left))

    <div class="c-map__location" style="top: {{ $map_top }}; left: {{ $map_left }};"></div>

    @endif

    @include('component.svg.standalone', [
        'name' => 'map'
    ])

</div>