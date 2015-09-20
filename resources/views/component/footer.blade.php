<div class="component-footer">

	@if (config('menu.footer'))
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
	@endif

	<hr>
	<div class="footer">
		<p>
			@if(strstr(trans('content.footer.copyright'), '[current_year]'))
				{{ @str_replace("[current_year]", \Carbon\Carbon::now()->format('Y'), trans("content.footer.copyright")) }}
			@else
				{{ trans('content.footer.copyright') }}
			@endif
		</p>
	</div>
</div>