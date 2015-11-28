{{--

title: News

code: |

    @include('component.news', [
        'modifiers' => $modifiers,
        'route' => '',
        'title' => 'News title',
        'date' => 'today',
        'image' => \App\Image::getRandom()
    ])

modifiers:

- m-small
- m-smaller

--}}

<div class="c-news {{ $modifiers or '' }}">
    <a href="{{ $route }}" class="c-news__image-wrap">
        <img src="{{ $image }}" alt="" class="c-news__image">
    </a>
    <h3 class="c-news__title">
        <a href="{{ $route }}" class="c-news__title-link">{{ $title }}</a>
    </h3>
    @if(isset($date))
    <div class="c-news__meta">
        <p class="c-news__meta-date">
            @include('component.date.relative', ['date' => $date])
        </p>
    </div>
    @endif
</div>