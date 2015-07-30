@if(auth()->user())
        
    <li>
        <a href="{{ route('user.show', [auth()->user()]) }}">
            {{ auth()->user()->name }}
        </a>
    </li>
    <li>
        <a href="{{ route('login.logout') }}">&times;</a>
    </li>
    
@else

    <li>
        <a href="{{ route('register.form') }}">Register</a>
    </li>
    
    <li>
        <a href="{{ route('login.form') }}">Login</a>
    </li>
    
@endif
