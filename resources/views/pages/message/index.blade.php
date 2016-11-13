@extends('layouts.one_column')

@section('title', trans('message.index.title', ['user' => $user->name]))

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
                                'route' => ($user->name != 'Tripi külastaja' ? route('user.show', [$user]) : false),
                            ])
                        ],
                        [
                            'modifiers' => 'm-green',
                            'button' => view('component.button',[
                                'modifiers' => 'm-small m-border',
                                'title' => trans('menu.user.message'),
                                'route' => ($user->name != 'Tripi külastaja' ? route('message.index', [$user]) : false),
                            ])
                        ],
                        [
                            'modifiers' => 'm-green',
                            'button' => view('component.button',[
                                'modifiers' => 'm-small',
                                'title' => trans('menu.user.follow'),
                                'route' => ($user->name != 'Tripi külastaja' ? route('follow.index', [$user]) : false),
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

    @if (count($user->messages()))

        @foreach ($user->messages() as $message)

            @include('component.row', [
                'profile' => [
                    'modifiers' => 'm-small',
                    'image' => $message->withUser->imagePreset(),
                    'route' => ($message->withUser->name != 'Tripi külastaja' ? route('user.show', [$message->withUser]) : false),
                ],
                'title' => $message->title,
                'route' => route('message.index.with', [$user, $message->withUser]),
                'text' => trans('message.index.row.description', [
                    'user' => view('component.user.link', ['user' => $message->withUser]),
                    'created_at' => view('component.date.long', ['date' => $message->created_at])
                ]),
                'modifiers' => 'm-image ' . ($message->read ? 'm-blue' : 'm-green')
            ])

        @endforeach

    @endif

@stop
