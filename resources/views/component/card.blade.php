{{--

Any card properties can be combined. Cards fill proportionally their container width

@include('component.card', [
    'image' => \App\Image::getRandom(),
    'title' => 'Here is title',
    'text' => 'Here is subtitle',
    'options' => '',
])

--}}

<div
    class="component-card {{ $options or ''}}"
    @if (isset($image))
        style="background-image: url({{ $image }});"
    @endif
>
    <div class="overlay">
    
        <div class="content">

            @if (isset($title))
                <h4>{{ $title }}</h4>
            @endif

            @if (isset($text))
                <p>{!! $text !!}</p>
            @endif
    
        </div>

    </div>

</div>