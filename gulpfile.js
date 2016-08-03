// V1

var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var svgstore = require('gulp-svgstore');
var rename = require('gulp-rename');
var svgmin = require('gulp-svgmin');
var del = require('del');
var minifyCSS = require('gulp-clean-css');
var minifyJS = require('gulp-uglify');

gulp.task('del', function () {
  return del([
    './public/css/**/*.css',
    './public/js/**/*.js',
    './public/svg/**/*.svg',
  ]);
});

gulp.task('sass', ['del'], function() {

    gulp.src([
        './node_modules/normalize.css/normalize.css',
        './node_modules/susy/sass/_susy.scss',
        './node_modules/breakpoint-sass/stylesheets/_breakpoint.scss',
        './node_modules/dropzone/dist/dropzone.css',
        './resources/assets/sass/base/_base.mixins.scss',
        './resources/assets/sass/base/_base.colors.scss',
        './resources/assets/sass/base/_base.layout.scss',
        './resources/assets/sass/base/_base.fonts.scss',
        './resources/assets/sass/base/_base.typography.scss',
        './resources/assets/sass/base/_base.scss',
        './resources/assets/sass/**/_*.scss'
    ])
    .pipe(concat('main.scss'))
    .pipe(sass({
        includePaths: [
            './node_modules/susy/sass',
            './node_modules/breakpoint-sass/stylesheets'
        ],
        errLogToConsole: true
    }))
    .pipe(autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
    }))
    .pipe(minifyCSS())
    .pipe(gulp.dest('./public/css'));

});

gulp.task('js', ['del'], function() {

    gulp.src([
        './node_modules/jquery/dist/jquery.js',
        //'./resources/assets/js/jquery-ui/jquery-ui.min.js',
        './resources/assets/js/helpers/**/*.js',
        './node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        './node_modules/selectize/dist/js/standalone/selectize.js',
        './node_modules/dropzone/dist/dropzone.js',
        './resources/assets/js/components/**/*.js'
    ])
    .pipe(concat('main.js'))
    .pipe(minifyJS())
    .pipe(gulp.dest('./public/js'));

});

gulp.task('svg_sprite', ['del'], function () {
    return gulp
        .src('resources/assets/svg/sprite/*.svg')
        .pipe(svgmin())
        .pipe(svgstore())
        .pipe(rename(function (path) {
            path.basename = 'main'
        }))
        .pipe(gulp.dest('public/svg'));
});

gulp.task('svg_standalone', ['del'], function () {
    return gulp
        .src('resources/assets/svg/standalone/*.svg')
        .pipe(svgmin())
        .pipe(gulp.dest('public/svg'));
});

gulp.task('watch', function () {

  gulp.watch('./resources/assets/sass/**/_*.scss', ['sass']);
  gulp.watch('./resources/assets/js/**/*.js', ['js']);
  gulp.watch('./resources/assets/svg/**/*.svg', ['svg_sprite', 'svg_standalone']);

});

gulp.task('v1', ['sass', 'js', 'svg_sprite', 'svg_standalone']);

// V2

var elixir = require('laravel-elixir')

require('laravel-elixir-vueify')
require('./elixir/postcss')
require('./elixir/svg')

elixir(function(mix) {
    mix.browserify(
        './resources/views/v2/main.js',
        './public/v2/js'
    )

    mix.postcss([
            './resources/views/v2/utils/**/*.css',
            './resources/views/v2/components/**/*.css'
        ],
        './public/v2/css'
    )

    mix.svg([
        './resources/views/v2/svg/*.svg',
        ],
        './public/v2/svg'
    )
})
