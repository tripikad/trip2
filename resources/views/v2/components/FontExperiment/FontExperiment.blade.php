@php

$textSizes = array_reverse(['Xs','Sm','Md','Lg']);
$headingSizes = array_reverse(['Xs','Sm','Md','Lg','Xl','Xxl','Xxxl']);

@endphp

<div class="FontExperiment {{ $isclasses }}">

    @foreach ($headingSizes as $size)

    <div class="FontExperiment__heading FontExperiment__heading{{ $size }}">

        Kui Arno {{ $size }} <span class="FontExperiment__button">Isaga</span> koolimajja 


        @if ($loop->index > 1)
            
            jõudis, olid tunnid juba alanud. Arno roomas vargsi mööda klassitoa seinaäärt suure
            
        @endif

    </div>

    @endforeach

    @foreach ($textSizes as $size)
        
    <div class="FontExperiment__text FontExperiment__text{{ $size }}">

        Kui Arno <span class="FontExperiment__button">Isaga</span> koolimajja jõudis {{ $size }}

    </div>

    @endforeach

    @foreach ($textSizes as $size)

    <div class="FontExperiment__text FontExperiment__text{{ $size }}">

        Kui Arno {{ $size }} <span class="FontExperiment__button">Isaga</span> koolimajja jõudis, olid tunnid juba alanud. Arno roomas vargsi mööda klassitoa seinaäärt suure kapi juurde, kus õpetaja Laur maakaarte ja muid koolitarbeid hoidis ning puges kapi alla peitu. Seal oli kitsas ja pime.<br>Kapi alla oli ennast peitnud teisigi hilinejaid: Toots, Tõnisson, Imelik ja veel mõni, keda Arno pimedas ära ei tundnud. 

    </div>

    @endforeach
    
</div>
