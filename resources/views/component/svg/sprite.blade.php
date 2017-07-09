{{--

title: Get specific item from SVG sprite file

code: |

    @include('component.svg.sprite', [
        'name' => 'iconname'
    ])

--}}

<svg>
    <use xlink:href="/V1dist/main.svg#{{ $name }}"></use>
</svg>
