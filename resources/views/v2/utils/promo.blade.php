<script type="text/javascript">

var googletag = googletag || {}
var slot = []
var index = 0
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
        if(promos[promo].id1 && promos[promo].id2) {
            googletag.defineSlot(promos[promo].id1, [promos[promo].width, promos[promo].height], promos[promo].id2).addService(googletag.pubads());
        }
    }
    googletag.pubads().enableSingleRequest();
    googletag.pubads().collapseEmptyDivs();
    googletag.enableServices();
    googletag.pubads().addEventListener('slotRenderEnded', function(e) {
        if (document.getElementById(e.slot.m.m)) {
            ++index;
            slot[index] = setTimeout(function(){
                renderEnded(e.slot.m.m, e.size[0], e.size[1], index);
            }, 200);
            return renderEnded(e.slot.m.m, e.size[0], e.size[1], index);
        }
    });
});

window.onload = function(){
    for (var promo in promos) {
        if(promos[promo].id1 && promos[promo].id2) {
            if (document.getElementById(promos[promo].id2)) {
                googletag.display(promos[promo].id2);
            }
        }
    }
}

function renderEnded (adunitId, width, height, i) {
    var adUnitElement = document.getElementById(adunitId);
    if (adUnitElement.querySelector('iframe')) {
        var iFrame = adUnitElement.querySelector('iframe'),
            newHeight = ((parseInt(window.getComputedStyle(iFrame, null).width) * height) / width),
            iFrameID = iFrame.getAttribute('id'),
            goToFrame = document.getElementById(iFrameID).contentWindow,
            googleImageDiv = goToFrame.document.querySelector('#google_image_div'),
            imgInIFrame = goToFrame.document.querySelector('img');

        if (googleImageDiv) {
            googleImageDiv.style.maxWidth = '100%';
            googleImageDiv.style.height = 'auto';
            googleImageDiv.style.display = 'block';
        }

        if (imgInIFrame) {
            imgInIFrame.style.maxWidth = '100%';
            imgInIFrame.style.height = 'auto';
            imgInIFrame.style.display = 'block';
        }

        iFrame.style.height = newHeight + 'px';

        while (iFrame = iFrame.parentElement.closest('#' + adunitId)) {
            iFrame.style.display = 'block';
        }

        if (slot.length && slot[i]) {
            clearTimeout(slot[i]);
        }
    } else {
        slot[i] = setTimeout(function() {
            renderEnded(adunitId, width, height, i);
        }, 200);
    }
}

</script>  
