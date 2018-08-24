let mix = require('laravel-mix');

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

//mix.js('resources/assets/js/app.js', 'public/js');
mix.styles([
    'resources/assets/css/normalize.css',
    'resources/assets/css/animate.css',
    'resources/assets/css/login.css'
], 'public/css/login.css');
mix.styles([
    'resources/assets/css/normalize.css',
    'resources/assets/css/animate.css',
    'resources/assets/css/main.css',
    'resources/assets/css/index_page.css',
    'resources/assets/css/forum.css',
    'resources/assets/css/pagination.css'
], 'public/css/main.css');
