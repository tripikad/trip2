@php

$title = $title ?? '';
$name = $name ?? '';

@endphp

<div class="FormFile {{ $isclasses }}">

    <label class="FormFile__button">

        {{ $title }}

        <input class="FormFile__input" type="file" name="{{ $name }}" />
    
    </label>

</div>
