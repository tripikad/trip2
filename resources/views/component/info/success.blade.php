@if (session('info'))
    
    <div class="alert alert-success">

        {{ session('info') }}

    </div>

@endif