@if (isset($__env->getSections()['header2.left']) || isset($__env->getSections()['header2.left']) || isset($__env->getSections()['header2.left']))

<div class="component-header-2">

    <div class="container">

        <div class="row">
        
            <div class="col-sm-5">
                
                @yield('header2.left')

            </div>

            <div class="col-sm-offset-1 col-sm-5">
                
                @yield('header2.center')

            </div>
            
            <div class="col-sm-offset-1 col-sm-4">
                
                @yield('header2.right')

            </div>

        </div>
    
    </div>

</div>

@endif