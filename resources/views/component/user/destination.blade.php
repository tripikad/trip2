<ul class="list-inline">

    @foreach ($destinations as $destination)

        @if(isset($destination->flaggable))
        
            <li>

                <a href="{{ route('destination.index', [$destination->flaggable]) }}">
                
                    {{ $destination->flaggable->name }}
                
                </a>

            </li>

        @endif

    @endforeach

</ul>