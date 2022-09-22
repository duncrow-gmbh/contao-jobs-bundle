const gulp = require('gulp');
const sass = require('gulp-sass')(require('node-sass'));
const uglify = require('gulp-uglify');
const concat = require('gulp-concat');
const include = require('gulp-include');
const cleanCSS = require('gulp-clean-css');

const themePath = '';

const paths = {
    src: {
        styles: themePath + 'src/scss/default.scss',
        scripts: [
            //libs
            'node_modules/scrolltofixed/jquery-scrolltofixed-min.js',

            themePath + 'src/js/**/*.js',
        ],
    },
    dist: {
        styles: themePath + 'dist/css',
        scripts: themePath + 'dist/js',
    },
    watch: {
        styles: themePath + 'src/scss/**/*.scss',
        scripts: themePath + 'src/js/**/*.js'
    }
};

const styles = function () {
    return gulp.src(paths.src.styles)
        .pipe(concat('style.scss'))
        .pipe(sass().on('error', sass.logError))
        .pipe(gulp.dest(paths.dist.styles));
};

const scripts = function () {
    return gulp.src(paths.src.scripts)
        .pipe(include())
        .pipe(concat('script.js'))
        .pipe(gulp.dest(paths.dist.scripts));
};

const minifyStyles = function () {
    return gulp.src(paths.dist.styles + '/style.css')
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(gulp.dest(paths.dist.styles));
};

const minifyScripts = function () {
    return gulp.src(paths.src.scripts + '/script.js')
        .pipe(uglify())
        .pipe(gulp.dest(paths.dist.scripts));
};

const watch = function (done) {
    gulp.watch(paths.watch.styles, gulp.series([styles]));
    gulp.watch(paths.watch.scripts, gulp.series([scripts]));
    done();
};

exports.dev = gulp.parallel([watch]);
exports.default = gulp.series([styles, minifyStyles, scripts, minifyScripts]);
