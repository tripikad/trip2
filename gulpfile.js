var gulp = require('gulp');
var sass = require('gulp-sass');

gulp.task('sass', function () {
  gulp.src('./resources/assets/sass/main.scss')
    .pipe(sass())
    .pipe(gulp.dest('./public/css'));
});

gulp.task('watch', function () {
  gulp.watch('./resources/assets/sass/**/*.scss', ['sass']);
});

gulp.task('default', ['sass']);