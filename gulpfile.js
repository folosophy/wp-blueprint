var cwd    = process.cwd(),
    gulp   = require('gulp'),
    gaze   = require('gaze'),
    livereload = require('gulp-livereload'),
    file   = '';

var plugins = require('gulp-load-plugins') ({
  pattern: ['gulp-*','yargs','less*'],
  rename: {
    'less-plugin-glob' : 'lessGlob'
  }
});

gulp.task('compileJS',function() {

  return gulp.src('src/js/*.js')
    .pipe(plugins.babel({ presets: ['env'] }))
    .pipe(gulp.dest('assets/js'))
    .pipe(livereload());

});

gulp.task('watchJS',function() {

  livereload.listen();

  var files = [
    'src/js/*.js'
  ];

  return gaze(files, function(err, watcher) {
    this.on('changed',gulp.series('compileJS'));
  });

});
