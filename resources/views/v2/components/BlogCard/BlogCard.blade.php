@php

$route = $route ?? '';
$title = $title ?? '';
$profile = $profile ?? '';
$meta = $meta ?? '';

@endphp

<div class="BlogCard {{ $isclasses }}">

    <a class="BlogCard__title" href="{{ $route }}" >

        {{ $title }}

    </a>

    <div class="BlogCard__profile">

        {!! $profile!!}

        <div class="BlogCard__meta">

        	{!! $meta !!}

    	</div>

    </div>

</div>
