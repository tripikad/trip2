<div>

@if($results && count($results)) 
	@foreach ($results as $type => $content)

<div style="border:1px solid grey;width:100%;">
	<div style="width:20%;float:left;"><img src="#"></div>
	<div style="width:80%;float:left;">
		<div style="color:red;">{{ $type }}</div>
		<div>tekst1</div>
		<div>tekst2</div>
	</div>
</div>

	@endforeach
@endif          



</div>