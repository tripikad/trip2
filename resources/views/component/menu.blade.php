<ul class="{{ $options or 'list-inline' }}">

    @foreach ($items as $key => $item)
    
        <li>
        
            <a href="{{ $item['route'] }}">
                
                {{ isset($item['title']) ? $item['title'] : trans("menu.$menu.$key") }}
            
            </a>
        
        </li>
    
    @endforeach

</ul>