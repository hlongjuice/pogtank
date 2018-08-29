<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Admin\Content\Content;
use App\Models\Admin\Content\ContentCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ContentController extends Controller
{
    public function addContent(Request $request)
    {
        $result = Content::create([
            'title' => trim($request->input('title')),
            'body' => $request->input('body'),
            'category_id' => $request->input('category')['id']
        ]);
        return $result;
    }

    //Get Content Per Page
    public function getAllContents(Request $request,$parent_category_title)
    {
        $contents = '';
        $categoryID = $request->input('category')['id'];
        $searchTextTitle = trim($request->input('searchText'));
        //1.การกรองหลัก
        // -- กรอง parent ของ Category
        //1.1 หากเป็น 0 คือ Root ของ Category ทั้งหมด ดังนั้นจึก query content มาทั้งหมด
        if($parent_category_title == '0'){
            $contents = Content::with('category');
        }
        //1.2 หาก Root Category ไม่ใช่ 0 ให้ทำการเลือก IDs Category นั้น และ ลูกๆหลานๆทั้งหมด
        //1.2.1 และเลือกเฉพาะ contents ที่อยู่ใน Category IDs ที่เลือกมาเท่านั้น
        else{
            $parent = ContentCategory::where('title',$parent_category_title)->first();
            $familyCategoryIDs = ContentCategory::whereDescendantOrSelf($parent->id)->pluck('id');
            $contents = Content::with('category')->whereIn('category_id',$familyCategoryIDs);
        }

        // 2 Optional การกรองทางเลือก
        // หากมีการเลืิอก กรอง Category อีกครั้ง
        if($categoryID > 0) {
            $optionalFamilyCategoryIDs = ContentCategory::whereDescendantOrSelf($categoryID)->pluck('id');
            $contents->whereIn('category_id',$optionalFamilyCategoryIDs);
//            $contents->where('category_id',$request->input('category')['id']);
        }
        //ทำเมื่อมีการ search
        if(trim($request->input('searchText')) != ''){
            $contents->where('title','like','%'.$searchTextTitle.'%');
        }
        //ข้อมูลที่ select มาอาจจะมีเงืื่อนไขด้านบนหรือไม่มีเงื่อนไขก็ได้
        $result = $contents->orderBy('updated_at','desc')->paginate(20);
        return response()->json($result);
    }

    //Get Single Content
    public function getContent($id)
    {
        $content = Content::with('category')->where('id', $id)->first();
        return $content;
    }

    //Update Content
    public function updateContent(Request $request)
    {
        $content = Content::find($request->input('id'));
        $result = $content->update([
            'title' => trim($request->input('title')),
            'body' => $request->input('body'),
            'category_id' => $request->input('category')['id']
        ]);
        return response()->json($result);
    }

    //Delete Content
    public function deleteContent(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $contentIDs = array_pluck($request->input('checkedItems'), 'id');
            Content::destroy($contentIDs);
        });
        return $result;
    }
}
