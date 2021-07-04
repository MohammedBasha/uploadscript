var gulp         = require('gulp'),
    sass         = require('gulp-sass')(require('sass')),
    plumber      = require('gulp-plumber'),
    notify       = require('gulp-notify'),
    autoprefixer = require('gulp-autoprefixer'),
    cleanCSS     = require('gulp-clean-css'),
    rename       = require('gulp-rename'),
    livereload   = require('gulp-livereload');

var config = {
    src: './css/styles.sass',
    dest: './css/'
};

// Error message
var onError = function (err) {
    notify.onError({
        title   : 'Gulp',
        subtitle: 'Failure!',
        message : 'Error: <%= error.message %>',
        sound   : 'Beep'
    })(err);

    this.emit('end');
};

// Task: `styles`.
gulp.task('styles', function () {
    var stream = gulp
        .src(config.src)
        .pipe(plumber({errorHandler: onError}))

        // output non-minified CSS file
        .pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
        .pipe(autoprefixer())
        .pipe(gulp.dest(config.dest))
        
        // output the minified version
        .pipe(cleanCSS({
            compatibility: 'ie7'
        }))
        .pipe(rename({ extname: '.min.css' }))
        .pipe(gulp.dest(config.dest))
        .pipe(livereload());

    return stream
        .pipe( notify( { message: 'TASK: "styles" Completed! 💯', onLast: true } ) );
});

// Task: `watch`
gulp.task('watch', function() {
    livereload.listen();

    gulp.watch('./*.php').on('change', function(file) {
        livereload.reload(file);
    });

    // gulp.watch('./css/*.sass', gulp.series('styles'));
});

// Task: `default`
gulp.task('default', gulp.series('watch'));