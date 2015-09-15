var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');
var autoprefixer = require('gulp-autoprefixer');
var svgstore = require('gulp-svgstore');
var rename = require('gulp-rename');
var svgmin = require('gulp-svgmin');

gulp.task('sass', function() {

    gulp.src([
        './resources/assets/sass/variables_bootstrap.scss',
        './node_modules/bootstrap-sass/assets/stylesheets/bootstrap/_variables.scss',
        './resources/assets/sass/variables.scss',
        './node_modules/bootstrap-sass/assets/stylesheets/_bootstrap.scss',

        './node_modules/selectize/dist/css/selectize.bootstrap3.css',

        './resources/assets/sass/**/*.scss',
    ])
    .pipe(concat('main.scss'))
    .pipe(sass({includePaths: [
        './node_modules/bootstrap-sass/assets/stylesheets',
    ]
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
        './node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
        './node_modules/selectize/dist/js/standalone/selectize.js',
        './node_modules/fastclick/lib/fastclick.js',
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

  gulp.watch('./resources/assets/sass/**/*.scss', ['sass']);
  gulp.watch('./resources/assets/svg/**/*.svg', ['svg_sprite', 'svg_standalone']);

});

gulp.task('default', ['sass', 'js', 'svg_sprite', 'svg_standalone']);