const mix = require('laravel-mix');
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

// Autoload jquery for other vendor libs that require it (bootstrap)
mix.autoload({
    'jquery': ['window.jQuery', 'jQuery', '$']
});

// js assets
mix.js('resources/js/app.js', 'public/js')
    .extract([
        'axios',
        'bootstrap',
        'jquery',
        'lodash',
        'vue',
        'vee-validate',
        'three/build/three.min'
    ]);

// sass assets
mix.sass('resources/sass/app.scss', 'public/css');

// add sourcemaps for debugging
mix.sourceMaps();

// if we're compiling production lets also version the files
if (mix.inProduction()) {
    mix.version();
}
