<ul class="list-inline text-center {{ $options or '' }}">

    @foreach ($items as $key => $item)
    
        <li>
        
            <a href="{{ $item['route'] }}">
                
                {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}
            
            </a>
        
        </li>
    
    @endforeach

</ul>