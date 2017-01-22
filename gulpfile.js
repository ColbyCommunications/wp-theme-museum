const textDomain = 'lunder-institute';
const gulp = require('gulp');
const gutil = require('gulp-util');
const autoprefixer = require('gulp-autoprefixer');
const concat = require('gulp-concat');
const rename = require('gulp-rename');
const sass = require('gulp-sass');
const sourcemaps = require('gulp-sourcemaps');
const gulpWatch = require('gulp-watch');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const browserify = require('browserify');
const uglify = require('gulp-uglify');
const watchify = require('watchify');
const babel = require('babelify');
const watchpaths = { sass: [ 'assets/sass/*.scss', 'assets/sass/**/*.scss' ] };

const sassIncludePaths = [ 'assets/scss', 'node_modules/colby-bootstrap/scss' ];

function compile(watch) {
  const presets = { presets: [ 'es2015', 'react' ] };
  const browserified = browserify('./assets/js/main.js', {
    debug: true
  }).transform(babel, presets);
  const bundler = watchify(browserified);
  const rebundle = () => {
    bundler.bundle().on('error', err => {
      console.error(err);
      this.emit('end');
    }).pipe(
      source(`${textDomain}.js`)
    ).pipe(buffer()).pipe(sourcemaps.init({ loadMaps: true })).pipe(sourcemaps.write('./')).pipe(gulp.dest('./assets'));
  };

  if (watch) {
    bundler.on('update', () => {
      console.log('-> bundling...');
      rebundle();
    });
  }

  console.log('-> bundling...');
  rebundle();
}

function watch() {
  return compile(true);
}

gulp.task(
  'sass',
  () =>
    gulp
      .src('assets/sass/main.scss')
      .pipe(sass({ includePaths: sassIncludePaths }))
      .pipe(rename(`${textDomain}.css`))
      .pipe(gulp.dest('assets'))
);

gulp.task('sass-admin', () => {
  console.log('Running admin sass');
  gulp
    .src('assets/sass-admin/main.scss')
    .pipe(sass({}))
    .pipe(rename(`${textDomain}-admin.css`))
    .pipe(gulp.dest('assets'));
});

gulp.task(
  'sass-compressed',
  () =>
    gulp
      .src('assets/sass/main.scss')
      .pipe(sass({ outputStyle: 'compressed', includePaths: sassIncludePaths }))
      .pipe(rename(`style.css`))
      .pipe(gulp.dest(''))
);

gulp.task(
  'gulpWatch',
  () => gulp.watch(watchpaths.sass, [ 'sass', 'sass-compressed' ])
);

gulp.task(
  'gulpAdminWatch',
  () => gulp.watch('assets/sass-admin/*.scss', [ 'sass-admin' ])
);

gulp.task('build', () => compile());
gulp.task('watch', () => watch());
gulp.task('default', [ 'gulpWatch', 'watch', 'gulpAdminWatch' ]);
