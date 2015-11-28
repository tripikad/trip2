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
        ],
        'more_count' => '120',
        'more_route' => '#'
    ])

--}}


<div class="c-gallery m-8-cols">

    <ul class="c-gallery__list">

        @foreach ($items as $item)

            <li class="c-gallery__list-item">

                @if (isset($item['route']))

                    <a href="{{ $item['route'] }}" class="c-gallery__list-item-link">

                @endif

                    <img src="{{ $item['image'] }}" alt="{{ $item['alt'] or '' }}" class="c-gallery__list-item-image">

                @if (isset($item['route']))

                    </a>

                @endif

                @if ($item == end($items) || (method_exists($items, 'last') && $item == $items->last()))

                    @if (isset($more_count) && isset($more_route))

                        <a href="{{ $more_route }}" class="c-gallery__more">
                            <span>+ {{ $more_count }}</span>
                        </a>

                    @endif

                @endif
            </li>

        @endforeach

    </ul>
</div>
