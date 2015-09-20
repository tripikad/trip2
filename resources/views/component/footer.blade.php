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
			{{ trans('content.footer.copyright', ['current_year' =>  \Carbon\Carbon::now()->year]) }}
		</p>
	</div>
</div>