@php

$image = $image ?? '';
$value = $value ?? 0;

@endphp

<div class="ProfileImage {{ $isclasses }}">
    
    <img class="ProfileImage__image" src="{{ $image }}" />

    <div class="ProfileImage__arcValue">

        {!!
            component('Arc')
                ->with('startangle', 0) 
                ->with('endangle', $value) 
        !!}

    </div>

    <div class="ProfileImage__arcReminder">

        {!!
            component('Arc')
                ->with('startangle', $value) 
                ->with('endangle', 360) 
        !!}

    </div>

</div>