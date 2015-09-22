@extends('layouts.main')

@section('title')
    {{ trans('message.index.title', ['user' => $user->name]) }}
@stop

@section('navbar.bottom')
    
    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))
        
        <div class="utils-border-bottom">
            
            @include('component.user.menu', ['user' => $user])
        
        </div>

    @endif

@stop

@section('content')

@if (count($user->messages()))    

    @foreach ($user->messages() as $message)
      
        <div class="utils-border-bottom @if ($message->read) utils-read @endif">

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