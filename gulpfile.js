import {src, dest, watch, series, parallel} from 'gulp'
import * as dartSass from 'sass'
import gulpSass from 'gulp-sass'
import terser from 'gulp-terser'

const sass = gulpSass(dartSass)

export function css(done) {
    src('src/sass/**/*.scss')
    .pipe(sass({outputStyle: "compressed"}))
    .pipe(dest('public/build/css'))
    done()
}

export function js(done) {
    src('src/js/**/*.js')
    .pipe(terser())
    .pipe(dest('public/build/js'))
    done()
}

export function gulp() {
    watch('src/sass/**/*.scss', css)
    watch('src/js/**/*.js', js)
}

export default series(css, js, gulp)