@php

$image = $image ?? '';
$route = $route ?? '';
$name = $name ?? '';
$meta = $meta ?? '';

@endphp

<h3 class="UserCard {{ $isclasses }}">

    <div class="UserCard__image">

        {!! $image !!}

    </div>

    <div class="UserCard__right">

    	<a href="{{ $route }}">

    		<div class="UserCard__name">

		        {!! $name !!}

		    </div>

    	</a>

     	<div class="UserCard__meta">

	        {!! $meta !!}

	    </div>

	</div>

</h3>
