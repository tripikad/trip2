<div class="component-background {{ $options or ''}}"
    @if (isset($image))
        style="background-image: url({{ $image }});"
    @endif
>
    <div class="overlay">
    
        <div class="content">

            @if (isset($title))
                <h2>{{ $title }}</h2>
            @endif
    
        </div>

    </div>

</div>