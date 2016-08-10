@php

$id = $id ?? 0;
$profile = $profile ?? '';
$meta = $meta ?? collect();
$body = $body ?? '';

@endphp

<a id="comment-{{ $id }}">

<div class="Comment {{ $isclasses }}">

    <div class="Comment__left">

        {!! $profile !!}

    </div>

    <div class="Comment__right">

        <div class="Comment__meta">

        @foreach ($meta as $meta_item)

            {!! $meta_item !!}

        @endforeach

        </div>

        <div class="Comment__body">

            {!! $body !!}

        </div>

    </div>

</div>

</a>