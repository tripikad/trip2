var googletag = googletag || {},
    slot = [],
    index = 0,
    elements = [];

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
            googletag.defineSlot(promos[promo].id1, [[promos[promo].width, promos[promo].height], 'fluid'], promos[promo].id2).addService(googletag.pubads());
        }
    }
    googletag.pubads().enableSingleRequest();
    googletag.pubads().collapseEmptyDivs();
    googletag.enableServices();
    googletag.pubads().addEventListener('slotRenderEnded', function(e) {
        if (e.slot.C && e.size[0] != 0 && e.size[1] != 0) {
            var i = index,
                slot_width = e.size[0],
                slot_height = e.size[1];

            ++index;

            slot[index] = setTimeout(function(){
                renderEnded(e.slot.C, slot_width, slot_height, i);
            }, 200);

            return renderEnded(e.slot.C, slot_width, slot_height, i);
        }
    });
});

function renderEnded (element, width, height, i) {
    var inputs = document.getElementsByTagName("div");

    if (inputs.length) {
        for(var k = 0; k < inputs.length; k++) {
            if(inputs[k].getAttribute("id") && inputs[k].getAttribute("id").indexOf('google_ads_iframe_' + element) === 0) {
                if (typeof elements[element] === typeof undefined || elements[element] === '') {
                    elements[element] = inputs[k];
                }
            }
        }
    }

    if (elements[element]) {
        var adUnitElement = elements[element];
        if (adUnitElement.querySelector('iframe')) {
            var iFrame = adUnitElement.querySelector('iframe'),
                newHeight = ((parseInt(window.getComputedStyle(iFrame, null).width) * height) / width),
                iFrameID = iFrame.getAttribute('id'),
                goToFrame = document.getElementById(iFrameID).contentDocument || document.getElementById(iFrameID).contentWindow;

            if (typeof goToFrame.querySelector('body').innerHTML !== typeof undefined && goToFrame.querySelector('body').innerHTML !== '') {
                if (slot.length && slot[i]) {
                    clearTimeout(slot[i]);
                }

                var googleImageDiv = goToFrame.getElementById('google_image_div'),
                    imgInIFrame = goToFrame.querySelector('img');

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

                if (iFrame.style.height == '' && newHeight > 0 && ! isNaN(newHeight)) {
                    iFrame.style.height = newHeight + 'px';
                    adUnitElement.style.height = newHeight + 'px';
                    adUnitElement.style.overflow = 'hidden';
                }
            }
        } else {
            slot[i] = setTimeout(function() {
                renderEnded(element, width, height, i);
            }, 200);
        }
    }
}
