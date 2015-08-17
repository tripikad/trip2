{{ dump($destinations) }}

<ul class="list-inline">

    @foreach ($destinations as $destination)

        <li>

            <a href="{{ route('destination.index', [$destination->flaggable]) }}"> {{ $destination->flaggable->name }} </a>

        </li>

    @endforeach

</ul>

@endif