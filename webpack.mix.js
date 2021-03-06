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

mix.scripts([
    'resources/assets/js/app.js',
    'resources/assets/js/drag_dialog.js'
], 'public/js/main.js');
mix.styles([
    'resources/assets/css/normalize.css',
    'resources/assets/css/animate.css',
    'resources/assets/css/login.css'
], 'public/css/login.css');
mix.styles([
    'resources/assets/css/normalize.css',
    'resources/assets/css/animate.css',
    'resources/assets/css/main.css',
    'resources/assets/css/alert.css',
    'resources/assets/css/index_page.css',
    'resources/assets/css/forum.css',
    'resources/assets/css/pagination.css',
    'resources/assets/css/topic_create.css',
    'resources/assets/css/topic.css'
], 'public/css/main.css');
