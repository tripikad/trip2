@php

$route = $route ?? '';
$title = $title ?? '';
$profile = $profile ?? '';
$meta = $meta ?? '';

@endphp

<div class="BlogCard {{ $isclasses }}">

	<a href="{{ $route }}" >

	    <div class="BlogCard__title">

	        {{ $title }}

	    </div>

    </a>

    <div class="BlogCard__profile">

        {!! $profile!!}

        <div class="BlogCard__meta">

        	{!! $meta !!}

    	</div>

    </div>

</div>
