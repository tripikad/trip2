<div style="
    width: 100%;
    padding-bottom: 66%;
    margin-bottom: 14px;
    word-break: break-word;
    -webkit-hyphens: auto;
    -moz-hyphens: auto;
    hyphens: auto;

    @if (isset($image))
        background-position: center;
        background-size: cover;
        background-image: url({{ $image }});
    @else
        border: 1px dashed #888;
    @endif

">
    @if (isset($image)) 
    <div style="
        position: absolute;
        top: 0;
        right: 7px;
        left: 7px;
        bottom: 14px;
        background: #000;
        opacity: 0.5;
    ">
    </div>
    @endif
    <div style="
        position: absolute;
        top: 0;
        right: 7px;
        left: 7px;
        bottom: 0;
        padding: 15px;
        color: #333;
        overflow: hidden;

        @if (isset($image))
          color: white;
          letter-spacing: 0.05em;
        @endif
    ">
        @if (isset($title))
            <h3>{{ str_limit($title, 50) }}</h3>
        @endif

        @if (isset($subtitle))
            <h4>{{ $subtitle }}</h4>
        @endif

        @if (isset($text))
            <p>{{ $text }}</p>
        @endif

    </div>

</div>