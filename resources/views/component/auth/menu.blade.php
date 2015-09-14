@if(auth()->user())
        
    <li>
        <a href="{{ route('user.show', [auth()->user()]) }}">
            {{ auth()->user()->name }}
        </a>
    </li>

    @if (auth()->user()->hasRole('admin'))

        <li>
            <a href="{{ route('content.index', ['internal']) }}">{{ trans('menu.header.admin') }}</a>
        </li>
    
    @endif

    <li>
        <a href="{{ route('login.logout') }}">{{ trans('menu.header.logout') }}</a>
    </li>

@else

    <li>
        <a href="{{ route('register.form') }}">{{ trans('menu.header.register') }}</a>
    </li>
    
    <li>
        <a href="{{ route('login.form') }}">{{ trans('menu.header.login') }}</a>
    </li>
    
@endif
