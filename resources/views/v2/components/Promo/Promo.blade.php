@php

$promo = $promo ?? '';
$config = config("promo.$promo");
$ratio = round(($config['height'] / $config['width']) * 100);

@endphp

<div class="Promo {{ $isclasses }}" style="padding-bottom: {{ $ratio }}%;">
    
    <iframe
        class="Promo__iframe"
        src="/photos/social.jpg"
        frameborder="0"
        scrolling="no"
    ></iframe>

</div>
