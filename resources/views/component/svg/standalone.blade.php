{{--

title: Get output from specific SVG file

code: |

    @include('component.svg.standalone', [
        'name' => 'iconname'
    ])

--}}

<span class="js-standalone" data-name="/svg/{!! $name !!}.svg"></span>
