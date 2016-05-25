@extends('layouts.one_column')

@section('title', trans('follow.index.title', ['user' => $user->name]))

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
                                'modifiers' => 'm-small',
                                'title' => trans('menu.user.message'),
                                'route' => route('message.index', [$user]),
                            ])
                        ],
                        [
                            'modifiers' => 'm-green',
                            'button' => view('component.button',[
                                'modifiers' => 'm-small m-border',
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

    @if (count($user->follows))

        @foreach ($user->follows as $follow)

                @include('component.row', [
                    'modifiers' => 'm-image',
                    'profile' => [
                        'modifiers' => '',
                        'image' => $follow->followable->user->imagePreset(),
                        'route' => route('user.show', [$follow->followable->user])
                    ],
                    'title' => $follow->followable->title,
                    'route' => route('content.show', [
                        $follow->followable->type,
                        $follow->followable
                    ]),
                    'text' => view('component.content.text', ['content' => $follow->followable]),
                    'actions' => view('component.actions', ['actions' => $follow->followable->getActions()])
                ])

        @endforeach

    @endif

@stop
