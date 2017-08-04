@php

$id = $id ?? '';

@endphp

<div class="Youtube">

    <iframe
        class="Youtube__iframe"
        src="//www.youtube.com/embed/{{$id}}?rel=0"
        frameborder="0"
        allowfullscreen
    ></iframe>

</div>
