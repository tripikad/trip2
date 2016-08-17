@php

$route = $route ?? '';
$profile = $profile ?? '';
$title = $title ?? '';
$meta = $meta ?? collect();

@endphp

<div class="ForumRow {{ $isclasses }}">

    <div class="ForumRow__left">

        {!! $profile !!}

    </div>

    <div class="ForumRow__right">

        <div>

            <a href="{{ $route }}">

            <div class="ForumRow__title">

                {{ $title }}

            </div>

            <div class="ForumRow__meta">

                {!! $meta !!}
            
            </div>

            </a>

        </div>

    </div>

</div>