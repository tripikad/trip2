@if (! isset($nolink)) <a href="/user/{{ $user->id }}"> @endif

@include('image.circle', [
    'image' => 'http://trip.ee/files/pictures/' . ($user->image ? $user->image : 'picture_none.png'),
])

@if (! isset($nolink)) </a> @endif
