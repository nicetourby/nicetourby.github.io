// Include gulp
var gulp = require('gulp'); 

// Include Our Plugins
var jshint = require('gulp-jshint');
var uglify = require('gulp-uglify');
var rename = require('gulp-rename');
var concat = require('gulp-concat');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync').create();
var less = require('gulp-less');
var cleanCSS = require('gulp-clean-css');
var path = require('path'); 
var changed = require('gulp-changed');
var plumber = require('gulp-plumber');
var prettify = require('gulp-html-prettify');


var onError = function (err) {  
  console.log(err);
  this.emit('end');
};

gulp.task('prettify', function() {
  gulp.src('./*.html')
  .pipe(prettify({indent_char: ' ', indent_size: 2}))
  .pipe(gulp.dest(''))
});


//less to css compile
gulp.task('less', function () {
  return gulp.src(['assets/less/main.less', 'assets/less/bootstrap.less', 'assets/less/jqueryui.less', 'assets/less/controlpanel.less'])
  .pipe(plumber({
    errorHandler: onError
  }))
  .pipe(sourcemaps.init())
  .pipe(changed('assets/css'))
  .pipe(less({
    paths: [ path.join(__dirname, 'less', 'includes') ]
  }))
  .pipe(sourcemaps.write('.',{includeContent:false, sourceRoot:'../less/'}))
  .pipe(gulp.dest('assets/css'));
});


//minify css
gulp.task('minify-css', function() {
  return gulp.src('assets/css/*.css')
  .pipe(cleanCSS({compatibility: 'ie8'}))
  .pipe(rename({
    suffix: ".min",
    extname: ".css"
  }))
  .pipe(gulp.dest('assets/css/min/'));
});


//lint
gulp.task('scripts', function() {
  return gulp.src('assets/js/*.js')
  .pipe(plumber({
    errorHandler: onError
  }))
  .pipe(jshint())
  .pipe(jshint.reporter('default'))
});

//Minify JS
gulp.task('minify-js', function() {
  return gulp.src('assets/js/*.js')
  .pipe(plumber({
    errorHandler: onError
  }))
  .pipe(uglify())
  .pipe(rename({
    suffix: ".min",
    extname: ".js"
  }))
  .pipe(gulp.dest('assets/js/min'));
});



// Watch Files For Changes
gulp.task('watch', function() {
  browserSync.init({
    server: "./"
  });

  gulp.watch('assets/js/*.js', ['scripts']);
  gulp.watch('assets/less/**/*.less', ['less']);

  gulp.watch("*.html").on('change', browserSync.reload);
  gulp.watch("assets/css/*.css").on('change', browserSync.reload);
});

// Default Task
gulp.task('default', ['less', 'scripts'], function() {
  browserSync.init({
    server: "./"
  });
});

// minify and cleaning html, css and js for production
gulp.task('ready', ['prettify', 'minify-css', 'minify-js']);





