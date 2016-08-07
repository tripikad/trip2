var gulp = require('gulp')
var svgmin = require('gulp-svgmin')
var svgstore = require('gulp-svgstore')

var Elixir = require('laravel-elixir')

var $ = Elixir.Plugins

Elixir.extend('svg', function(src, output) {
    return new Elixir.Task('svg', function() {
        this.log(src, output)

        return gulp.src(src)
            .pipe(svgmin())
            .pipe(svgstore({ inlineSvg: true }))
            .pipe($.rename(function(path) {
                path.basename = 'main'
            }))
            .pipe(gulp.dest(output || './public/svg'))
            .pipe(new Elixir.Notification('SVG Compiled'))
    })
    .watch(src)
})
