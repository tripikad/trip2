<ul class="list-inline text-center">

    @foreach ($menu as $key => $data)
    
        <li>
            <a href="{{ $data['url'] }}">{{ trans("menu.$menutype.$key") }}</a>
        </li>
    
    @endforeach

</ul>