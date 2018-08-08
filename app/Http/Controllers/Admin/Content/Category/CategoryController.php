<?php

namespace App\Http\Controllers\Admin\Content\Category;

use App\Models\Admin\Content\ContentCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class CategoryController extends Controller
{
    //Add Category
    public function addCategory(Request $request)
    {
        $categoryInput = [
            'title' => $request->input('title'),
            'body' => $request->input('body'),
            'created_by' => $request->input('user')['id']
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

    //Get Selected Category
    public function getCategory($id)
    {
        $category = ContentCategory::with('Parent')->where('id', $id)->first();
        return $category;
    }

    //Get All Category
    public function getAllCategories()
    {
        //Get Category แบบ nested Tree เพื่อจะนำไป Recursive ใส่ '-' ไว้ ด้านหน้า title ตามลำดับ LV
        $categories = ContentCategory::withDepth()->with('descendants')
            ->get()->toTree();
        $flatCategories = collect([]);

        //Recursive Set '-'
        $traverse = function ($categories, $prefix = '') use (&$traverse, $flatCategories) {
            foreach ($categories as $category) {
                $item = collect([
                    'id' => $category->id,
                    'title' => $prefix . ' ' . $category->title,
                    'descendants' => $category->descendants
                ]);
                $flatCategories->push($item);
                $traverse($category->children, $prefix . '-');
            }
        };

        $traverse($categories);
//        return response()->json($flatCategories);
        return $flatCategories;
    }

    //Get All Categories with Parent Lv 0 หมวดหมู่หลัก
    public function getAllCategoriesWithRoot()
    {
        $flatCategories = $this->getAllCategories();
        $flatCategories->prepend([
            'id' => 0,
            'title' => 'หมวดหมู่หลัก'
        ]);
        return $flatCategories;
    }

    //Get All Categories without id
    public function getAllCategoriesWithoutID($id)
    {
        $flatCategories = $this->getAllCategories();
        $flatCategories->prepend([
            'id' => 0,
            'title' => 'หมวดหมู่หลัก'
        ]);
        $filteredCategories = $flatCategories->where('id', '!=', $id)->values();
        return $filteredCategories;
//        return $flatCategories;
    }

    //Delete Category
    public function deleteCategories(Request $request)
    {
        //การลบ Categories แบบ Nested ถ้าลบแม่ ก็จะลบลูกๆไปด้วย
        $result = DB::transaction(function () use ($request) {
            $checkedItems = $request->input('checkedItems');
            $itemIDs = collect([]);
            //วนลูปเช็ค items ทีละตัวเพื่อดึงเอามาเฉพาะ id
            foreach ($checkedItems as $checkedItem) {
                $itemIDs->push($checkedItem['id']);
                //หากมี ลูก หลาน ให้ดึง id มาทั้งหมด เพื่อที่จะลบลูกหลานไปด้วย
                if (count($checkedItem['descendants']) > 0) {
                    $descendantsIDs = array_pluck($checkedItem['descendants'], 'id');
                    $itemIDs = $itemIDs->concat($descendantsIDs);
                }
            }
            //ทุกครั้งที่เลือกแม่มาจะได้ลูกๆมาทุกครั้ง แต่ในหน้า UI user มักจะเลือกลูกๆมาอีกทำให้ต้องกรองเอา Id ที่ซ้ำกันออกให้เหลือแค่อันเดียวก่อนที่จะนำไปลบ
            $itemIDs = $itemIDs->unique()->values();
            ContentCategory::destroy($itemIDs->toArray());
        });
        return $result;
    }
}
