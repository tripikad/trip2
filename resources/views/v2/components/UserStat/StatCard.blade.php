@php

$icon = $icon ?? '';
$title = $title ?? '';

@endphp

<div class="StatCard {{ $isclasses }}">

    <div class="StatCard__icon">

        {!! component('Icon')->is('white')->with('size', 'xl')->with('icon', $icon) !!}

    </div>

    <div class="StatCard__title">

        {{ $title }}

    </div>

</div>
