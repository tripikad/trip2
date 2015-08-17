<ul class="list-inlinee">

    @foreach ($flags as $flag)

        <li>
{{-- {{ route('destination.index', [$destination->flaggable]) }} --}}

            <a href=""> {{ dump($flag->flaggable) }} </a>

        </li>

    @endforeach

</ul>

