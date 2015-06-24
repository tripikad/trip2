@if (count($destinations))

    in

    @foreach ($destinations as $destination)
      
      <em>{{ $destination->name }}</em>

    @endforeach

@endif
