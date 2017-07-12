@php

$title = $title ?? '';
$name = $name ?? '';

@endphp

<div class="FormUpload {{ $isclasses }}">

    <label class="FormUpload__button">

        {{ $title }}

        <input class="FormUpload__input" type="file" name="{{ $name }}" />
    
    </label>

</div>
