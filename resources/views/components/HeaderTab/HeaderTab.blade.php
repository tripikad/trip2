@php
    $route = $route ?? '#';
    $active = $route ?? '';
    $title = $title ?? '';
    $count = $count ?? 0;
    $active = $active ? 'HeaderTab__active' : '';
@endphp

<a href="{{ $route }}" class="HeaderTab {{ $active }}">
    {{ $title }}
    <span class="HeaderTab__count">{{ $count }}</span>
</a>
