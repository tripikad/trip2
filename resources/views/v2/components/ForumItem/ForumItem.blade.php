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

                @foreach ($meta as $meta_item)

                {!! $meta_item !!}

                @endforeach
            
            </div>

            </a>

        </div>

    </div>

</div>