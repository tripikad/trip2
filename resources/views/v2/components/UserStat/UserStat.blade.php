@php

$icon = $icon ?? '';
$title = $title ?? '';

@endphp

<div class="UserStat {{ $isclasses }}">

    <div class="UserStat__icon">

        {!! component('Icon')->is('white')->with('size', 'xl')->with('icon', $icon) !!}

    </div>

    <div class="UserStat__title">

        {{ $title }}

    </div>

</div>
