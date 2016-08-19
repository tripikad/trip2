@php

$title = $title ?? '';
$profile = $profile ?? '';
$route = $route ?? '';
$username = $username ?? '';
$meta = $meta ?? '';

@endphp

<div class="TravelmateCard {{ $isclasses }}">

	<div class="TravelmateCard__image">

        {!! $profile !!}


    </div>

    <a href="{{ $route }}" class="TravelmateCard__info" >

    	<div class="TravelmateCard__user" >

	        {!! $username !!}

	    </div>

	    <div  class="TravelmateCard__title">

	        {{ $title }}

	    </div>

	    <div class="TravelmateCard__meta">

	        {!! $meta_bottom !!}

	    </div>

    </a>

</div>
