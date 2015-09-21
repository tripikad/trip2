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

            <ul class="nav navbar-nav navbar-right">
            
                @include('component.auth.menu')
            
            </ul>

        </div>

    </div>

</nav>