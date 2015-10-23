{{--

description: Destination subheader

code: |
    
    @include('component.destination.subheader', [
        'title' => 'City',
        'title_route' => '',
        'text' => 'Country',
        'text_route' => '',
        'options' => $modifiers
    ])

modifiers:

- orange
- green
- red

--}}

<div class="component-destination-subheader {{ $options or ''}}">

    <a href="{{ $title_route }}">

        <h3>{{ $title }} ›</h3>

    </a>

    <a href="{{ $text_route }}">

        {{ $text }} ›

    </a>

</div>