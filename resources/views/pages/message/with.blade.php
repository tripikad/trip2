@extends('layouts.one_column')

@section('title', trans('message.index.with.title', ['user' => $user->name, 'user_with' => $user_with->name]))

@section('header2.content')

    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

    <div class="r-user m-green">
        <div class="r-user__admin">
            <div class="r-user__admin-wrap">

                @include('component.button.group',[
                    'items' => [
                        [
                            'modifiers' => 'm-green',
                            'button' => view('component.button',[
                                'modifiers' => 'm-small',
                                'title' => trans('menu.user.activity'),
                                'route' => route('user.show', [$user]),
                            ])
                        ],
                        [
                            'modifiers' => 'm-green',
                            'button' => view('component.button',[
                                'modifiers' => 'm-small m-border',
                                'title' => trans('menu.user.message'),
                                'route' => route('message.index', [$user]),
                            ])
                        ],
                        [
                            'modifiers' => 'm-green',
                            'button' => view('component.button',[
                                'modifiers' => 'm-small',
                                'title' => trans('menu.user.follow'),
                                'route' => route('follow.index', [$user]),
                            ])
                        ],
                    ]
                ])

            </div>
        </div>
    </div>

    @endif

@stop

@section('content.one')

@if (count($messages))

    @include('component.list', [
        'modifiers' => 'm-dark',
        'items' => $messages->transform(function ($message) {
            return [
                'id' => 'message-' . $message->id,
                'modifiers' => ($message->read ? 'm-blue' : 'm-red'),
                'title' => trans('message.index.with.row.description', [
                    'user' => $message->fromUser->name,
                    'created_at' => view('component.date.long', ['date' => $message->created_at])
                ]),
                'text' => nl2br($message->body_filtered),
                'profile' => [
                    'modifiers' => 'm-small',
                    'image' => $message->fromUser->imagePreset(),
                    'route' => ''
                ]
            ];
        })
    ])

@endif

    @include('component.message.create', [
        'user_from' => $user,
        'user_to' => $user_with
    ])

@stop
