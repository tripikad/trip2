{{--

title: Profile

code: |

    @include('component.profile', [
        'modifiers' => $modifiers,
        'route' => '#',
        'image' => \App\Image::getRandom(),
        'badge' => [
            'modifiers' => 'm-red m-inverted',
            'count' => '7'
        ],
        'status' => [
            'modifiers' => '',
            'position' => ''
        ]
    ])

modifiers:

- m-small
- m-mini
- m-micro
- m-full
- m-status

--}}

@if (isset($route) && $route != '')

<a class="c-profile {{ $modifiers or '' }}" href="{{ $route }}">

@else

<div class="c-profile {{ $modifiers or '' }}">

@endif

    @if(isset($status))

        <div class="c-profile__status {{ $status['modifiers'] or '' }}">

            @if(isset($status['position']))

                @if($status['position'] == 1)

                    <div class="c-profile__status-pie m-25">
                        <span class="c-profile__status-pie-inner"></span>
                    </div>

                    <div class="c-profile__status-title">

                        @include('component.tooltip', [
                            'text' => 'Amatöör',
                            'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                        ])
                    </div>

                @elseif($status['position'] == 2)

                    <div class="c-profile__status-pie m-50">
                        <span class="c-profile__status-pie-inner"></span>
                    </div>

                    <div class="c-profile__status-title">

                        @include('component.tooltip', [
                            'text' => 'Edasijõudnud',
                            'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                        ])
                    </div>

                @elseif($status['position'] == 3)

                    <div class="c-profile__status-pie m-75">
                        <span class="c-profile__status-pie-inner"></span>
                    </div>

                    <div class="c-profile__status-title">

                        @include('component.tooltip', [
                            'text' => 'Tripikas',
                            'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                        ])
                    </div>

                @else

                    <div class="c-profile__status-pie m-100">
                        <span class="c-profile__status-pie-inner"></span>
                    </div>

                    <div class="c-profile__status-title">

                        @include('component.tooltip', [
                            'text' => 'Guru',
                            'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                        ])
                    </div>

                @endif

            @endif

        </div>

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

@if (isset($route) && $route != '')

</a>

@else

</div>

@endif