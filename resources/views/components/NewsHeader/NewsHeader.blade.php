@php

$background = $background ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="NewsHeader {{ $isclasses }}" 
	style="background-image: linear-gradient(
      rgba(0, 0, 0, 0),
      rgba(0, 0, 0, 0.4)
    ), url({{ $background }});">

    <div class="container">

        <div class="NewsHeader__navbar">

        	{!! $navbar !!}
        	
        </div>

        <div class="row row-center">

        <div class="col-9">

        <div class="NewsHeader__content">

        	<h2 class="NewsHeader__title">

            {!! $title !!}

            </h2>

            <div class="NewsHeader__meta">

            {!! $meta !!}

        	</div>

        </div>

        </div>

        </div>  

    </div>

</div>
