@php

$profile = $profile ?? '';

@endphp

<div class="UserCard {{ $isclasses }}">

    <div class="UserCard__profile">

        {!! $profile !!}

    </div>

    <div class="UserCard__meta">

        {!! $meta !!}

    </div>
</div>
