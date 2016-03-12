{{--

title: Blog sponsored posts

code: |

    @include('component.blog.sponsored', [
        'title' => 'Title',
        'route' => '#',
        'image' => \App\Image::getRandom()
    ])

--}}

<div class="c-blog-sponsored">
    <a href="{{ $route }}" class="c-blog-sponsored__image-link" style="background-image: url({{ $image }});"></a>
    <div class="c-blog-sponsored__content">
        <h3 class="c-blog-sponsored__title">
            <a href="{{ $route }}" class="c-blog-sponsored__title-link">{{ $title }}</a>
        </h3>
    </div>
</div>