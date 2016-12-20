var Elixir = require('laravel-elixir');
var gulp = require('gulp')
var postcss = require('gulp-postcss')

Elixir.extend('postcss', function(src, output, includePath) {
    var paths = new Elixir.GulpPaths().src(src).output(output)
    new Elixir.Task('postcss', function($) {
        return (
            gulp
                .src(this.src.path)
                .pipe(this.initSourceMaps())
                .pipe(postcss([
                    require('postcss-import')({ path: [
                        includePath,
                        './node_modules'
                    ]}),
                    require('postcss-simple-vars')(),
                    require('postcss-responsive-type')(),
                    require('postcss-font-magician')(),
                    require('postcss-if-media')(),
                ])) 
                .on('error', this.onError())
                .pipe(this.concat(paths.output.name))
                .pipe(this.minify())
                .on('error', this.onError())
                .pipe(this.writeSourceMaps())
                .pipe(this.saveAs(gulp))
                .pipe(this.onSuccess())
        )
    }, paths).watch(paths.src.path)
})