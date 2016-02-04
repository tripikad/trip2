var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var svgstore = require('gulp-svgstore');
var rename = require('gulp-rename');
var svgmin = require('gulp-svgmin');

gulp.task('sass', function() {

    gulp.src([
        './node_modules/normalize.css/normalize.css',
        './node_modules/susy/sass/_susy.scss',
        './node_modules/breakpoint-sass/stylesheets/_breakpoint.scss',
        './node_modules/selectize/dist/css/selectize.css',
        './node_modules/dropzone/dist/dropzone.css',
        './resources/assets/sass/base/_base.mixins.scss',
        './resources/assets/sass/base/_base.colors.scss',
        './resources/assets/sass/base/_base.layout.scss',
        './resources/assets/sass/base/_base.fonts.scss',
        './resources/assets/sass/base/_base.typography.scss',
        './resources/assets/sass/base/_base.scss',
        './resources/assets/sass/**/_*.scss',
    ])
    .pipe(concat('main.scss'))
    .pipe(sass({
        includePaths: [
            './node_modules/susy/sass',
            './node_modules/breakpoint-sass/stylesheets',
        ],
        errLogToConsole: true
    }))
    .pipe(autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
    }))
    .pipe(gulp.dest('./public/css'));

});

gulp.task('js', function() {

    gulp.src([
        './node_modules/jquery/dist/jquery.js',
        './node_modules/jquery-ui/jquery-ui.js',
        './node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        './node_modules/selectize/dist/js/standalone/selectize.js',
        './node_modules/fastclick/lib/fastclick.js',
        './node_modules/dropzone/dist/dropzone.js',
        './resources/assets/js/**/*.js'
    ])
    .pipe(concat('main.js'))
    .pipe(gulp.dest('./public/js'));

});

gulp.task('svg_sprite', function () {
    return gulp
        .src('resources/assets/svg/sprite/*.svg')
        .pipe(svgmin())
        .pipe(svgstore())
        .pipe(rename(function (path) {
            path.basename = 'main'
        }))
        .pipe(gulp.dest('public/svg'));
});

gulp.task('svg_standalone', function () {
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

gulp.task('default', ['sass', 'js', 'svg_sprite', 'svg_standalone']);