@php

$route = $route ?? '';
$title = $title ?? '';
$user = $user ?? '';
$meta = $meta ?? '';

@endphp

<div class="BlogCard {{ $isclasses }}">

	<a href="{{ $route }}" >

	    <div class="BlogCard__title">

	        {{ $title }}

	    </div>

    </a>

    <div class="BlogCard__user">

        {!! $user!!}

        <div class="BlogCard__meta">

        	{!! $meta !!}

    	</div>

    </div>

</div>
