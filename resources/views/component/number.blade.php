{{--

Any properties can be combined. Numbers fill proportionally their container width

@include('component.number', [
    'number' => '1',
    'options' => '-neutral'
])

--}}

<div class="component-number {{ $options or ''}}">
    
    <div class="content">
        
        <div class="number">

            {{ $number or '0'}}
    
        </div>
    
    </div>
    
</div>