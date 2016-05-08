var gulp = require('gulp');

var rename = require("gulp-rename");
var cssnano = require('gulp-cssnano');
var uglify = require('gulp-uglify');
var concat = require('gulp-concat');

gulp.task('default', function () {
    gulp.start('minifycss', 'minifyjs');
});


gulp.task('minifycss', function () {
    return gulp.src('css/*.css')
        .pipe(rename({suffix: '.min'}))
        .pipe(cssnano())
        .pipe(gulp.dest('public/styles'));
});


gulp.task('minifyjs', function () {
    return gulp.src('js/*.js')
        .pipe(gulp.dest('js'))
        .pipe(rename({suffix: '.min'}))
        .pipe(uglify())
        .pipe(gulp.dest('public/js'));
});