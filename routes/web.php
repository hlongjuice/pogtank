<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('my_test', 'MyTestController@getText');
Route::get('my_job', 'Admin\Project\ProjectController@getAllProjectOrders');


//Test Api
Route::prefix('test_api')->group(function () {
    Route::get('/get_item', 'TestApi@getItems');
    Route::get('/edit', 'TestApi@editItem')
        ->name('test_api.edit');
    Route::delete('/delete/{id}', 'TestApi@delete')
        ->name('test_api.delete');
});
Route::put('test_api/update_item/{id}', 'TestApi@updateItems')
    ->name('test_api.update_item');

//Log
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


//Admin
// -- Add new Admin
Route::post('register_admin', 'AdminController@store')
    ->name('register_admin.store');
// -- Admin All Method
Route::prefix('admin')->middleware('auth')
    ->group(function () {
        Route::get('/', 'Admin\DashboardController@index')
            ->name('admin.dashboard');
        //-- -- Product
        Route::prefix('product')->group(function () {
            // -- --Index
            Route::get('/', 'Admin\Product\ProductController@index')->name('admin.product.index');
            // -- --Create
            Route::get('/create', 'Admin\Product\ProductController@create')->name('admin.product.create');
            // -- --Add New Product
            Route::post('/add_new_product', 'Admin\Product\ProductController@addNewProduct');
            // -- --Get Products
            Route::get('/get_all_products', 'Admin\Product\ProductController@getAllProducts');
            // -- --Get All Product with Page
            Route::get('/get_all_products_with_pages', 'Admin\Product\ProductController@getAllProductsWithPages');
        });
        //-- -- Project Order
        Route::prefix('project_order')->group(function () {
            // -- -- --Index
            Route::get('/', 'Admin\Project\ProjectController@index')->name('admin.project_order.index');
            // -- -- --Create
            Route::get('/create', 'Admin\Project\ProjectController@create')->name('admin.project_order.create');
            // -- -- --Add new Order
            Route::post('/add_new_order', 'Admin\Project\ProjectController@addNewOrder');
            // -- -- --Get Project Details
            Route::get('/get_project_details/{project_order_id}', 'Admin\Project\ProjectController@getProjectDetails');
            // -- -- --Get All Project Order
            Route::get('/get_all_orders', 'Admin\Project\ProjectController@getAllProjectOrders');
            // -- -- --Update Project Details
            Route::put('/update_project_details', 'Admin\Project\ProjectController@updateDetails');
            // -- -- --Delete Project
            Route::delete('/delete_project/{id}', 'Admin\Project\ProjectController@deleteProject');
            // -- --Por lor 4
            Route::prefix('{order_id}/porlor_4')->group(function () {
                //-- -- --Index
                Route::get('/', 'Admin\Project\Porlor4Controller@index')->name('admin.project_order.porlor_4');
                // -- -- --Add Part
                Route::post('/add_part', 'Admin\Project\Porlor4Controller@addNewPart');
                // -- -- --Get Project Details
                Route::get('/get_project_details', 'Admin\Project\Porlor4Controller@getProjectDetails');
                // -- -- --Get All Porlor 4 Parts
                Route::get('/get_all_parts', 'Admin\Project\Porlor4Controller@getAllParts');
            });
            // -- -- -- Update Part
            Route::put('porlor_4/update_part', 'Admin\Project\Porlor4Controller@updatePart');
            // -- -- -- Delete Part
            Route::delete('porlor_4/delete_part/{porlor_4_id}', 'Admin\Project\Porlor4Controller@deletePart');
            // -- -- -- Porlor 4 Jobs
            Route::prefix('porlor_4_id/{porlor_4_id}')->group(function () {
                // -- -- -- --Index
                Route::get('jobs', 'Admin\Project\Porlor4JobController@index')->name('admin.project_order.porlor_4.job.index');
                // -- -- -- -- Get All Jobs
                Route::get('get_all_root_jobs', 'Admin\Project\Porlor4JobController@getAllRootJobs');
                // -- -- --- -- Get All Child Jobs
                Route::get('get_all_child_jobs/{root_job_id}', 'Admin\Project\Porlor4JobController@getAllChildJobs');
                // -- -- -- -- Get All Child Jobs
                Route::get('get_all_child_jobs_v2/{root_job_id}', 'Admin\Project\Porlor4JobController@getAllChildJobsV2');
                // -- -- -- -- Get All Child Jobs WithOut Items
                Route::get('get_all_child_jobs_without_items/{root_job_id}', 'Admin\Project\Porlor4JobController@getAllChildJobsWithOutItems');
                // -- -- -- -- Get All Leaf Jobs
                Route::get('get_all_leaf_jobs/{root_job_id}', 'Admin\Project\Porlor4JobController@getAllLeafJobs');
                // -- -- --- -- Get Parents Job
                Route::get('get_parent_jobs/{parent_root_id}', 'Admin\Project\Porlor4JobController@getParentJobs');
                // -- -- -- -- Get Part Details
                Route::get('get_part_details', 'Admin\Project\Porlor4JobController@getPartDetails');
                // -- -- -- -- Add Root Job
                Route::post('add_root_job', 'Admin\Project\Porlor4JobController@addRootJob');
                // -- -- -- -- Add Child Job
                Route::post('add_child_job/{parent_id}', 'Admin\Project\Porlor4JobController@addChildJob');
                // -- -- -- -- Add Child Job Item
                Route::post('add_child_job_item', 'Admin\Project\Porlor4JobController@addChildJobItems');
                // -- -- -- -- Add Child Job Item V2
                Route::post('add_child_job_item_v2', 'Admin\Project\Porlor4JobController@addChildJobItemsV2');
                // -- -- -- -- Add Child Job With Details
                Route::post('add_child_job_with_details/{parent_id}', 'Admin\Project\Porlor4JobController@addChildJobWithDetails');
                // -- -- -- -- Edit Child Job
                Route::put('edit_child_job/{parent_id}', 'Admin\Project\Porlor4JobController@editChildJob');
                // -- -- --- --Delete Item
                Route::delete('delete_item/{item_id}', 'Admin\Project\Porlor4JobController@deleteItem');
                // -- -- -- --Delete Job
                Route::delete('delete_child_job/{job_id}', 'Admin\Project\Porlor4JobController@deleteChildJob');
                // -- -- -- --Delete Root Job
                Route::delete('delete_root_job/{root_job_id}', 'Admin\Project\Porlor4JobController@deleteRootJob');
                // -- -- -- --Update Child Job
                Route::put('update_child_job', 'Admin\Project\Porlor4JobController@updateChildJob');
                // -- -- -- --Update Child Job Item
                Route::put('update_child_job_item', 'Admin\Project\Porlor4JobController@updateChildJobItem');
                // -- -- -- --Update Root Job
                Route::put('update_root_job', 'Admin\Project\Porlor4JobController@updateRootJob');
            });
            // -- -- -- Porlor 5
            Route::prefix('{project_order_id}/porlor_5')->group(function () {
                Route::get('/', 'Admin\Project\Porlor5\Porlor5Controller@getPorlor5');
                //Move To Previous Page
                Route::put('porlor4/move_to_previous_page/{porlor4_id}', 'Admin\Project\Porlor5\Porlor5Controller@moveToPreviousPage');
                //Move to Next Page
                Route::put('porlor4/move_to_next_page/{porlor4_id}','Admin\Project\Porlor5\Porlor5Controller@moveToNextPage');
            });
            // -- -- -- Porlor 6
            Route::prefix('{project_order_id}/porlor_6')->group(function(){
               Route::get('/','Admin\Project\Porlor6\Porlor6Controller@getPorlor6');
            });
        });

        // -- -- Porlor 4 Part
        Route::prefix('porlor_4_parts')->group(function () {
            //index
            Route::get('/', 'Admin\Project\Porlor4PartController@index')->name('admin.porlor_4_part.index');
            //Add new Part
            Route::post('/add_new_part', 'Admin\Project\Porlor4PartController@addNewPart');
            //Get All Parts
            Route::get('/get_all', 'Admin\Project\Porlor4PartController@getAll');
            //Get Available Parts
            Route::get('/get_available_parts/{project_order_id}/porlor_4/{porlor_4_id}', 'Admin\Project\Porlor4PartController@getAvailablePart');
        });
        //-- --Material
        Route::prefix('materials')->group(function () {
            //-- -- --  Material Types
            Route::prefix('types')->group(function () {
                // -- -- -- Index
                Route::get('/', 'Admin\Materials\TypesController@index')
                    ->name('admin.materials.types.index');
                // -- -- --Index After Submit
                Route::get('submitted', 'Admin\Materials\TypesController@indexAfterSubmit')
                    ->name('admin.materials.types.indexAfterSubmit');
                // -- -- --Create
                Route::get('create', 'Admin\Materials\TypesController@create')
                    ->name('admin.materials.types.create');
                // -- -- --Edit
                Route::get('edit/{id}', 'Admin\Materials\TypesController@edit')
                    ->name('admin.materials.types.edit');
                // -- -- --Update
                Route::put('/{id}', 'Admin\Materials\TypesController@update')
                    ->name('admin.materials.types.update');
                // -- -- --Store
                Route::post('/', 'Admin\Materials\TypesController@store')
                    ->name('admin.materials.types.store');
                // -- -- --Delete
                Route::delete('/{id}', 'Admin\Materials\TypesController@destroy')
                    ->name('admin.materials.types.destroy');
                // -- -- --Get Type Tree
                Route::get('/get_material_type_tree', 'Admin\Materials\TypesController@materialTypesTree');
                // -- -- --Get Parent Type
                Route::get('/get_material_parent_type', 'Admin\Materials\TypesController@materialParentTypes');
                // -- -- --Get Type
                Route::get('get_material_type/{id}', 'Admin\Materials\TypesController@getMaterialType');
                // -- -- --Get Parent Sibling Types
                Route::get('get_material_parent_sibling_types/{id}', 'Admin\Materials\TypesController@materialParentSiblingTypes');

            });
            //-- --Material Items
            Route::prefix('items')->group(function () {
                // -- -- --Add Local Prices
                Route::post('add_local_prices', 'Admin\Materials\ItemsController@addLocalPrice');
                // -- -- --Index
                Route::get('/', 'Admin\Materials\ItemsController@index')
                    ->name('admin.materials.items.index');
                // -- -- --Index After Submit
                Route::get('submitted/{status}', 'Admin\Materials\ItemsController@indexAfterSubmit')
                    ->name('admin.materials.items.indexAfterSubmit');
                // -- -- --Create
                Route::get('create', 'Admin\Materials\ItemsController@create')
                    ->name('admin.materials.items.create');
                // -- -- --Edit
                Route::get('edit/{id}', 'Admin\Materials\ItemsController@edit')
                    ->name('admin.materials.items.edit');
                // -- -- --EditRequested
                Route::get('edit_requested/{id}', 'Admin\Materials\ItemsController@editRequested')
                    ->name('admin.materials.items.editRequested');
                // -- -- --Update
                Route::put('/{id}', 'Admin\Materials\ItemsController@update')
                    ->name('admin.materials.items.update');
                // -- -- --Update Local Price Details
                Route::put('/update_local_price_details/{id}', 'Admin\Materials\ItemsController@updateLocalPriceDetails');
                // -- -- --Update Global Details Values
                Route::put('/update_global_details', 'Admin\Materials\ItemsController@updateGlobalDetails');
                // -- -- --Update Global Details Status
                Route::put('/update_global_details_status/{id}', 'Admin\Materials\ItemsController@updateGlobalDetailsStatus')
                    ->name('admin.materials.items.updateGlobalDetailsStatus');
                // -- -- --Update Local Price Status
                Route::put('/{material_id}/update_local_price', 'Admin\Materials\ItemsController@updateLocalPriceStatus')
                    ->name('admin.materials.items.updateLocalPriceStatus');
                // -- -- --Store
                Route::post('/', 'Admin\Materials\ItemsController@store')
                    ->name('admin.materials.items.store');
                //-- -- --Delete Waiting Local Price
                Route::delete('local_price/{id}/waiting_local_price', 'Admin\Materials\ItemsController@deleteWaitingLocalPrice')
                    ->name('admin.materials.items.deleteWaitingLocalPrice');
                // -- -- **Delete
                Route::delete('/{id}', 'Admin\Materials\ItemsController@destroy')
                    ->name('admin.materials.items.destroy');
                // -- -- --Delete Waiting Global
                Route::delete('/{material_id}/waiting_global_details/{id}', 'Admin\Materials\ItemsController@deleteWaitingGlobalDetails')
                    ->name('admin.materials.items.deleteWaitingGlobalDetails');
                // -- -- --Delete Local Price
                Route::delete('/delete_local_price/{id}', 'Admin\Materials\ItemsController@deleteLocalPrice');
                // -- -- --Delete Waiting Local Price
                Route::delete('/delete_waiting_local_price/{id}', 'Admin\Materials\ItemsController@deleteWaitingLocalPrices');
                // -- -- --Get Districts by Amphoe
                Route::get('districts/{id}', 'Admin\Materials\ItemsController@getDistricts')
                    ->name('admin.materials.item.getDistricts');
                // -- -- --Get Global Details
                Route::get('edit/global_details/{id}', 'Admin\Materials\ItemsController@getGlobalDetails')
                    ->name('admin.material.item.getGlobalDetails');
                // -- -- --Get Approved Local Price
                Route::get('edit/{id}/approved_local_prices', 'Admin\Materials\ItemsController@getApprovedLocalPrices')
                    ->name('admin.materials.item.getApprovedLocalPrices');
                // -- -- --Get Waiting Local Price
                Route::get('edit/{id}/waiting_local_prices', 'Admin\Materials\ItemsController@getWaitingLocalPrices')
                    ->name('admin.materials.item.getWaitingLocalPrices');
                // -- -- --Get Item of Type
                Route::get('get_items_of_type/{type_id}', 'Admin\Materials\ItemsController@getItemsOfType');
                // -- -- --Search Item of Types By Name
                Route::post('search_items_of_type_by_name/{type_id}', 'Admin\Materials\ItemsController@searchItemsOfTypeByName');
            });
            //-- --New Material Items Route
            Route::prefix('new_items')->group(function () {
                //Add New Other Item
                Route::post('add_new_other_item', 'Admin\Materials\NewItemsController@addNewOtherItem');
                // Delete Approved Items
                Route::delete('delete_approved_items', 'Admin\Materials\NewItemsController@deleteApprovedItems');
                // Delete Waiting Items
                Route::delete('delete_waiting_items', 'Admin\Materials\NewItemsController@deleteWaitingItems');
                //Get First 50 Items
                Route::get('get_items', 'Admin\Materials\NewItemsController@getApprovedItems');
                //Get Approved Items By Page
                Route::get('get_approved_items_by_page', 'Admin\Materials\NewItemsController@getApprovedItemsByPage');
                //Get First 50 Waiting Items
                Route::get('get_waiting_items', 'Admin\Materials\NewItemsController@getWaitingItems');
                //Search Items By Name
                Route::post('search_items_by_name', 'Admin\Materials\NewItemsController@searchItemsByName');
            });
            //-- --Provinces
            Route::prefix('city')->group(function () {
                Route::get('/provinces', 'Admin\City\CityController@getProvinces');
            });
        });
    });

