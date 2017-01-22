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

//var wpFolder = 'themes';
//var dirName = 'musescircle';
var wpFolder = 'plugins';
var dirName = 'inspire-reviews';
var proxyURL = 'http://localhost/sites/themusescircle';

/* Development Variables
   ---------------------------------------------- */

var dev = 'dev/' + wpFolder + '/' + dirName;
var devJS = dev + '/assets/js';
var devSass = dev + '/assets/scss';

/* Distribution Variables
   ---------------------------------------------- */

var dist = 'wp-content/' + wpFolder + '/' + dirName;
var distJS = dist + '/assets/js';

// CSS location is different for themes, so let's add a conditonal
if (wpFolder == 'themes') {
	var distCSS = dist;
} else {
	var distCSS = dist + '/assets/css';
}

/* JavaScript
   ---------------------------------------------- */

// JS files are different for folders, so let's add a conditonal
if (dirName == 'musescircle') {
	var jsSources = [		
		devJS + '/owl-carousel.js',
		devJS + '/swipebox.js',
		devJS + '/main.js',
		devJS + '/run-functions.js'
	];
} else if (wpFolder == 'plugins') {
	var jsSources = [	
		devJS + '/image-reset.js',
		devJS + '/media-library.js',
		devJS + '/run-functions.js'
	];
}

gulp.task('js', function() {
	gulp.src(jsSources)
		.pipe(concat('functions.js'))
		.pipe(uglify())
		.pipe(gulp.dest(distJS));
});

/* SASS
   ---------------------------------------------- */

var sassSources = [devSass + '/style.scss'];

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
	dev + '/**/*.php',
	dev + '/**/*.txt',
	dev + '/**/images/*.*',
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