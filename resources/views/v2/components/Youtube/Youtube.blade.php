@php

$id = $id ?? '';

@endphp

<div class="Youtube">
    <iframe
        class="Youtube__iframe"
        src="//www.youtube.com/embed/{{$id}}"
        frameborder='0'
        allowfullscreen
    ></iframe>
</div>