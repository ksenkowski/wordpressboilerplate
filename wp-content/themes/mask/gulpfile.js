// REQUIRES
var gulp = require('gulp'),
    sass = require('gulp-sass'),
    autoprefixer = require('autoprefixer'),
    uglify = require('gulp-uglify'),
    concat = require('gulp-concat'),
    imagemin = require('gulp-imagemin'),
    svgmin = require('gulp-svgmin'),
    del = require('del'),
    runSequence = require('run-sequence'),
    plumber = require('gulp-plumber'),
    notify = require('gulp-notify'),
    util = require('gulp-util'),
    postcss = require('gulp-postcss');

// PATHS
var root = '';
var paths = {
  src: root + 'src',
  dist: root + 'dist',
  scss: root + 'src/scss',
  jssrc: root + 'src/js-src',
  imgsrc: root + 'src/img-src',
  fontssrc: root + 'src/fonts-src',
  css: root + 'dist/css',
  js: root + 'dist/js',
  img: root + 'dist/img',
  fonts: root + 'dist/fonts'
};

// ERROR HANDLING
var errorHandler = {
  errorHandler: notify.onError({
    title: 'Gulp',
    message: 'Error: <%= error.message %>'
  })
};

// SASS
gulp.task('sass', function(){
  gulp
    .src(paths.scss + '/**/*.scss')
    .on('error', sass.logError)
    .pipe(sass())
    .pipe(postcss([
      autoprefixer({ browsers: ['last 2 versions'] })
    ], { syntax: require('postcss-scss') }))
    .pipe(gulp.dest(paths.css))
});

// JAVASCRIPT
gulp.task('javascript', function(){
  gulp.src([paths.jssrc + '/**/*', !paths.jssrc + '/thirdparty/**/*'])
      .pipe(uglify())
      .on('error', function (err) { util.log(util.colors.red('[Error]'), err.toString()); })
      // .pipe(concat('main.js'))
      .pipe(gulp.dest(paths.js));
});

// IMAGES TASK
gulp.task('images', function(){
  gulp.src(paths.imgsrc + '/**/*.{jpg,png,gif,ico}')
    .pipe(imagemin({
      optimizationLevel: 7,
      progressive: true
    }))
    .pipe(gulp.dest(paths.img));
  gulp.src(paths.imgsrc + '/**/*.svg')
    .pipe(svgmin())
    .pipe(gulp.dest(paths.img));
});

// FONTS TASK
gulp.task('fonts', function(){
  gulp.src(paths.fontssrc + '/**/*')
      .pipe(gulp.dest(paths.fonts));
});

// CLEAN TASK
gulp.task('clean', function(){
  del([
    paths.css + '/*',
    paths.js + '/*',
    paths.img + '/*'
  ]);
});

// PRODUCTION BUILD TASK
gulp.task('build', function(buildDone){
  runSequence(
    'clean',
    'fonts',
    'javascript',
    'images',
    'sass',
    buildDone
  );
});

// WATCH TASK
gulp.task('watch', function(){
  gulp.watch(paths.scss + '/**/*.scss', ['sass']);
  gulp.watch(paths.jssrc + '/**/*', ['javascript']);
  gulp.watch(paths.imgsrc + '/**/*', ['images']);
});

// DEFAULT TASK
gulp.task('default', function(defaultDone){
  runSequence(
    'build',
    'watch',
    defaultDone
  );
});


