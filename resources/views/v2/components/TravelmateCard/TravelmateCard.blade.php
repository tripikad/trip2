@php

$title = $title ?? '';
$user = $user ?? '';
$route = $route ?? '';
$meta_top = $meta_top ?? '';
$meta_bottom = $meta_bottom ?? '';

@endphp

<div class="TravelmateCard {{ $isclasses }}">

	<div class="TravelmateCard__user">

        {!! $user !!}

    </div>

    <div class="TravelmateCard__content">

    	<div class="TravelmateCard__metaTop" >

	        {!! $meta_top !!}

	    </div>

        <a href="{{ $route }}">

	    <div  class="TravelmateCard__title">

	        {{ $title }}

	    </div>

        </a>

	    <div class="TravelmateCard__metaBottom">

	        {!! $meta_bottom !!}

	    </div>

    </div>

</div>
