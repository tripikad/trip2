@if(rand(0,1))
    
@include('components.ad.' . ['wide1x1', 'wide2x1', 'narrow3x1', 'widenarrow2x1', 'square4x1'][rand(0,4)])

<hr />

@endif