{{--

title: Forum list

code: |

    @include('component.content.forum.list', [
        'modifiers' => $modifiers,
        'items' => [
            [
                'topic' => 'This book is a record of a pleasure trip. If it were a record of a solemn scientific expedition',
                'route' => '#',
                'profile' => [
                    'modifiers' => 'm-mini',
                    'image' => \App\Image::getRandom(),
                    'route' => '#'
                ],
                'badge' => [
                    'modifiers' => 'm-inverted',
                    'count' => 9
                ],
                'tags' => [
                    [
                        'title' => 'Inglismaa',
                        'modifiers' => 'm-green',
                        'route' => ''
                    ]
                ]
            ]
        ]
    ])

modifiers:

- m-compact

--}}

<ul class="c-forum-list {{ $modifiers or '' }}">

	@foreach ($items as $item)

	<li class="c-forum-list__item">

        @if (isset($item['route']))

        <a href="{{ $item['route'] }}" class="c-forum-list__item-link">

        @else

        <div class="c-forum-list__item-content">

        @endif

    		@if (isset($item['profile']))

    		<div class="c-forum-list__item-profile">

    			@include('component.profile', [
    				'modifiers' => $item['profile']['modifiers'],
                    'route' => $item['profile']['route'],
                    'image' => $item['profile']['image'],
                    'badge' => $item['badge']
                ])

    		</div>

    		@endif

            <h3 class="c-forum-list__item-topic"><?php echo $item['topic']; ?></h3>

        @if (isset($item['route']))

        </a>

        @else

        </div>

        @endif

		@if (isset($item['tags']))

		<div class="c-forum-list__item-tags">

			@include('component.tags', [
				'items' => $item['tags']
            ])

		</div>

		@endif

	</li>

	@endforeach

</ul>