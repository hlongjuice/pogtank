'use strict';

var mix = require('laravel-mix');

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

mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.browserSync({
  browser: "google chrome",
  proxy: 'localhost/pogtank/public'
});
mix.js('resource/views/admin/materials/items/js/item-create.js', 'public/js');
//# sourceMappingURL=webpack.mix.js.map