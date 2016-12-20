var Elixir = require('laravel-elixir')
var gulp = require('gulp')
var svgstore = require('gulp-svgstore')

Elixir.extend('svg', function(src, output) {
    var paths = new Elixir.GulpPaths().src(src).output(output)
    new Elixir.Task('svg', function($) {
        return (
            gulp
                .src(this.src.path)
                .pipe(svgstore())
                .on('error', this.onError())
                .pipe($.rename(paths.output.name))
                .pipe(this.saveAs(gulp))
                .pipe(this.onSuccess())
        )
    }, paths).watch(paths.src.path)
})
