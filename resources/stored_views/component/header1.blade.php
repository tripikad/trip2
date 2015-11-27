<div
    class="component-header-1"
    style="background-image: url({{
        isset($__env->getSections()['header1.image'])
        ? $__env->getSections()['header1.image']
        : \App\Image::getRandom()
    }});"
>
    <div class="overlay">

        <div class="navbar container">

            @include('component.navbar')

        </div>    

        <div class="content container">

            <div class="row">

                <div class="col-sm-2">
                    
                    @yield('header1.left')
                
                </div>

                <div class="col-sm-8 text-center">
                    
                    @yield('header1.top')
                    
                    <h2>@yield('title')</h2>

                    @yield('header1.bottom')
                    
                </div>

                <div class="col-sm-2 text-right">
                    
                    @yield('header1.right')
                
                </div>

            </div>
    
        </div>

    </div>

</div>