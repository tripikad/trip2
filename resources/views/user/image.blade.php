<a href="/user/{{ $user->id }}">
    @include('image.item', [
        'image' => 'http://trip.ee/files/pictures/' . ($user->image ? $user->image : 'picture_none.png')
    ])
</a>