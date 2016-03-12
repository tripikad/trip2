var svg4everybody_path = '/plugins/svg4everybody/',
    script = svg4everybody_path + 'svg4everybody.min.js';

$.getScript(script, function() {
    if (typeof svg4everybody == 'function') {
        svg4everybody();
    }
});
