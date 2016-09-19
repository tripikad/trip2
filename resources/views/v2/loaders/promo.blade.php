<script type="text/javascript">

var googletag = googletag || {};
googletag.cmd = googletag.cmd || [];
(function() {
    var gads = document.createElement('script');
    gads.async = true;
    gads.type = 'text/javascript';
    var useSSL = 'https:' == document.location.protocol;
    gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js';
    var node = document.getElementsByTagName('script')[0];
    node.parentNode.insertBefore(gads, node);
})();

var globalProps = JSON.parse(decodeURIComponent(
    document.querySelector('#globalprops').getAttribute('content')
))

var promos = globalProps.promo

googletag.cmd.push(function() {
    for (var promo in promos) {
        googletag.defineSlot(promos[promo].id1, [promos[promo].width, promos[promo].height], promos[promo].id2).addService(googletag.pubads())
    }
    googletag.pubads().enableSingleRequest()
    googletag.pubads().collapseEmptyDivs()
    googletag.enableServices()
})

</script>  
