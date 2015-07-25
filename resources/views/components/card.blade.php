<div
    class="component-card {{ $options or ''}}"
    @include('components.image.background', ['image' => $image])
>
    <div class="content">
    
        @if (isset($title))
            <h3>{{ str_limit($title, 50) }}</h3>
        @endif

        @if (isset($text))
            <p>{{ $text }}</p>
        @endif
    
    </div>

</div>