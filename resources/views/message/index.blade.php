@if (count($messages))

@foreach ($messages as $message)
  
    <hr />

    @include('component.row', [
        'image' => $message->fromUser->imagePath(),
        'image_link' => '/user/' . $message->fromUser->id,
        'heading' => $message->title,
        'text' => 'By <a href="/user/' . $message->fromUser->id .'">'
            . $message->fromUser->name
            . '</a> at '
            . $message->created_at->format('d. m Y H:i:s'),
    ])

@endforeach

@endif
