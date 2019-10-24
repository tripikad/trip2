@php
    $tabs = $tabs ?? [];
@endphp

<ul class="HeaderTabs">
    @foreach ($tabs as $tab)
        <li class="HeaderTabs__item">
            {!! $tab !!}
        </li>
    @endforeach
</ul>
