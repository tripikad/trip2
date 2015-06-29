var elixir = require('laravel-elixir');

elixir.config.sourcemaps = false;

elixir(function(mix) {
    mix.less('app.sass');
});
