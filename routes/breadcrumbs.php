<?php

//DashBoard
Breadcrumbs::register('dashboard', function ($breadcrumbs) {
    $breadcrumbs->push('DashBoard', route('admin.dashboard'));
});

//***Materials Types
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

//***Materials Items
Breadcrumbs::register('materialItems',function($breadcrumbs){
   $breadcrumbs->parent('dashboard');
   $breadcrumbs->push('วัสดุ/อุปกรณ์',route('admin.materials.items.index'));
});
// -- create
Breadcrumbs::register('materialItemsCreate',function($breadcrumbs){
    $breadcrumbs->parent('materialItems');
    $breadcrumbs->push('สร้างใหม่',route('admin.materials.items.create'));
});
// -- edit
Breadcrumbs::register('materialItemEdit',function($breadcrumbs,$item){
    $name='';
    if ($item->approvedGlobalDetails){
        $name=$item->approvedGlobalDetails->name;
    }else{
        $name=$item->waitingGlobalDetails->name;
    }
    $breadcrumbs->parent('materialItems');
    $breadcrumbs->push('Edit - '.$name,route('admin.materials.types.edit',$item->id));
});

//***Product
Breadcrumbs::register('product',function($breadcrumbs){
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('สินค้า',route('admin.product.index'));
});
// --create
Breadcrumbs::register('productCreate',function($breadcrumbs){
    $breadcrumbs->parent('product');
    $breadcrumbs->push('สร้างใหม่',route('admin.product.create'));
});
//***Project Order
Breadcrumbs::register('projectOrder',function($breadcrumbs){
   $breadcrumbs->parent('dashboard');
   $breadcrumbs->push('รายการสั่งซื้อ',route ('admin.project_order.index'));
});
// --create
Breadcrumbs::register('projectOrderCreate',function($breadcrumbs){
    $breadcrumbs->parent('projectOrder');
    $breadcrumbs->push('สร้างใหม่',route('admin.project_order.create'));
});
//***Porlor 4
Breadcrumbs::register('porlor4',function($breadcrumbs,$order){
//    dd($order);
   $breadcrumbs->parent('projectOrder');
   $breadcrumbs->push('โครงการ '.$order->project_name,route('admin.project_order.porlor_4',$order->id));
});
// -- Porlor 4 Jobs
Breadcrumbs::register('porlor4Job',function($breadcrumbs,$porlor4){
   $breadcrumbs->parent('porlor4',$porlor4->projectDetails);
   $breadcrumbs->push('ส่วน '.$porlor4->part->name,route('admin.project_order.porlor_4.job.index',$porlor4->id));
});
//***Porlor 4 Part
Breadcrumbs::register('porlor4Part',function($breadcrumbs){
    $breadcrumbs->parent('dashboard');
    $breadcrumbs->push('หมวดหมู่',route('admin.porlor_4_part.index'));
});
