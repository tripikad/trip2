var likesResolved = false;
var totalPageLikes = 30000;

$( document ).ready(function() {
    //105434916193601

    window.fbAsyncInit = function() {
        FB.init({
            appId      : '334251033596544',
            xfbml      : true,
            version    : 'v2.8'
        });

        FB.api(
            "https://graph.facebook.com/tripeeee?fields=likes,fan_count&summary=true&access_token=EAAEvZCZBIfkoABALLZC61Ng3T4dZA8aJL8lA6MyAaZABZB4KnJCjZBdDm8jwfTVTxVy5zzfZAAU8aa2DZBtUxc5IA3kfRhDnKZBBU9cr8AKpLfgKCJ7sNxxftL8wZB1Rr27mYJoSv3gwVlUJjAIrUJBy1X7J39grkNTklYZD",
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
                    //width: 0%;
                }
            }
        );
    };
    //
    //(function(d, s, id){
    //    var js, fjs = d.getElementsByTagName(s)[0];
    //    if (d.getElementById(id)) {return;}
    //    js = d.createElement(s); js.id = id;
    //    js.src = "//connect.facebook.net/en_US/sdk.js";
    //    fjs.parentNode.insertBefore(js, fjs);
    //}(document, 'script', 'facebook-jssdk'));
});