<div
    class="component-image {{ $options or ''}}"
    style="
        background-image: url({{ $image }});
        @if(isset($width))
            width: {{ $width }};
            padding-bottom: {{ $width }};
        @endif
">
</div>
