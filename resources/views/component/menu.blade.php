<ul class="list-inline text-center">

    @foreach ($items as $key => $item)
    
        <li>
            <a href="{{ $item['route'] }}">{{ trans("menu.$menu.$key") }}</a>
        </li>
    
    @endforeach

</ul>