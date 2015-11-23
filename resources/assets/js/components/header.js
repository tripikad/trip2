
var tablet = 1000,
    body = $('body'),
    nav = $('.js-navbar'),
    headerNav = $('.js-header__nav'),
    headerSearch = $('.js-header__search'),
    headerNavTrigger = $('.js-header__nav-trigger'),
    headerSearchTrigger = $('.js-header__search-trigger');

// Nav toggle

headerNavTrigger.on('click', function(){

    var $this = $(this);

    if($this.hasClass('m-active')){

        $this.removeClass('m-active');
        headerNav.removeClass('m-active');
        nav.removeClass('m-active');
        body.removeClass('m-fixed');

    } else {

        $this.addClass('m-active');
        headerNav.addClass('m-active');
        nav.addClass('m-active');
        body.addClass('m-fixed');
    }

    return false;
});

// Search toggle

headerSearchTrigger.on('click', function(){

    var $this = $(this);

    if($this.hasClass('m-active')){

        $this.removeClass('m-active');
        headerSearch.removeClass('m-active');

    } else {

        $this.addClass('m-active');
        headerSearch.addClass('m-active');
    }

    return false;
});

// Remove active classes on resize

$(window).on('resize', function(){

    var winWidth = $(window).width();

    if (winWidth >= tablet) {

        nav.removeClass('m-active');
        body.removeClass('m-fixed');
        headerNav.removeClass('m-active');
        headerNavTrigger.removeClass('m-active');
        headerSearch.removeClass('m-active');
        headerSearchTrigger.removeClass('m-active');
    }
});
