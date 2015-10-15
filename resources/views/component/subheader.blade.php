{{--

description: A generic header for section titles, box titles etc

code: |

    @include('component.subheader', [
        'title' => 'Subheader',
        'link_title' => 'More',
        'link_route' => '',
        'options' => $options,
    ])

options:

- orange
- cyan

--}}

<div class="component-subheader {{ $options or ''}}">

    <div class="row">
    
        <div class="col-xs-9">

            <h3 class="title">{{ $title }}</h3>

        </div>

        <div class="col-xs-3 text-right">

            @if (isset($link_title))

                <a href="{{ $link_route }}">{{ $link_title }} ›</a>

            @endif

        </div>

    </div>

</div>