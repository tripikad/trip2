<ul class="list-inline">

	@foreach (config('menu.footer') as $key => $data)
            
    <li>
       		
    		<a href="{{ $data['url'] }}"

    			@if (isset($data['external']) && $data['external'])

    				target="_blank"

    			@endif

    		>

    			{{ trans("menu.footer.$key") }}

    		</a>
    	
    </li>
            
    @endforeach

</ul>