<ul class="nav nav-pills">

    @if(auth()->user())
        
        <li><a href="/user/{{ auth()->user()->id }}">{{ auth()->user()->name }}</a></li>
        <li><a href="/auth/logout">&times;</a></li>
    
    @else
    
        <li><a href="/auth/login">Login</a></li>
    
    @endif

</ul>