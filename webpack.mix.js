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
mix.sass('resources/assets/sass/app.scss', 'public/css/app.css');
mix.sass('resources/assets/sass/custom_spinner.scss', 'public/css/');


mix.browserSync({
    // browser: "google chrome",
    proxy: 'localhost/pogtank/public'
});
//mix.js('resources/assets/js/my-app.js','public/js');

//Materials
// -- Material Item
// -- -- Create
mix.js(srAdminDir + 'materials/items/js/item_create.js', distAdminDir + 'materials/items/js/')
// -- -- Edit
    .js(srAdminDir + 'materials/items/js/item_edit.js', distAdminDir + 'materials/items/js/')
    // -- --  -- Edit Add Modal
    .js(srAdminDir + 'materials/items/js/item_edit_add_modal.js', distAdminDir + 'materials/items/js');

// -- Material Type
// -- -- Create
mix.js(srAdminDir + 'materials/types/js/type_create.js', distAdminDir + 'materials/types/js')
// -- -- Edit
    .js(srAdminDir + 'materials/types/js/type_edit.js', distAdminDir + 'materials/types/js');

// -- Product
// -- --index
mix.js(srAdminDir + 'product/js/product_index.js', distAdminDir + 'product/js')
// -- --Create
    .js(srAdminDir + 'product/js/product_create.js', distAdminDir + 'product/js');
// Project Order
// -- -- Index
mix.js(srAdminDir + 'project_order/js/project_order_index.js',distAdminDir+'project_order/js')
    .js(srAdminDir + 'project_order/js/project_order_create.js',distAdminDir+'project_order/js')
    .js(srAdminDir + 'project_order/porlor_4/js/porlor_4_index.js',distAdminDir+'project_order/porlor_4/js');
//Porlor 4 Job
mix.js(srAdminDir+'project_order/porlor_4/porlor_4_job/porlor_4_job_index.js',distAdminDir+'project_order/js');
//Porlor 4 Part
//-- --Index
mix.js(srAdminDir+'porlor_4_part/js/porlor_4_part_index.js',distAdminDir+'porlor_4_part/js');


//Test Api
mix.js('resources/views/web/test_api/index.js','public/views/web/test_api/');