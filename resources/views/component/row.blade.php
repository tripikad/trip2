<?php /*

title: Row

description: Row is meant for complex listings and content headers

code: |

    #include('component.row', [
        'modifiers' => $modifiers,
        'icon' => 'icon-offer',
        'profile' => [
            'modifiers' => '',
            'image' => \App\Image::getRandom(),
            'route' => '',
        ],
        'preheading' => 'Preheading',
        'title' => '',
        'route' => '',
        'postheading' => 'Postheading',
        'actions' => view('component.actions', [
            'actions' => [
                ['route' => '', 'title' => 'This is first action'],
                ['route' => '', 'title' => 'This is second action'],
            ]
        ]),
        'text' => '',
        'extra' => 'Extra',
        'body' => 'This book is a record of a pleasure trip. If it were a record of a solemn scientific expedition...',
    ])

modifiers:

- m-icon
- m-profile
- m-red
- m-blue
- m-green
- m-orange
- m-yellow
- m-purple

*/ ?>

<article class="c-row {{ $modifiers or '' }}">
    @if (isset($icon) && !isset($profile))
        <div class="c-row__icon">
            @include('component.svg.sprite', [
                'name' => $icon
            ])
        </div>
    @endif

    @if (isset($profile) && !isset($icon))
        <div class="c-row__image">
            @include('component.profile', [
                'modifiers' => $profile['modifiers'],
                'route' => $profile['route'],
                'image' => $profile['image'],
                'title' => ''
            ])
        </div>
    @endif

    @if (isset($title))
        <h3 class="c-row__title">
            @if (isset($preheading))
                <span>{!! $preheading !!}</span>
            @endif

            @if (isset($route))
                <a href="{{ $route }}" class="c-row__title-link">
            @endif

            {{ ($title != '' ? $title : '&nbsp;') }}

            @if (isset($route))
                </a>
            @endif

            @if (isset( $postheading ))
                <span>{!! $postheading !!}</span>
            @endif
        </h3>
    @endif

    @if (isset($text) || isset($extra) || isset($list) || isset($badge))
        <div class="c-row__text">
            {!! $text or '' !!}

            {!! $extra or '' !!}

            @if(isset($list))
                <div class="c-row__list">
                    @include('component.inline_list', [
                        'items' => $list
                    ])
                </div>
            @endif

            @if(isset($badge))
                <div class="c-row__badge">
                    @include('component.badge', [
                        'modifiers' => 'm-green m-inverted',
                        'title' => $badge
                    ])
                </div>
            @endif
        </div>
    @endif

    @if (isset($actions))
        <div class="c-row__actions">{!! $actions !!}</div>
    @endif

    @if (isset($body) && is_string($body))
        <div class="c-row__body">{!! $body !!}</div>
    @elseif (isset($body) && count($body) && isset($body['modifiers']) && isset($body['text']))
        <div class="c-row__body {{ $body['modifiers'] or '' }}">{!! $body['text'] !!}</div>
    @endif
</article>
