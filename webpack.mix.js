const {mix} = require('laravel-mix');


/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

/*mix
    .sass('resources/assets/sass/personal-office.sass', 'public/css')
    .sass('resources/assets/sass/auth.sass', 'public/css')
    .js('resources/assets/scripts/personal-office/app.js', 'public/js');*/
mix
    .sass('resources/assets/sass/auth.sass', 'public/css')
    .sass('resources/assets/unify/design-4/css/main.scss', 'themes/unify/design-4/css')
    .js('resources/assets/unify/design-4/js/common.js', 'themes/unify/design-4/js');

// mix.browserSync('verumtrade.com.local');

if (mix.inProduction()) {
  mix.version();
}
