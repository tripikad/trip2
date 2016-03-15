var svg4everybodyPath = '/plugins/svg4everybody/',
    script = svg4everybodyPath + 'svg4everybody.min.js';

$.cachedScript(script).done(function() {
    if (typeof svg4everybody == 'function') {
        svg4everybody();
    }
});
