<nav class="component-navbar navbar navbar-default">

    <div class="container-fluid">

        <div class="navbar-header">
            
            <button type="button" class="navbar-toggle collapsed btn btn-link" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">

                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
    
            </button>

            <h1><a href="/">{{ config('site.name') }}</a></h1>

        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      
            <ul class="nav navbar-nav">
            
                @include('component.menu', [
                    'menu' => 'header',
                    'items' => config('menu.header')
                ])
            
            </ul>

            @if(auth()->user() && ! auth()->user()->hasRole('admin'))

                @include('component.menu', [
                    'menu' => 'auth',
                    'items' => [
                        'user' => [
                            'route' => route('user.show', [auth()->user()]),
                            'title' =>  auth()->user()->name
                        ],
                        'logout' => [
                            'route' => route('login.logout'),
                        ],

                    ],
                    'options' => 'nav navbar-nav navbar-right'
                ])

            @elseif(auth()->user() && auth()->user()->hasRole('admin'))

                @include('component.menu', [
                    'menu' => 'auth',
                    'items' => [
                        'user' => [
                            'route' => route('user.show', [auth()->user()]),
                            'title' =>  auth()->user()->name
                        ],
                        'admin' => [
                            'route' => route('content.index', ['internal'])
                        ],
                        'logout' => [
                            'route' => route('login.logout'),
                        ],

                    ],
                    'options' => 'nav navbar-nav navbar-right'
                ])

            @else

                @include('component.menu', [
                    'menu' => 'auth',
                    'items' => [
                        'register' => [
                            'route' => route('register.form'),
                        ],
                        'login' => [
                            'route' => route('login.form')
                        ],
                    ],
                    'options' => 'nav navbar-nav navbar-right'
                ])

            @endif

        </div>

    </div>

</nav>