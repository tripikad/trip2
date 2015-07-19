var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');

/*
gulp.task('sass', function () {

    gulp.src([
        './resources/assets/sass/main.scss',
    ])
    .pipe(sass())
    .pipe(gulp.dest('./public/css'));

});
*/

gulp.task('sass', function () {

    gulp.src([
        './node_modules/bootstrap-sass/assets/stylesheets/bootstrap/_variables.scss',
        './resources/assets/sass/variables.scss',
        './node_modules/bootstrap-sass/assets/stylesheets/_bootstrap.scss',
  //      './resources/assets/sass/styles/**/*.scss',
        './resources/assets/sass/components/**/*.scss',
    ])
    .pipe(sass())
    .pipe(gulp.dest('./public/css'));

});

gulp.task('js', function() {
 
    gulp.src([
        './node_modules/jquery/dist/jquery.js',
        './node_modules/fastclick/lib/fastclick.js',
        './resources/assets/js/**/*.js'
    ])
    .pipe(concat('main.js'))
    .pipe(gulp.dest('./public/js'));

});


gulp.task('watch', function () {

  gulp.watch('./resources/assets/sass/**/*.scss', ['sass']);

});

gulp.task('default', ['sass', 'js']);