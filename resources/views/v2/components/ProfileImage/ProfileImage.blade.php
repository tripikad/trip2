@php

$route = $route ?? 0;
$image = $image ?? '';
$rank = $rank ?? 0;

@endphp

<div class="ProfileImage {{ $isclasses }}">
    
    <a href="{{ $route }}">

    <img class="ProfileImage__image" src="{{ $image }}" />

    <div class="ProfileImage__arcRank">

        {!!
            component('Arc')
                ->with('startangle', 0) 
                ->with('endangle', $rank) 
        !!}

    </div>

    <div class="ProfileImage__arcReminder">

        {!!
            component('Arc')
                ->with('startangle', $rank) 
                ->with('endangle', 360) 
        !!}

    </div>

    </a>

</div>