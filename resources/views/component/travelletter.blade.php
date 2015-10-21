<div class="c-travel-letter">

    <div class="c-travel-letter__image-wrap">

        <a href="{{ $route }}" class="c-travel-letter__image-link">
            <img src="{{ $image }}" alt="" class="c-travel-letter__image">
        </a>

    </div>

    <h3 class="c-travel-letter__title"><a href="{{ $route }}" class="c-travel-letter__title-link">{{ $title }}</a></h3>

    @if (isset($profile))

    <div class="c-travel-letter__profile">

        @include('component.profile', [
            'modifiers' => 'm-small m-center',
            'title' => $profile['title'],
            'image' => $profile['image'],
            'route' => $profile['route']
        ])

    </div>

    @endif
</div>