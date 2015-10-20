{{--

description: News block

code: |

    @include('component.news', [
        'modifiers' => $options,
        'route' => '#',
        'title' => 'News title',
        'date' => '12. october',
        'image' => \App\Image::getRandom()
    ])

options:

- m-small

--}}

<div class="c-news {{ $modifiers or '' }}">
    <a href="{{ $route }}" class="c-news__image-wrap">
        <img src="{{ $image }}" alt="" class="c-news__image">
    </a>
    <h3 class="c-news__title">
        <a href="{{ $route }}" class="c-news__title-link">{{ $title }}</a>
    </h3>
    <div class="c-news__meta">
        <p class="c-news__meta-date">{{ $date }}</p>
    </div>
</div>