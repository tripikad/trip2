(function() {
    var path = '//easy.myfonts.net/v2/js?sid=260918(font-family=Sailec+Bold)&sid=260923(font-family=Sailec+Light)&sid=260924(font-family=Sailec+Medium)&sid=260929(font-family=Sailec+Regular+Italic)&key=eTFuMvz2lk',
        protocol = ('https:' == document.location.protocol ? 'https:' : 'http:'),
        trial = document.createElement('script');
    trial.type = 'text/javascript';
    trial.async = true;
    trial.src = protocol + path;
    var head = document.getElementsByTagName('head')[0];
    head.appendChild(trial);
    $('#mfPreviewBar').css({
        'z-index': '100000',
        'position': 'fixed'
    });
})();

