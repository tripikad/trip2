@php $isclasses = $isclasses ?? ''; $key = $key ?? ''; $value = $value ?? ''; @endphp

<div class="StyleColor {{ $isclasses }}">

    <div class="StyleColor__color" style="background: {{ $value }}">&nbsp;</div>

    <div>
        <div class="StyleColor__title">
            {{ $key }}
        </div>
        <div class="StyleColor__subtitle">
            {{ $value }}
        </div>
    </div>

</div>