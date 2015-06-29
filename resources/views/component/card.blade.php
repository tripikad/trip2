<div style="
    width: 100%;
    padding-bottom: 66%;
  
    @if (isset($image))
        background-position: center;
        background-size: cover;
        background-image: url({{ $image }});
    @endif

    background-color: #eee;
    margin-bottom: 1.5em;
">
    @if (isset($image)) 
    <div style="
        position: absolute;
        top: 0;
        right: 15px;
        left: 15px;
        bottom: 1.5em;
        background: #000;
        opacity: 0.5;
    ">
    </div>
    @endif
    <div style="
        position: absolute;
        top: 0;
        right: 15px;
        left: 15px;
        bottom: 0;
        padding: 15px;
        @if (isset($image))
          color: white;
          letter-spacing: 0.05em;
        @endif
    ">
        @if (isset($title))
            <h3>{{ $title }}</h3>
        @endif

        @if (isset($subtitle))
            <h4>{{ $subtitle }}</h4>
        @endif

        @if (isset($text))
            <p>{{ $text }}</p>
        @endif

    </div>

</div>