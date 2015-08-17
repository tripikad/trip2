<ul class="list-inline">

    @foreach ($destinations as $destination)

        <li>
{{-- {{ route('destination.index', [$destination->flaggable]) }} --}}

            <a href=""> {{ dump($destination->flaggable) }} </a>

        </li>

    @endforeach

</ul>

