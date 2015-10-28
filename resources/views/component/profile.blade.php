{{--

title: Profile

code: |

    @include('component.profile', [
        'modifiers' => $modifiers,
        'route' => '#',
        'title' => 'Name Lastname',
        'age' => 22,
        'image' => \App\Image::getRandom(),
        'interests' => 'Itaalia',
        'badge' => [
            'modifiers' => 'm-red m-inverted',
            'count' => '7'
        ]
    ])

modifiers:

- m-small
- m-mini
- m-micro

--}}

@if (isset($route))

<a class="c-profile {{ $modifiers or '' }}" href="{{ $route }}">

@else

<div class="c-profile {{ $modifiers or '' }}">

@endif

    <div class="c-profile__image-wrap">

        <img src="{{ $image }}" alt="" class="c-profile__image">

        @if (isset($badge))

        <div class="c-profile__badge">

			@include('component.badge', [
				'modifiers' => $badge['modifiers'],
				'count' => $badge['count'],
            ])

        </div>

		@endif

    </div>

    @if (isset($title))

    <div class="c-profile__info">

        <h3 class="c-profile__title">
        	{{ $title }}
			@if (isset($age))
				<span>({{ $age }})</span>
			@endif
        </h3>

        @if (isset($interests))

        <p class="c-profile__interests">{{ $interests }}</p>

        @endif
    </div>

     @endif

@if (isset($route))

</a>

@else

</div>

@endif