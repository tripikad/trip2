@php

$background = $background ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="MastheadNews {{ $isclasses }}" 
	style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.1),
      rgba(0, 0, 0, 0.3)
    ), url({{ $background }});">

    <div class="container">

        <div class="MastheadNews__header">

        	{!! $header !!}
        	
        </div>

        <div class="MastheadNews__content">

        	<div class="MastheadNews__title">

            {!! $title !!}

            </div>

            <div class="MastheadNews__meta">

            {!! $meta !!}

        	</div>

        </div>   

    </div>

</div>
