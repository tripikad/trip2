{{--

title: Gallery component

code: |

    @include('component.gallery', [
        'items' => [
            [
                'image' => \App\Image::getRandom(),
                'route' => '#',
                'alt' => 'Pilt 1'
            ],
            [
                'image' => \App\Image::getRandom(),
                'route' => '#',
                'alt' => 'Pilt 2'
            ],
            [
                'image' => \App\Image::getRandom(),
                'route' => '#',
                'alt' => 'Pilt 3'
            ],
            [
                'image' => \App\Image::getRandom(),
                'route' => '#',
                'alt' => 'Pilt 4'
            ],
            [
                'image' => \App\Image::getRandom(),
                'route' => '#',
                'alt' => 'Pilt 5'
            ],
            [
                'image' => \App\Image::getRandom(),
                'route' => '#',
                'alt' => 'Pilt 6'
            ],
            [
                'image' => \App\Image::getRandom(),
                'route' => '#',
                'alt' => 'Pilt 7'
            ],
            [
                'image' => \App\Image::getRandom(),
                'route' => '#',
                'alt' => 'Pilt 8'
            ]
        ]
    ])

--}}


<div class="c-gallery">

    <ul class="c-gallery__list m-8-cols">

        @foreach ($items as $item)

        <li class="c-gallery__list-item">
            <a href="{{ $item['route'] }}" class="c-gallery__list-item-link">
                <img src="{{ $item['image'] }}" alt="{{ $item['alt'] or '' }}" class="c-gallery__list-item-image">
            </a>
        </li>

        @endforeach

    </ul>
</div>