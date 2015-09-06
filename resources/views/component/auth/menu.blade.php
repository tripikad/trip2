@if(auth()->user())
        
    <li>
        <a href="{{ route('user.show', [auth()->user()]) }}">
            {{ auth()->user()->name }}
        </a>
    </li>

    @if (auth()->user()->hasRole('admin'))

    <li>
        <a href="{{ route('content.index', ['internal']) }}">Admin</a>
    </li>
    
    @endif

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
