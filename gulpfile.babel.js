import gulp from 'gulp';
import autoprefixer from 'autoprefixer';
import browserify from 'browserify';
import watchify from 'watchify';
import source from 'vinyl-source-stream';
import buffer from 'vinyl-buffer';
import babelify from 'babelify';
import uglify from 'gulp-uglify';
import rimraf from 'rimraf';
import sourcemaps from 'gulp-sourcemaps';
import postcss from 'gulp-postcss';
import rename from 'gulp-rename';
import nested from 'postcss-nested';
import vars from 'postcss-simple-vars';
import extend from 'postcss-simple-extend';
import cssnano from 'cssnano';
import imagemin from 'gulp-imagemin';
import pngquant from 'imagemin-pngquant';
import runSequence from 'run-sequence';
import ghPages from 'gulp-gh-pages';

const paths = {
  bundle: 'app.js',
  entry: 'src/js/Index.js',
  srcCss: 'src/styles/*.scss',
  srcImg: 'src/images/**',
  srcLint: ['src/**/*.js', 'test/**/*.js'],
  distCss: 'dist/css',
  distJs: 'dist/js',
  distImg: 'dist/img'
};

const customOpts = {
  entries: [paths.entry],
  debug: true
};

const opts = Object.assign({}, watchify.args, customOpts);

gulp.task('clean', cb => {
  rimraf('dist', cb);
});


gulp.task('watchify', () => {
  const bundler = watchify(browserify(opts));

  function rebundle() {
    return bundler.bundle()
      .pipe(source(paths.bundle))
      .pipe(buffer())
      .pipe(gulp.dest(paths.distJs))
  }

  bundler.transform(babelify)
    .on('update', rebundle);
  return rebundle();
});

gulp.task('browserify', () => {
  browserify(paths.entry, {debug: true})
    .transform(babelify)
    .bundle()
    .pipe(source(paths.bundle))
    .pipe(buffer())
    .pipe(uglify())
    .pipe(gulp.dest(paths.distJs));
});

gulp.task('styles', () => {
  gulp.src(paths.srcCss)
    .pipe(rename({extname: '.css'}))
    .pipe(postcss([vars, extend, nested, autoprefixer, cssnano]))
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

gulp.task('watch', cb => {
  runSequence('clean', ['watchTask', 'watchify', 'styles'], cb);
});

gulp.task('build', cb => {
  process.env.NODE_ENV = 'production';
  runSequence('clean', ['browserify', 'styles', 'images'], cb);
});


gulp.task('copyAssets', ()=> {
  gulp.src([
    'assets/js/*'
  ]).pipe(gulp.dest('dist/js'));

  gulp.src([
    'assets/css/*'
  ]).pipe(gulp.dest('dist/css'));

  gulp.src([
    'favicon.ico'
  ]).pipe(gulp.dest('dist'));

  gulp.src([
    'index.html'
  ]).pipe(gulp.dest('dist'));
});


gulp.task('deploy', () => {
  gulp.src('dist/**/**')
    .pipe(ghPages());
});
