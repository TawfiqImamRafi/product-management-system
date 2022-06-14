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

mix.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
    .sourceMaps()
    .scripts([
        'node_modules/jquery/dist/jquery.min.js',
        'node_modules/@popperjs/core/dist/umd/popper.min.js',
        'node_modules/bootstrap/dist/js/bootstrap.min.js',
        'node_modules/sweetalert2/dist/sweetalert2.js',
        'resources/js/ajax-submitter.js',
        'resources/js/navigation.js',
        'resources/js/main.js'
    ], 'public/assets/js/vendors.js')
    .styles([
        'node_modules/bootstrap/dist/css/bootstrap.min.css',
        'node_modules/boxicons/css/boxicons.min.css',
        'node_modules/sweetalert2/dist/sweetalert2.css',
    ], 'public/assets/css/vendors.css')
    .copy('node_modules/boxicons/fonts', 'public/assets/fonts');
