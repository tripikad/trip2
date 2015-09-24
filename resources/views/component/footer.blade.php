<div class="component-footer">
    
    <div class="menu utils-border-bottom">
        
        <ul class="list-inline">

            @include('component.menu', [
                'menu' => 'footer',
                'items' => config('menu.footer')
            ])

        </ul>

    </div>

    <div class="copyright">
     
        {{ trans('site.footer.copyright', ['current_year' =>  \Carbon\Carbon::now()->year]) }}
    
    </div>

</div>