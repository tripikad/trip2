@php

$profile = $profile ?? '';
$route = $route ?? '';
$title = $title ?? '';
$time = $time ?? '';

@endphp



    <div class="ForumItemSmall {{ $isclasses }}">

        </div>

        <a href="{!! $route !!}">

            <div class="ForumItemSmall__info">

        	    <div class="ForumItemSmall__title">

        	        {{ $title }}

        	    </div>



            </div>

        </a>

    </div>

