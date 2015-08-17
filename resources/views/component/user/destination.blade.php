<ul class="list-inline">

    @foreach ($destinations as $destination)

        <li>
{{-- {{ route('destination.index', [$destination->flaggable]) }} --}}

            <a href=""> {{ $destination->flaggable->name }} </a>

        </li>

    @endforeach

</ul>

