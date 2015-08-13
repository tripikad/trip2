<ul class="list-inline">

@foreach ($user->destinationWantsToGo() as $flag)

    <li>

        <a href="{{ route('destination.index', [$flag->flaggable]) }}"> {{ $flag->flaggable->name }} </a>

    </li>

@endforeach

</ul>