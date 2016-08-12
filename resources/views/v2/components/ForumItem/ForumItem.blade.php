@php

$route = $route ?? '';
$profile = $profile ?? '';
$title = $title ?? '';
$meta = $meta ?? collect();

@endphp

<div class="ForumItem {{ $isclasses }}">

    <div class="ForumItem__left">

        {!! $profile !!}

    </div>

    <div class="ForumItem__right">

        <div>

            <a href="{{ $route }}">

            <div class="ForumItem__title">

                {{ $title }}

            </div>

            <div class="ForumItem__meta">

                {!! $meta !!}
            
            </div>

            </a>

        </div>

    </div>

</div>