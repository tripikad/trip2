@unless ($nolink) <a href="/user/{{ $user->id }}"> @endunless

@include('image.item', [
    'image' => 'http://trip.ee/files/pictures/' . ($user->image ? $user->image : 'picture_none.png')
])

@unless ($nolink) </a> @endunless
