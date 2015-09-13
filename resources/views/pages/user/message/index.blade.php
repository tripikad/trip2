@extends('layouts.medium')

@section('title')
    {{ trans('user.show.messages.index.title', ['user' => $user->name]) }}
@stop

@section('navbar.bottom')
    
    @if (\Auth::check() && \Auth::user()->hasRoleOrOwner('superuser', $user->id))
        
        <div class="utils-border-bottom">
            
            @include('component.user.menu', ['user' => $user])
        
        </div>

    @endif

@stop

@section('content.medium')

@if (count($user->messages()))    

    @foreach ($user->messages() as $message)
      
        <div class="utils-border-bottom @if ($message->read) utils-read @endif">

            @include('component.row', [
                'image' => $message->withUser->imagePreset(),
                'image_link' => route('user.show', [$message->withUser]),
                'heading' => $message->title,
                'heading_link' => route('user.show.messages.with', [$user, $message->withUser]),
                'text' => trans('user.show.messages.index.row.text', [
                    'user' => view('component.user.link', ['user' => $message->withUser]),
                    'created_at' => $message->created_at->format('d. m Y H:i:s')
                ])
            ])

        </div>

    @endforeach

@endif

@stop