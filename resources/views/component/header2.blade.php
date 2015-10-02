@if (isset($__env->getSections()['header2.left']) || isset($__env->getSections()['header2.left']) || isset($__env->getSections()['header2.left']))

<div class="component-header-2">

    <div class="container">
        
        <div class="row">
        
            <div class="left col-sm-4 utils-shadow">
                
                @yield('header2.left')

            </div>

            <div class="center col-sm-4 utils-padding">       

                @yield('header2.center')

            </div>
            
            <div class="right col-sm-4 utils-padding">       

                @yield('header2.right')

            </div>

        </div>
    
    </div>

</div>

@endif