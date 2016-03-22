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
    <a href="{{ $route }}" class="c-news__image-wrap" style="background-image: url({{ $image }});"></a>
    <div class="c-news__content">
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
</div>