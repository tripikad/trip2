{{--

title: Icon

description: A set of SVG icons

code: |

    @include('component.icon', ['icon' => 'iconname'])

--}}

<svg>
    <use xlink:href="/svg/main.svg#{{ $icon }}"></use>
</svg>