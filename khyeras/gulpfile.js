/* Required Sources
------------------------------------------------- */

var browserSync = require('browser-sync').create(),
	gulp = require('gulp'),
	autoprefixer = require('gulp-autoprefixer'),
	concat = require('gulp-concat'),
	sass = require('gulp-sass'),
	uglify = require('gulp-uglify');

/* Global Variables
------------------------------------------------- */

var proxyURL = 'http://ocalhost/sites/khyeras';
var styles = 'styles/';
var ext = 'ext/';
var dev = '_dev/';
var khyTheme = 'khyeras_v1';
var khyTheme2 = 'khyeras_light_v1';
var watchers = [];

/* Project Folders
------------------------------------------------- */

var projects = {
	[khyTheme] : {
		'dev_css'     : dev + styles + khyTheme + '/theme/sass',
		'dist_css'    : styles + khyTheme + '/theme',
		'dev_js'      : dev + styles + khyTheme + '/template/js',
		'dist_js'     : styles + khyTheme + '/template',
		'dev_static'  : dev + styles + khyTheme,
		'dist_static' : styles + khyTheme
	},
	[khyTheme2] : {
		'dev_css'     : dev + styles + khyTheme2 + '/theme/sass',
		'dist_css'    : styles + khyTheme2 + '/theme',
		'dev_static'  : dev + styles + khyTheme2,
		'dist_static' : styles + khyTheme2
	},
	'ext' : {
		'dev_static'  : dev + ext,
		'dist_static' : ext
	}
}

/* Project Task Loop
------------------------------------------------- */

for (key in projects) {
	createTask(key);
}

/* Browsersync Init
------------------------------------------------- */

gulp.task('bs', function() {
	browserSync.init({
		proxy : proxyURL,
		open  : false
	})
});

/* Default Gulp Task
------------------------------------------------- */

gulp.task('default', watchers.concat('bs'));

/* Function to loop through projects
------------------------------------------------- */

function createTask(key) {
	if (projects[key]['dev_css']) {
		/* SASS
		------------------------------------------------- */

		var devCSS = projects[key]['dev_css'];
		var distCSS = projects[key]['dist_css'];
		var watcherSass = key + 'sass';
		watchers.push(watcherSass);

		var sassSources = [devCSS + '/compressed/**.scss'];
		var expandedSources = [devCSS + '/expanded/**.scss'];
		var versions = ['last 2 versions', 'Explorer >= 10', 'Android >= 4.1', 'Safari >= 7', 'iOS >= 7'];

		gulp.task(watcherSass, function() {
			gulp.src(sassSources)
				.pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
				.pipe(autoprefixer({browsers: versions}))
				.pipe(gulp.dest(distCSS));
			gulp.src(expandedSources)
				.pipe(sass({outputStyle: 'expanded'}).on('error', sass.logError))
				.pipe(autoprefixer({browsers: versions}))
				.pipe(gulp.dest(distCSS));
		});

		/* CSS
		------------------------------------------------- */

		var cssSources = [distCSS + '/**.css'];
		var watcherCSS = key + 'css';
		watchers.push(watcherCSS);

		gulp.task(watcherCSS, function() {
			gulp.src(cssSources)
				.pipe(browserSync.stream());
		});
	}

	if (projects[key]['dev_js']) {
		/* JavaScript
		------------------------------------------------- */

		var devJS = projects[key]['dev_js'];
		var distJS = projects[key]['dist_js'];
		var watcherJS = key + 'JS';
		watchers.push(watcherJS);

		var jsSources = [
			devJS + '/global-functions.js',
			devJS + '/javascript-functions.js',
			devJS + '/jquery-functions.js',
			devJS + '/profile-functions.js',
			devJS + '/run-functions.js'
		];

		gulp.task(watcherJS, function() {
			gulp.src(jsSources)
				.pipe(concat('khyeras.js'))
				.pipe(uglify())
				.pipe(gulp.dest(distJS));
		});
	}

	if (projects[key]['dev_static']) {
		/* Static Files
		------------------------------------------------- */

		var devStatic = projects[key]['dev_static'];
		var distStatic = projects[key]['dist_static'];
		var watcherStatic = key + 'Static';
		watchers.push(watcherStatic);

		if (key == 'ext') {
			var staticSources = [devStatic + '/**/**/*.*'];
		} else {
			var staticSources = [
				devStatic + '/**/*.cfg',
				devStatic + '/**/*.php',
				devStatic + '/**/*.html',
				devStatic + '/**/*.txt',
				devStatic + '/**/images/*.*',
				devStatic + '/**/images/**/*.*',
				devStatic + '/**/fonts/*.*'
			];
		}

		gulp.task(watcherStatic, function() {
			gulp.src(staticSources)
				.pipe(gulp.dest(distStatic));
		});
	}

	/* Watch All The Things
	------------------------------------------------- */

	var watcherWatch = key + 'watch';
	watchers.push(watcherWatch);

	gulp.task(watcherWatch, function() {
		if (projects[key]['dev_js']) {
			gulp.watch(jsSources, [watcherJS]);
		}
		if (devCSS) {
			gulp.watch(devCSS + '/**/*.scss', [watcherSass]);
			gulp.watch(cssSources, [watcherCSS]);
		}
		if (projects[key]['dev_static']) {
			gulp.watch(staticSources, [watcherStatic]);
		}
	});
}
