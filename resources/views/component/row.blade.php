<div class="component-row row" style="background: yellow;">

    <div class="col-xs-2 col-sm-1">

        @if (isset($image_link)) <a href="{{ $image_link }}"> @endif

        @if (isset($image))
            
            @include('component.image', [
                'image' => $image,
                'options' => '-circle'
            ])

        @endif
         
        @if (isset($image_link)) </a> @endif

    </div>

    @if (isset($extra))

        <div class="col-xs-7 col-sm-10">

    @else

        <div class="col-xs-10 col-sm-11">

    @endif

            @if (isset($heading_link)) <a href="{{ $heading_link }}"> @endif
        
            @if (isset($heading)) <h3>{{ $heading }}</h3> @endif

            @if (isset($heading_link)) </a> @endif

            @if (isset($text)) {!! $text !!} @endif

        </div>

    @if (isset($extra))

        <div class="col-xs-3 col-sm-1">

            {!! $extra !!}

        </div>

    @endif

</div>