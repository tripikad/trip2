{{--

title: Map

description: An SVG background map

code: |

    @include('component.map', [
        'map_top' => 0,
        'map_left' => 0
    ])

--}}

<div class="c-map {{ $modifiers or '' }}">
    
    <div class="c-map__location" style="top: {{ $map_top }}; left: {{ $map_left }};"></div>
    
    <img src="/svg/map.svg" />

</div>