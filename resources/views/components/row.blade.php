<div class="component-row">

    <div class="col-xs-2 col-sm-1">

        @if (isset($image_link)) <a href="{{ $image_link }}"> @endif

        @if (isset($image))
            
            @include('components.image', [
                'image' => $image,
                'options' => '-circle'
            ])

        @endif
         
        @if (isset($image_link)) </a> @endif

    </div>

    <div class="col-xs-10 col-sm-10">

        @if (isset($heading_link)) <a href="{{ $heading_link }}"> @endif
        
        @if (isset($heading)) <h3 style="margin: 0;">{{ $heading }}</h3> @endif

        @if (isset($heading_link)) </a> @endif

        @if (isset($text)) {!! $text !!} @endif

    </div>

    <div class="col-sm-1">

        @if (isset($extra)) {!! $extra !!} @endif

    </div>

</div>