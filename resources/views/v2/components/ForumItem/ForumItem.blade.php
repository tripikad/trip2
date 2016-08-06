@php

$route = $route ?? '';
$profile = $profile ?? '';
$title = $title ?? '';
$meta = $meta ?? collect();

@endphp

<a href="{{ $route }}">

<div class="ForumItem {{ $isclasses }}">

    <div class="ForumItem__left">

        {!! $profile !!}

    </div>

    <div class="ForumItem__right">

        <div>

            <div class="ForumItem__title">

                {{ $title }}

            </div>

            <div class="ForumItem__meta">

                {!! $meta !!}

            </div>

        </div>

    </div>

</div>

</a>