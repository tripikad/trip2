<div class="c-blog-social">

    <a href="http://www.facebook.com/share.php?u={{Request::url()}}&title=Title" class="c-blog-social__link m-facebook">
        @include('component.svg.sprite', [
            'name' => 'icon-facebook'
        ])
    </a>

    <a href="http://twitter.com/intent/tweet?status=Title+{{Request::url()}}" class="c-blog-social__link m-twitter">
        @include('component.svg.sprite', [
            'name' => 'icon-twitter'
        ])
    </a>
</div>