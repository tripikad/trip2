@php

$svg = is_file(public_path(dist('svg'))) ? file_get_contents(public_path(dist('svg'))) : ''

@endphp

<div style="display: none;">

    {!! $svg !!}

</div>