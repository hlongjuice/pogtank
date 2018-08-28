<?php

namespace App\Http\Controllers\Admin\Content\Category;

use App\Models\Admin\Content\Content;
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
    public function getAllCategories($parentTitle)
    {
        //Get Category แบบ nested Tree เพื่อจะนำไป Recursive ใส่ '-' ไว้ ด้านหน้า title ตามลำดับ LV
        $categories = ContentCategory::withDepth()->with('descendants');
//        if ($parent > 0) {
        if($parentTitle !=0 && $parentTitle != ''){
            dd('Yo!');
            $parent = ContentCategory::where('title',$parentTitle)->first();
            $categories->whereDescendantOf($parent->id);
        }
        $categories=$categories->get()->toTree();
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
    public function getAllCategoriesWithRoot($parent)
    {
        $flatCategories = $this->getAllCategories($parent);
        $flatCategories->prepend([
            'id' => 0,
            'title' => 'หมวดหมู่หลัก'
        ]);
        return $flatCategories;
    }

    //Get All Categories without id
    public function getAllCategoriesWithoutID($parent,$id)
    {
        $flatCategories = $this->getAllCategories($parent);
        $flatCategories->prepend([
            'id' => 0,
            'title' => 'หมวดหมู่หลัก'
        ]);
        $descendantAndSelfIDs = ContentCategory::whereDescendantOrSelf($id)->pluck('id');
//        dd($descendantAndSelfIDs);
        $filteredCategories = $flatCategories->whereNotIn('id', $descendantAndSelfIDs)->values();
        return $filteredCategories;
    }

    //Get All Category with Select All Root
    public function getAllCategoriesWithSelectAll($parent)
    {
        $flatCategories = $this->getAllCategories($parent);
        $flatCategories->prepend([
            'id' => 0,
            'title' => 'หมวดหมู่ทั้งหมด'
        ]);
        return $flatCategories;
    }

    //Update Category
    public function updateCategory(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $oldCategory = ContentCategory::where('id', $request->input('id'))->first();
            if ($oldCategory->parent_id != $request->input('parent')['id']) {
                $oldCategory->parent_id = $request->input('parent')['id'];
            }
            $oldCategory->title = $request->input('title');
            $oldCategory->save();
        });
        return $result;
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
