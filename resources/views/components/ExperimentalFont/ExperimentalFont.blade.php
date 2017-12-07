@php

$textSizes = array_reverse(['xs','sm','md','lg']);
$headingSizes = array_reverse(['xs','sm','md','lg','xl','xxl','xxxl']);

@endphp

<div class="ExperimentalFont {{ $isclasses }}">

    @foreach ($headingSizes as $size)

    <div class="ExperimentalFont__label">$font-heading-{{ $size }}</div>

    <div class="ExperimentalFont__heading ExperimentalFont__heading{{ $size }}">

        Kui Arno <span class="ExperimentalFont__button">Isaga</span> koolimajja 


        @if ($loop->index > 1)
            
            jõudis, olid tunnid juba alanud. Arno roomas vargsi mööda klassitoa seinaäärt suure
            
        @endif

    </div>

    @endforeach

    @foreach ($textSizes as $size)
        
    <div class="ExperimentalFont__label">$font-text-{{ $size }}</div>

    <div class="ExperimentalFont__text ExperimentalFont__text{{ $size }}">

        Kui Arno <span class="ExperimentalFont__button">Isaga</span> koolimajja jõudis {{ $size }}

    </div>

    @endforeach

    @foreach ($textSizes as $size)

    <div class="ExperimentalFont__label">$font-text-{{ $size }}</div>

    <div class="ExperimentalFont__text ExperimentalFont__text{{ $size }}">

        Kui Arno {{ $size }} <span class="ExperimentalFont__button">Isaga</span> koolimajja jõudis, olid tunnid juba alanud. Arno roomas vargsi mööda klassitoa seinaäärt suure kapi juurde, kus õpetaja Laur maakaarte ja muid koolitarbeid hoidis ning puges kapi alla peitu. Seal oli kitsas ja pime.<br>Kapi alla oli ennast peitnud teisigi hilinejaid: Toots, Tõnisson, Imelik ja veel mõni, keda Arno pimedas ära ei tundnud. 

    </div>

    @endforeach
    
</div>
