<?php
/*

title: Profile

code: |

    #include('component.profile', [
        'modifiers' => $modifiers,
        'route' => '#',
        'image' => \App\Image::getRandom(),
        'title' => 'Kasutajanimi',
        'badge' => [
            'modifiers' => 'm-red m-inverted',
            'count' => '7'
        ],
        'status' => [
            'modifiers' => '',
            'position' => ''
        ],
        'editor' => [
            'modifiers' => ''
        ]
    ])

modifiers:

- m-small
- m-mini
- m-micro
- m-full
- m-status
*/
?>

@if (isset($route) && $route != '')
    <a class="c-profile {{ $modifiers or '' }}" href="{{ $route }}">
@else
    <div class="c-profile {{ $modifiers or '' }}">
@endif

@if(isset($status))

    @if(isset($status['editor']))
        <div class="c-profile__bubble {{ $status['modifiers'] or '' }}">
            @include('component.svg.sprite', [
                'name' => 'icon-star-filled'
            ])
        </div>
    @endif

    <div class="c-profile__status {{ $status['modifiers'] or '' }}">
        @if(isset($status['position']))
            @if($status['position'] == 1)
                <div class="c-profile__status-pie m-25">
                    <span class="c-profile__status-pie-inner"></span>
                </div>

                @if(!isset($status['tooltip']))
                    <div class="c-profile__status-title">
                        @if(isset($status['editor']))
                            @include('component.tooltip', [
                                'text' => 'Uus kasutaja / Toimetaja',
                                'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                            ])
                        @else
                            @include('component.tooltip', [
                                'text' => 'Uus kasutaja',
                                'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                            ])
                        @endif
                    </div>
                @endif
            @elseif($status['position'] == 2)
                <div class="c-profile__status-pie m-50">
                    <span class="c-profile__status-pie-inner"></span>
                </div>

                @if(!isset($status['tooltip']))
                    <div class="c-profile__status-title">
                        @if(isset($status['editor']))
                            @include('component.tooltip', [
                                'text' => 'Tripikas / Toimetaja',
                                'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                            ])
                        @else
                            @include('component.tooltip', [
                                'text' => 'Tripikas',
                                'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                            ])
                        @endif
                    </div>
                @endif
            @elseif($status['position'] == 3)
                <div class="c-profile__status-pie m-75">
                    <span class="c-profile__status-pie-inner"></span>
                </div>

                @if(!isset($status['tooltip']))
                    <div class="c-profile__status-title">
                        @if(isset($status['editor']))
                            @include('component.tooltip', [
                                'text' => 'Kogenud tripikas / Toimetaja',
                                'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                            ])
                        @else
                            @include('component.tooltip', [
                                'text' => 'Kogenud tripikas',
                                'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                            ])
                        @endif
                    </div>

                @endif
            @else
                <div class="c-profile__status-pie m-100">
                    <span class="c-profile__status-pie-inner"></span>
                </div>
                @if(!isset($status['tooltip']))
                    <div class="c-profile__status-title">
                        @if(isset($status['editor']))
                            @include('component.tooltip', [
                                'text' => 'Guru / Toimetaja',
                                'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                            ])
                        @else
                            @include('component.tooltip', [
                                'text' => 'Guru',
                                'modifiers' => 'm-bottom m-inverted-light m-center m-one-line '. $status['modifiers'],
                            ])
                        @endif
                    </div>
                @endif
            @endif
        @endif
    </div>
@endif

<div class="c-profile__image-wrap">
    @if (isset($image))
        @if ($image != '')

            <img src="{{ $image }}" alt="" class="c-profile__image">
        @else
            @if (isset($letter))
                <div class="c-profile__letter {{ $letter['modifiers'] }}"><span>{{ $letter['text'] }}</span></div>
            @endif
        @endif
    @else
        @if (isset($letter))
            <div class="c-profile__letter {{ $letter['modifiers'] }}"><span>{{ $letter['text'] }}</span></div>
        @endif
    @endif

    @if (isset($badge))
        <div class="c-profile__badge">
			@include('component.badge', [
				'modifiers' => $badge['modifiers'],
				'count' => $badge['count'],
            ])
        </div>
	@endif

    @if (isset($title) && $title)
        <span class="c-profile__title">{{ $title }}</span>
    @endif
</div>

@if (isset($route) && $route != '')
    </a>
@else
    </div>
@endif
