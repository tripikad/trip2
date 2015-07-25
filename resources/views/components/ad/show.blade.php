@if(rand(0,1))

<div class="utils-border-bottom">

@include('components.ad.' . ['wide1x1', 'wide2x1', 'narrow3x1', 'square4x1'][rand(0,3)])

</div>

@endif