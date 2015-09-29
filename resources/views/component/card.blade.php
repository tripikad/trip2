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