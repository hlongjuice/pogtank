<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index(){
//        $products=Product::all();
        $product=Product::withDepth()->having('depth',0)->get();
        dd($product);
//        $product->children()->create([
//            'name'=>'TestChild'
//        ]);
//        $products=Product::all();
//        dd($products);
//        return view('admin.dashboard');
    }
}

