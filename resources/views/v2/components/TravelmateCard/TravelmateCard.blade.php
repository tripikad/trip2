@php

$title = $title ?? '';
$ProfileImage = $ProfileImage ?? '';
$route = $route ?? '';
$user = $user ?? '';

@endphp

<div class="TravelmateCard {{ $isclasses }}">

	<div class="TravelmateCard__image">

        {!! $ProfileImage !!}


    </div>

    <a href="#" class="TravelmateCard__info" >

    	<div class="TravelmateCard__user" >

	        {!! $user !!}

	    </div>

	    <div  class="TravelmateCard__title">

	        {{ $title }}

	    </div>

	    <div class="TravelmateCard__tags">

	        {!! $meta !!}

	    </div>

    </a>

</div>
