@php
    $items = $items ?? collect();
@endphp

<div class="Search">
    @foreach ($items as $item)

        {!! $item !!}

    @endforeach
</div>
