@php

$name = $name ?? '';

@endphp

<div class="FormUpload {{ $isclasses }}">

    <input type="file" name="{{ $name }}" />
    
</div>
