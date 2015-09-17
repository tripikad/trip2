<div class="component-image {{ $options or ''}}">

    <img
        src="{{ $image }}"
        style="
            @if(isset($height) && $height == 'small')
                width:2.9em;
            @else
                width:4.3em;
            @endif
        "
    />

</div>