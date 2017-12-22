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
//sr = 'source', dist='distribute'
let srAdminDir = 'resources/views/admin/';
let distAdminDir = "public/views/admin/";
mix.js('resources/assets/js/app.js', 'public/js');
mix.sass('resources/assets/sass/app.scss', 'public/css');
mix.browserSync({
    browser: "google chrome",
    proxy: 'localhost/pogtank/public'
});
//mix.js('resources/assets/js/my-app.js','public/js');

//Materials
// -- Material Item
// -- -- Create
mix.js(srAdminDir + 'materials/items/js/item_create.js', distAdminDir + 'materials/items/js/');
// -- -- Edit
mix.js(srAdminDir+'materials/items/js/item_edit.js',distAdminDir+'materials/items/js/');
// -- --  -- Edit Add Modal
mix.js(srAdminDir+'materials/items/js/item_edit_add_modal.js',distAdminDir+'materials/items/js');

// -- Material Type
// -- -- Create
mix.js(srAdminDir + 'materials/types/js/type_create.js', distAdminDir + 'materials/types/js');
// -- -- Edit
mix.js(srAdminDir+'materials/types/js/type_edit.js',distAdminDir+'materials/types/js');
