@php

$background = $background ?? '';
$header = $header ?? '';
$title = $title ?? '';
$meta = $meta ?? '';

@endphp

<div class="MastHeadNews {{ $isclasses }}" 
	style="background-image: linear-gradient(
      rgba(0, 0, 0, 0.1),
      rgba(0, 0, 0, 0.3)
    ), url({{ $background }});">

    <div class="MastHeadNews__header">

    	<div class="container">

        	{!! $header !!}
        	
        </div>

    </div>

    <div class="MastHeadNews__body">

    	<div class="MastHeadNews__title">

        {{ $title }}

        </div>

        <div class="MastHeadNews__meta">

        {{ $meta }}

    	</div>

    </div>   

</div>
