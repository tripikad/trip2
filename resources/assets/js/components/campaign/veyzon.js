var totalPageLikes = 30000;

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    var expires = "expires="+ d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i <ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

$( document ).ready(function() {
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '334251033596544',
            xfbml      : true,
            version    : 'v2.8'
        });

        FB.api(
            "https://graph.facebook.com/tripeeee?fields=likes,fan_count&summary=true&access_token=EAAEvZCZBIfkoABAHjunnTtMccASAOSBOnMRGAQjPaOOVHZCL1AMnJZCHdlb2z8cHr58GQ71ufCiAeqw3OXndflEpR8DyF6bmlhuXlt3hALRTcz6iqrt9vx0mIqMGbW0qaZCD7z2WOiFntEZAnOzF5guwaLb2Xv1M0ZD",
            function (response) {
                if (response && !response.error) {
                    totalPageLikes = response.fan_count;
                    var buffer = totalPageLikes;
                    buffer -= 30000;
                    buffer = Math.floor( buffer / 1000 );
                    $(".circle-container .circle").each( function( idx ) {
                        if ( idx < buffer ) {
                            $(this).addClass("bordered");
                        }
                    });

                    var stripedLine = $(".promotion-line-striped");
                    var lineLength = ( totalPageLikes - 30000 ) / 100;
                    if ( lineLength <= 5 ) {
                        stripedLine.css("width", (lineLength - lineLength/3) + "%");
                    } else {
                        stripedLine.css("width", (lineLength-4) + "%");
                    }
                }
            }
        );
    };

    $(".malta-promotion__svg-wrap svg").on("click", function(e) {
        $(".malta-promotion").slideUp();
        setCookie( "malta-stip-closed", true, 100 );
    });

    $(".malta-promotion__link").on("click", function(e) {
        setCookie("malta-stip-closed", true, 100 );
    })
});
