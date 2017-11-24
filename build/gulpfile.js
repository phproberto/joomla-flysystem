var gulp      = require('gulp');
var extension = require('./package.json');
var config    = require('./gulp-config.json');
var del       = require('del');

var src = '../src';
var wwwPath = config.wwwDir + '/libraries/flysystem/src';

// Clean
gulp.task('clean', function() {
	return del(wwwPath, {force : true});
});

// Copy
gulp.task('copy', ['clean'], function() {
	return gulp.src(src + '/**',{ base: src })
		.pipe(gulp.dest(wwwPath));
});

// Watch
gulp.task('watch',
	function() {
		gulp.watch(src + '/**',['copy']);
});

gulp.task('default', ['copy', 'watch']);
