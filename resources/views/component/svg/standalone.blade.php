{{--

title: Get output from specific SVG file

code: |

    @include('component.svg.standalone', [
        'name' => 'iconname'
    ])

--}}

<svg>
    <use xlink:href="/svg/{{ $name }}.svg"></use>
</svg>
