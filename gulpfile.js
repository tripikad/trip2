var gulp = require('gulp');
var sass = require('gulp-sass');
var concat = require('gulp-concat');


gulp.task('sass', function () {

    gulp.src([
        './resources/assets/sass/main.scss',
    ])
    .pipe(sass())
    .pipe(gulp.dest('./public/css'));

});


gulp.task('js', function() {
 
    gulp.src([
        './node_modules/jquery/dist/jquery.js',
        './node_modules/bootstrap-sass/assets/javascripts/bootstrap.js',
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