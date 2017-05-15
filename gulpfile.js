var gulp = require('gulp');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var sourcemaps = require('gulp-sourcemaps');

gulp.task('js', function() {
    gulp.src('src/assets/query.js')
        .pipe(sourcemaps.init())
        .pipe(uglify())
        .pipe(rename({extname: '.min.js'}))
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('src/assets'));
});

gulp.task('default', ['js']);
