<?php

namespace App\Http\Controllers\Admin\Product;

use App\Models\Admin\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.product.index');
    }
    //Create
    public function create(){
        return view('admin.product.create');
    }

    public function addNewProduct(Request $request)
    {
        $result = Product::create([
            'name' => $request->input('name')
        ]);
        return $result;
    }
    //Get Products
    public function getAllProducts(){
        $products=Product::orderBy('updated_at','DESC')->get();
        return response()->json($products);
    }
}
