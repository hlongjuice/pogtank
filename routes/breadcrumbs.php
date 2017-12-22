<?php

//DashBoard
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('DashBoard', route('admin.dashboard'));
});

//Materials Types
Breadcrumbs::register('materialTypes', function ($breadcrumbs) {
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('หมวดหมู่วัสดุ/อุปกรณ์', route('admin.materials.types.index'));
});
// -- create
Breadcrumbs::register('materialTypeCreate',function($breadcrumbs){
   $breadcrumbs->parent('materialTypes');
   $breadcrumbs->push('Create',route('admin.materials.types.create'));
});
// -- edit
Breadcrumbs::register('materialTypeEdit',function ($breadcrumbs,$oldType){
   $breadcrumbs->parent('materialTypes');
   $breadcrumbs->push('Edit - '.$oldType->name,route('admin.materials.types.edit',$oldType->id));
});

//Materials Items
Breadcrumbs::register('materialItems',function($breadcrumbs){
   $breadcrumbs->parent('dashboard');
   $breadcrumbs->push('วัสดุ/อุปกรณ์',route('admin.materials.items.index'));
});
// -- create
Breadcrumbs::register('materialItemsCreate',function($breadcrumbs){
    $breadcrumbs->parent('materialItems');
    $breadcrumbs->push('สร้างใหม่',route('admin.materials.items.create'));
});
