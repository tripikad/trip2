<div class="c-blog {{ $modifiers or '' }}">
    @if (isset($image) && $image)
        <a href="{{ $route }}" class="c-blog__image" style="background-image: url({{ $image }});"></a>
    @endif
    <h3 class="c-blog__title"><a href="{{ $route }}" class="c-blog__title-link">{{ $title }}</a></h3>

    @if (isset($profile))

    <div class="c-blog__profile">

        @include('component.profile', [
            'modifiers' => 'm-small m-center',
            'title' => $profile['title'],
            'image' => $profile['image'],
            'route' => $profile['route']
        ])

    </div>

    @endif
</div>