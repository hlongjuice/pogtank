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



//Admin
// -- Add new Admin
Route::post('register_admin','AdminController@store')
    ->name('register_admin.store');
// -- Admin All Method
Route::prefix('admin')->middleware('auth')
    ->group(function () {
    Route::get('/', 'Admin\DashboardController@index')
        ->name('admin.dashboard');
    //-- --Material
    Route::prefix('materials')->group(function () {
        //-- -- --  Material Types
        Route::prefix('types')->group(function () {
            // -- -- -- Index
            Route::get('/', 'Admin\Materials\TypesController@index')
                ->name('admin.materials.types.index');
            // -- -- --Index After Submit
            Route::get('submitted','Admin\Materials\TypesController@indexAfterSubmit')
                ->name('admin.materials.types.indexAfterSubmit');
            // -- -- --Create
            Route::get('create', 'Admin\Materials\TypesController@create')
                ->name('admin.materials.types.create');
            // -- -- --Edit
            Route::get('edit/{id}','Admin\Materials\TypesController@edit')
                ->name('admin.materials.types.edit');
            // -- -- --Update
            Route::put('/{id}','Admin\Materials\TypesController@update')
                ->name('admin.materials.types.update');
            // -- -- --Store
            Route::post('/','Admin\Materials\TypesController@store')
                ->name('admin.materials.types.store');
            // -- -- --Delete
            Route::delete('/{id}','Admin\Materials\TypesController@destroy')
                ->name('admin.materials.types.destroy');
        });

        //-- --Material Items
        Route::prefix('items')->group(function () {
            // -- -- --Index
            Route::get('/', 'Admin\Materials\ItemsController@index')
                ->name('admin.materials.items.index');
            // -- -- --Index After Submit
            Route::get('submitted/{status}','Admin\Materials\ItemsController@indexAfterSubmit')
                ->name('admin.materials.items.indexAfterSubmit');
            // -- -- --Create
            Route::get('create', 'Admin\Materials\ItemsController@create')
                ->name('admin.materials.items.create');
            // -- -- --Edit
            Route::get('edit/{id}','Admin\Materials\ItemsController@edit')
                ->name('admin.materials.items.edit');
            // -- -- --EditRequested
            Route::get('edit_requested/{id}','Admin\Materials\ItemsController@editRequested')
                ->name('admin.materials.items.editRequested');
            // -- -- --Update
            Route::post('/{id}','Admin\Materials\ItemsController@update')
                ->name('admin.materials.items.update');
            // -- -- --Store
            Route::post('/','Admin\Materials\ItemsController@store')
                ->name('admin.materials.items.store');
            // -- -- --Delete
            Route::delete('/{id}','Admin\Materials\ItemsController@destroy')
                ->name('admin.materials.items.destroy');
            // -- -- --Get Districts by Amphoe
            Route::get('districts/{id}','Admin\Materials\ItemsController@getDistricts')
                ->name('admin.materials.item.getDistricts');
        });
    });
});

