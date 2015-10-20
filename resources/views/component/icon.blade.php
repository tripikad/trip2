{{--

description: A SVG icon

code: |

    @include('component.icon', ['icon' => 'iconname'])

--}}

<svg>
    <use xlink:href="/svg/main.svg#{{ $icon }}"></use>
</svg>