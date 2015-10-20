<footer class="c-footer" style="background-image: url({{ \App\Image::getRandom() }});">

	<div class="c-footer__wrap">

		<nav class="c-footer__nav">

			<a href="#" class="c-footer__nav-logo">Trip.ee</a>

			@include('component.footernav', [
	            'menu' => 'footer',
	            'items' => config('menu.footer')
	        ])

	        @include('component.footernav', [
	            'menu' => 'footer2',
	            'items' => config('menu.footer2')
	        ])

	        @include('component.footernav', [
	            'menu' => 'footer3',
	            'items' => config('menu.footer3')
	        ])

		</nav>

		@include('component.footersocial', [
            'menu' => 'footer-social',
            'items' => config('menu.footer-social')
        ])

		<p class="c-footer__license">
			{{ trans('site.footer.copyright', ['current_year' =>  \Carbon\Carbon::now()->year]) }}
		</p>

	</div>

</footer>