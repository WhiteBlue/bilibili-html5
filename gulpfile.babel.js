import gulp from 'gulp';
import browserify from 'browserify';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';
import babelify from 'babelify';
import uglify from 'gulp-uglify';
import rimraf from 'rimraf';
import sourcemaps from 'gulp-sourcemaps';
import cleancss from 'gulp-clean-css';
import imagemin from 'gulp-imagemin';
import pngquant from 'imagemin-pngquant';
import runSequence from 'run-sequence';
import ghPages from 'gulp-gh-pages';

const paths = {
  bundle: 'app.js',
  entry: 'src/js/Index.js',
  srcCss: 'src/styles/*.css',
  srcImg: 'src/images/**',
  srcLint: ['src/**/*.js', 'test/**/*.js'],
  distCss: 'dist/css',
  distJs: 'dist/js',
  distImg: 'dist/img'
};


gulp.task('clean', cb => {
  rimraf('dist', cb);
});


gulp.task('browserify', () => {
  browserify(paths.entry, {debug: false})
    .transform(babelify)
    .bundle()
    .pipe(source(paths.bundle))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(gulp.dest(paths.distJs));
});

gulp.task('browserify_debug', () => {
  browserify(paths.entry, {debug: true})
    .transform(babelify)
    .bundle()
    .pipe(source(paths.bundle))
    .pipe(buffer())
    .pipe(sourcemaps.init({loadMaps: true}))
    .pipe(uglify())
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest(paths.distJs));
});

gulp.task('styles', () => {
  gulp.src(paths.srcCss)
    .pipe(cleancss({advanced: false}))
    .pipe(gulp.dest(paths.distCss))
});

gulp.task('images', () => {
  gulp.src(paths.srcImg)
    .pipe(imagemin({
      progressive: true,
      svgoPlugins: [{removeViewBox: false}],
      use: [pngquant()]
    }))
    .pipe(gulp.dest(paths.distImg));
});

gulp.task('watchTask', () => {
  gulp.watch(paths.srcCss, ['styles']);
});


gulp.task('build', cb => {
  process.env.NODE_ENV = 'production';
  runSequence('clean', ['browserify', 'styles', 'images', 'copyAssets'], cb);
});


gulp.task('source', cb=> {
  process.env.NODE_ENV = 'debug';
  runSequence('clean', ['browserify_debug', 'styles', 'images', 'copyAssets'], cb);
});


gulp.task('copyAssets', ()=> {
  gulp.src([
    'assets/js/*'
  ]).pipe(buffer())
    .pipe(uglify())
    .pipe(gulp.dest('dist/js'));

  gulp.src([
    'assets/css/*'
  ]).pipe(cleancss({advanced: false}))
    .pipe(gulp.dest('dist/css'));

  gulp.src([
    'favicon.ico'
  ]).pipe(gulp.dest('dist'));

  gulp.src([
    'src/index.html'
  ]).pipe(gulp.dest('dist'));
});


gulp.task('deploy', () => {
  gulp.src('dist/**/**')
    .pipe(ghPages());
});
