<div class="component-footer">
    
    <div class="menu">
        
        @include('component.menu', [
            'menu' => 'footer',
            'items' => config('menu.footer')
        ])

    </div>

    <div class="copyright">
     
        {{ trans('site.footer.copyright', ['current_year' =>  \Carbon\Carbon::now()->year]) }}
    
    </div>

</div>