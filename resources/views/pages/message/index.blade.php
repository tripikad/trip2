@extends('layouts.one_column')

@section('title')
    {{ trans('message.index.title', ['user' => $user->name]) }}
@stop

@section('header2.content')

    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))

        @include('component.nav', [
            'menu' => 'user',
            'items' => [
                'activity' => ['route' => route('user.show', [$user])],
                'message' => ['route' => route('message.index', [$user])],
                'follow' => ['route' => route('follow.index', [$user])]
            ],
            'options' => 'text-center'
        ])

    @endif

@stop

@section('content.one')

@if (count($user->messages()))

    @foreach ($user->messages() as $message)

        <div class="utils-padding-bottom @if ($message->read) utils-read @endif">

            @include('component.row', [
                'image' => $message->withUser->imagePreset(),
                'image_link' => route('user.show', [$message->withUser]),
                'heading' => $message->title,
                'heading_link' => route('message.index.with', [$user, $message->withUser]),
                'description' => trans('message.index.row.description', [
                    'user' => view('component.user.link', ['user' => $message->withUser]),
                    'created_at' => view('component.date.long', ['date' => $message->created_at])
                ]),
                'options' => '-narrow'
            ])

        </div>

    @endforeach

@endif

@stop