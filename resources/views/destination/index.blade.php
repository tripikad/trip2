@if (count($destinations))

    in

    @foreach ($destinations as $destination)

      <a href="/content/index/forum?destination={{ $destination->id }}">{{ $destination->name }}</a>

    @endforeach

@endif
