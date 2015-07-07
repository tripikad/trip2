@if (count($carriers))

    carried by

    @foreach ($carriers as $carrier)
      
      <em>{{ $carrier->name }}</em>

    @endforeach

@endif
