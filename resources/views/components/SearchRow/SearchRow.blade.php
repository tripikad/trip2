@php
    $route = $route ?? '#';
    $title = $title ?? '';
    $date = $date ?? '';
    $badge = (isset($badge) ? (string) $badge : '');
    $body = $body ?? '';
    $image = $image ?? '';
    $image_alt = $image_alt ?? '';
    $image_title = $image_title ?? '';
    $arc = $arc ?? '';
@endphp

<a href="{{ $route }}" class="SearchRow">
    <span class="SearchRow__header">
        @if (! $body)
            @if ($arc)
                <div class="SearchRow__image">
                    {!! $arc !!}
                </div>
            @elseif ($image)
                <img src="{{ $image }}" class="SearchRow__image" alt="{{ $image_title }}">
            @elseif ($image_alt)
                <img src="{{ $image_alt }}" class="SearchRow__image_alt" alt="{{ $image_title }}">
            @endif
        @endif

        <h3 class="SearchRow__title">{{ $title }}</h3>
        @if ($badge != '')
            <span class="SearchRow__badge">{{ $badge }}</span>
        @endif

        @if ($date)
            <time datetime="{{ $date }}" class="SearchRow__date">{{ $date }}</time>
        @endif
    </span>

    @if ($body && ($image || $image_alt || $arc))
        <span class="SearchRow__main">
            @if ($arc)
                <div class="SearchRow__image">
                    {!! $arc !!}
                </div>
            @elseif ($image)
                <img src="{{ $image }}" class="SearchRow__image" alt="{{ $image_title }}">
            @elseif ($image_alt)
                <img src="{{ $image_alt }}" class="SearchRow__image_alt" alt="{{ $image_title }}">
            @endif

            @if ($body)
                <p class="SearchRow__body">{{ $body }}</p>
            @endif
        </span>
    @endif
</a>