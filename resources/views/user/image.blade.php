@if (! isset($nolink)) <a href="/user/{{ $user->id }}"> @endif

@include('image.item', [
    'image' => 'http://trip.ee/files/pictures/' . ($user->image ? $user->image : 'picture_none.png')
])

@if (! isset($nolink)) </a> @endif
