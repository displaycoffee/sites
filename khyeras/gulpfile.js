/* Required Sources
   ---------------------------------------------- */

var browserSync = require('browser-sync').create(),
	gulp = require('gulp'),
	autoprefixer = require('gulp-autoprefixer'),
	concat = require('gulp-concat'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify');

/* Global Variables
   ---------------------------------------------- */

var phpBBFolder = 'styles';
//var phpBBFolder = 'ext';
var proxyURL = 'http://localhost/sites/khyeras';

/* Styles Configuration
   ---------------------------------------------- */

if (phpBBFolder == 'styles') {

	/* Development Variables
	   ---------------------------------------------- */

	var dev = '_dev/styles/khyeras_v1';
	var devJS = dev + '/template/js';
	var devSass = dev + '/theme/scss';

	/* Distribution Variables
	   ---------------------------------------------- */

	var dist = 'styles/khyeras_v1/';
	var distJS = dist + '/template';
	var distCSS = dist + '/theme';

	/* JavaScript
	   ---------------------------------------------- */
	var jsSources = [
		devJS + '/global-functions.js',
		devJS + '/javascript-functions.js',
		devJS + '/jquery-functions.js',
		devJS + '/profile-functions.js',
		devJS + '/run-functions.js'
	];

	gulp.task('js', function() {
		gulp.src(jsSources)
			.pipe(concat('khyeras.js'))
			.pipe(uglify())
			.pipe(gulp.dest(distJS));
	});

	/* SASS
	   ---------------------------------------------- */

	var sassSources = [
		devSass + '/bidi.scss',
		devSass + '/plupload.scss',
		devSass + '/stylesheet.scss'
	];

	gulp.task('sass', function() {
		gulp.src(sassSources)
			.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
			.pipe(autoprefixer({
	            browsers: ['last 2 versions', 'Explorer >= 10', 'Android >= 4.1', 'Safari >= 7', 'iOS >= 7']
	        }))
			.pipe(gulp.dest(distCSS));
	});

	/* CSS
	   ---------------------------------------------- */

	var cssSources = [distCSS + '/**.css'];

	gulp.task('css', function() {
		gulp.src(cssSources)
			.pipe(browserSync.stream());
	});

	/* Static Files
	   ---------------------------------------------- */

	var staticSources = [
		dev + '/**/*.cfg',
		dev + '/**/*.php',
		dev + '/**/*.html',
		dev + '/**/*.txt',
		dev + '/**/images/*.*',
		dev + '/**/images/**/*.*',
		dev + '/**/fonts/*.*'
	];

	gulp.task('static', function() {
		gulp.src(staticSources)
			.pipe(gulp.dest(dist));
	});

	/* Watch All The Things
	   ---------------------------------------------- */

	gulp.task('watch', function() {
	    browserSync.init({
	        proxy: proxyURL,
	        open: false
	    })
		gulp.watch(jsSources, ['js']);
		gulp.watch(devSass + '/*.scss', ['sass']);
		gulp.watch(cssSources, ['css']);
		gulp.watch(staticSources, ['static']);
	});

	/* Default Gulp Task
	   ---------------------------------------------- */

	gulp.task('default', ['js', 'sass', 'css', 'static', 'watch']);
}

/* Ext Configuration
   ---------------------------------------------- */

if (phpBBFolder == 'ext') {

   	/* Development Variables
   	   ---------------------------------------------- */

   	var dev = '_dev/ext';

   	/* Distribution Variables
   	   ---------------------------------------------- */

   	var dist = 'ext';

   	/* Static Files
   	   ---------------------------------------------- */

   	var staticSources = [
   		dev + '/**/*.*'
   	];

   	gulp.task('static', function() {
   		gulp.src(staticSources)
   			.pipe(gulp.dest(dist));
   	});

   	/* Watch All The Things
   	   ---------------------------------------------- */

   	gulp.task('watch', function() {
   	    browserSync.init({
   	        proxy: proxyURL,
   	        open: false
   	    })
   		gulp.watch(staticSources, ['static']);
   	});

   	/* Default Gulp Task
   	   ---------------------------------------------- */

   	gulp.task('default', ['static', 'watch']);
}
