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

//Admin
//Route::middleware(['auth'])->group(function(){
Route::prefix('admin')->group(function () {
    Route::get('/', 'Admin\DashboardController@index')
        ->name('admin.dashboard');
    Route::prefix('materials')->group(function () {
        //Types
        Route::prefix('types')->group(function () {
            //Index
            Route::get('/', 'Admin\Materials\TypesController@index')
                ->name('admin.materials.types.index');
            //Create
            Route::get('create', 'Admin\Materials\TypesController@create')
                ->name('admin.materials.types.create');
        });
        //Item
        Route::prefix('items')->group(function () {
            //Index
            Route::get('/', 'Admin\Materials\ItemsController@index')
                ->name('admin.materials.items.index');
            Route::get('create', 'Admin\Materials\ItemsController@create')
                ->name('admin.materials.items.create');
        });
    });
});
//});


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
