{{--

title: Button group

code: |

    @include('component.button.group', [
        'items' => []
    ])

--}}

<ul class="c-button-group">

    @foreach ($items as $item)

        <li class="c-button-group__item {{ $item['modifiers'] or '' }}">

            {!! $item['button'] !!}

        </li>

    @endforeach

</ul>
