@php

$route = $route ?? '';
$image = $image ?? '';
$rank = $rank ?? 0;
$size = $size ?? 36;
$border = $border ?? 3;

@endphp

<div class="ProfileImage {{ $isclasses }}" style="width: {{ $size }}px; height: {{ $size }}px;">
    
    <a href="{{ $route }}">

    <img class="ProfileImage__image" src="{{ $image }}" style="padding: {{ $border / 2 }}px;"/>

    <div class="ProfileImage__arcRank">

        {!!
            component('Arc')
                ->with('startangle', 0) 
                ->with('endangle', $rank) 
                ->with('size', $size) 
                ->with('border', $border) 
        !!}

    </div>

    <div class="ProfileImage__arcReminder">

        {!!
            component('Arc')
                ->with('startangle', $rank) 
                ->with('endangle', 360) 
                ->with('size', $size) 
                ->with('border', $border)
        !!}

    </div>

    </a>

</div>