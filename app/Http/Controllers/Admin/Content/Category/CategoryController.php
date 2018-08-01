<?php

namespace App\Http\Controllers\Admin\Content\Category;

use App\Models\Admin\Content\ContentCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    //Add Category
    public function addCategory(Request $request)
    {
        $categoryInput = [
            'title' => $request->input('title'),
            'body' => $request->input('body')
        ];
        $result = null;
        //ถ้าเป็นหมวดหมู่หลัก
        if ($request->input('parentCategory')['id'] == 0) {
            $result = ContentCategory::create($categoryInput);
        } else {
            $parent = ContentCategory::withDepth()->where('id', $request->input('parentCategory')['id'])->first();
            $result = $parent->children()->create($categoryInput);
        }
        return response()->json($result);
    }
    //Get All Category
    public function getAllCategories(){
        //Get Category แบบ nested Tree เพื่อจะนำไป Recursive ใส่ '-' ไว้ ด้านหน้า title ตามลำดับ LV
        $categories = ContentCategory::withDepth()->get()->toTree();
        $flatCategories= collect([]);

        //Recursive Set '-'
        $traverse = function ($categories, $prefix = '') use (&$traverse,$flatCategories) {
            foreach ($categories as $category) {
                $item= collect([
                   'id'=>$category->id,
                   'title'=>  $prefix.' '.$category->title
                ]);
                $flatCategories->push($item);
                $traverse($category->children, $prefix.'-');
            }
        };

        $traverse($categories);
        $flatCategories->prepend([
            'id'=>0,
            'title'=>'หมวดหมู่หลัก'
        ]);
        return response()->json($flatCategories);
    }
}
