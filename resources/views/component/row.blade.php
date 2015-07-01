<div class="row">

    <div class="col-xs-2 col-sm-1">

        @if (isset($image_link)) <a href="{{ $image_link }}"> @endif

        @include('image.circle', ['image' => $image])
         
        @if (isset($image_link)) </a> @endif

    </div>

    <div class="col-xs-10 col-sm-10">

        @if (isset($heading_link)) <a href="{{ $heading_link }}"> @endif
        
        <h4>{{ $heading }}</h4>

        @if (isset($heading_link)) </a> @endif

        <p>{!! $text !!}</p>

    </div>

    <div class="col-sm-1">

    </div>

</div>