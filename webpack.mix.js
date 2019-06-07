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

if (process.env.NODE_ENV !== 'testing') {
    // add sourcemaps for debugging
    mix.sourceMaps();

    // version our files so we can cache them long term
    mix.version();
}

// Autoload jquery for other vendor libs that require it (bootstrap)
mix.autoload({
    'jquery': ['window.jQuery', 'jQuery', '$']
});

// if we are testing don't extract js
if (process.env.NODE_ENV === 'testing') {
    mix.js('resources/js/app.js', 'public/js')
        .copy('resources/js/app.js', 'public/main.js');
} else {
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
}

// sass assets
mix.sass('resources/sass/app.scss', 'public/css');



