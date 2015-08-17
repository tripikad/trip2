<ul class="list-inlinee">

    @foreach ($flags as $flag)

        <li>
{{-- {{ route('destination.index', [$destination->flaggable]) }} --}}

            <a href=""> {{ dump($destination) }} </a>

        </li>

    @endforeach

</ul>

