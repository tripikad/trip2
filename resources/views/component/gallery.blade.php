<?php /*

title: Gallery component

code: |

    #include('component.gallery', [
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

*/ ?>

<?php
    $tags = [];
    $i = 0;
?>

@if (isset($columns))

<div class="c-gallery m-{{$columns}}-cols">

@else

<div class="c-gallery m-8-cols">

@endif

    <ul class="c-gallery__list">

        @foreach ($items as $item)

        <?php $images[$i]['image'] = (isset($item['image_large']) ? $item['image_large'] : $item['image']); ?>

        @if (isset($item['tags']))

        <?php $j = 0; ?>
            @foreach ($item['tags'] as $tag)
        <?php
            $images[$i]['tags'][$j]['name'] = $tag['title'];
            $images[$i]['tags'][$j]['modifiers'] = $tag['modifiers'];
            $images[$i]['tags'][$j]['route'] = $tag['route'];

            $j++;
        ?>

            @endforeach

        @endif

        @if (isset($item['alt']))

        <?php $images[$i]['title'] = $item['alt']; ?>

        @endif

        <?php $images[$i]['userName'] = (isset($item['userName']) ? $item['userName'] : ''); ?>

        <?php $images[$i]['userRoute'] = (isset($item['userRoute']) ? $item['userRoute']: ''); ?>

        @if (isset($modal))

            <li class="c-gallery__list-item js-gallery-modal-trigger">

        @else

            <li class="c-gallery__list-item">

        @endif

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


            <?php $i++; ?>

        @endforeach
    </ul>

    @if (isset($modal))

    <div class="c-gallery__modal js-gallery-modal {{ $modal['modifiers'] or '' }}" data-images='<?php  echo json_encode($images, JSON_HEX_APOS); ?>'>
        <a href="#" class="c-gallery__modal-close js-gallery-modal-close">
            @include('component.svg.sprite', [
                'name' => 'icon-plus'
            ])
        </a>
        <div class="c-gallery__modal-inner">

            <div class="c-gallery__modal-image-container js-gallery-modal-images">
                <a href="#" class="c-gallery__modal-nav m-previous js-gallery-modal-previous">
                    @include('component.svg.sprite', [
                        'name' => 'icon-arrow-left'
                    ])
                </a>

                <a href="#" class="c-gallery__modal-nav m-next js-gallery-modal-next">
                    @include('component.svg.sprite', [
                        'name' => 'icon-arrow-right'
                    ])
                </a>
            </div>

            <div class="c-gallery__modal-thumb-container">

                <div class="c-gallery__modal-thumb-container-inner js-gallery-modal-thumbs"></div>

            </div>
        </div>
    </div>

    @endif

</div>
































