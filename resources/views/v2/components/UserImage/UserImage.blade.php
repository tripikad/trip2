@php

$route = $route ?? '';
$image = $image ?? '';
$rank = $rank ?? 0;
$size = $size ?? 36;
$border = $border ?? 3;

@endphp

<div class="UserImage {{ $isclasses }}" style="width: {{ $size }}px; height: {{ $size }}px;">
    
    <a href="{{ $route }}">

    <img class="UserImage__image" src="{{ $image }}" style="padding: {{ $border / 2 }}px;"/>

    <div class="UserImage__arcRank">

        {!!
            component('Arc')
                ->with('startangle', 0) 
                ->with('endangle', $rank) 
                ->with('size', $size) 
                ->with('border', $border) 
        !!}

    </div>

    <div class="UserImage__arcReminder">

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