var svg4everybodyPath = '/plugins/svg4everybody/',
    script = svg4everybodyPath + 'svg4everybody.min.js';

$.getScript(script, function() {
    if (typeof svg4everybody == 'function') {
        $('test').svg4everybody();
    }
});
