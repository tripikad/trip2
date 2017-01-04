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
                                'route' => ($user->name != 'Tripi külastaja' ? route('user.show', [$user]) : false),
                            ])
                        ],
                        [
                            'modifiers' => 'm-green',
                            'button' => view('component.button',[
                                'modifiers' => 'm-small',
                                'title' => trans('menu.user.message'),
                                'route' => ($user->name != 'Tripi külastaja' ? route('message.index', [$user]) : false),
                            ])
                        ],
                        [
                            'modifiers' => 'm-green',
                            'button' => view('component.button',[
                                'modifiers' => 'm-small m-border',
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

    @if (count($user->follows))

        @foreach ($user->follows as $follow)

                @include('component.row', [
                    'modifiers' => 'm-image',
                    'profile' => [
                        'modifiers' => '',
                        'image' => $follow->followable->user->imagePreset(),
                        'route' => ($follow->followable->user->name != 'Tripi külastaja' ? route('user.show', [$follow->followable->user]) : false),
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


        <div class="r-user__admin">
            <div class="r-user__admin-wrap">
            
            @include('component.card', [
                'text' => trans('follow.index.email'),
            ])
            
            </div>
        </div>

    @else 

        @include('component.card', [
            'text' => trans('follow.index.empty'),
        ])
    
    @endif

@stop
