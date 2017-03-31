// Define variables.
var autoprefixer = require('autoprefixer');
var browserSync  = require('browser-sync').create();
var cleancss     = require('gulp-clean-css');
var concat       = require('gulp-concat');
var del          = require('del');
var gulp         = require('gulp');
var gutil        = require('gulp-util');
var imagemin     = require('gulp-imagemin');
var notify       = require('gulp-notify');
var postcss      = require('gulp-postcss');
var rename       = require('gulp-rename');
var run          = require('gulp-run');
var runSequence  = require('run-sequence');
var sass         = require('gulp-ruby-sass');
var uglify       = require('gulp-uglify');

//Inculde paths file
var paths = require('./assets/config/paths');

gulp.task( 'browser-sync', function() {
  browserSync.init( {
    proxy: paths.siteDir,

    // `true` Automatically open the browser with BrowserSync live server.
    // `false` Stop the browser from automatically opening.
    open: false,

    // Inject CSS changes.
    // Commnet it to reload browser for every CSS change.
    injectChanges: true,

    // Use a specific port (instead of the one auto-detected by Browsersync).
    // port: 7000,

  } );
});


//Create main.css file
gulp.task('styles', function(){
	return sass(paths.sassFiles + '/style.scss', {
		style: 'compressed',
		trace: true,
		loadPath: [paths.sassFiles]
	}).pipe(postcss([autoprefixer({browsers: ['last 2 versions'] })]))
		.pipe(cleancss())
		// .pipe(gulp.dest(paths.jekyllCssFiles))
		.pipe(gulp.dest('./'))
		.pipe(browserSync.stream())
		.on('error', gutil.log);
});

//Delete CSS
gulp.task('clean', function(callback) {
    del(['./style.css', './scripts.js', './assets/img/' + paths.imagePattern ]);
    callback();
});


//Process JS
gulp.task('scripts', function(){
	return gulp.src([
		paths.jsFiles + '/libs' + paths.jsPattern,
		paths.jsFiles + '/*.js'
	]).pipe(concat('scripts.js'))
		.pipe(uglify())
		.pipe(gulp.dest('./'))
	.on('error', gutil.log);
});

//Optimize and copy over images
gulp.task('images', function(){
	return gulp.src(paths.imageFilesGlob)
		.pipe(imagemin())
		.pipe(gulp.dest('./assets/img/'))
	.pipe(browserSync.stream());
});

// Static Server + watching files.
// Note: passing anything besides hard-coded literal paths with globs doesn't
// seem to work with gulp.watch().
	gulp.task('default', ['clean', 'styles', 'scripts', 'images', 'browser-sync'], function() {

	    // Watch .scss files; changes are piped to browserSync.
	    gulp.watch('./assets/css/**/*.scss', ['styles']);

	    // Watch .js files.
	    gulp.watch('./assets/js/**/*.js', ['scripts']);

	    // Watch image files; changes are piped to browserSync.
	    gulp.watch('./assets/img/**/*', ['images']);

	});
