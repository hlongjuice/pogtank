<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Admin\Content\Content;
use App\Models\Admin\Content\ContentCategory;
use App\Models\Admin\Content\ContentImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class ContentController extends Controller
{
    public function addContent(Request $request)
    {
        $newContent = Content::create([
            'title' => trim($request->input('title')),
            'body' => $request->input('body'),
            'category_id' => json_decode($request->input('category'))->id
        ]);
        //If Has Images Input then Upload Image and save path
        if ($request->hasFile('images')) {
            $contentImageController = new  ContentImageController();
            foreach ($request->file('images') as $image) {
                $path = $contentImageController->uploadImage($image, $newContent->id);
                $newContent->images()->create([
                    'content_id' => $newContent->id,
                    'path' => $path
                ]);
            }
        }
        return $newContent;
    }

    //Get Content Per Page ใช้ในการ filter content ด้วย
    public function getAllContents(Request $request, $parent_category_title)
    {
        $contents = '';
        $categoryID = $request->input('category')['id'];
        $searchTextTitle = trim($request->input('searchText'));
        //1.การกรองหลัก
        // -- กรอง parent ของ Category
        //1.1 หากเป็น 0 คือ Root ของ Category ทั้งหมด ดังนั้นจึก query content มาทั้งหมด
        if ($parent_category_title == '0') {
            $contents = Content::with('category');
        }
        //1.2 หาก Root Category ไม่ใช่ 0 ให้ทำการเลือก IDs Category นั้น และ ลูกๆหลานๆทั้งหมด
        //1.2.1 และเลือกเฉพาะ contents ที่อยู่ใน Category IDs ที่เลือกมาเท่านั้น
        else {
            $parent = ContentCategory::where('title', $parent_category_title)->first();
            $familyCategoryIDs = ContentCategory::whereDescendantOrSelf($parent->id)->pluck('id');
            $contents = Content::with('category')->whereIn('category_id', $familyCategoryIDs);
        }

        // 2 Optional การกรองทางเลือก
        // หากมีการเลืิอก กรอง Category อีกครั้ง
        if ($categoryID > 0) {
            $optionalFamilyCategoryIDs = ContentCategory::whereDescendantOrSelf($categoryID)->pluck('id');
            $contents->whereIn('category_id', $optionalFamilyCategoryIDs);
//            $contents->where('category_id',$request->input('category')['id']);
        }
        //ทำเมื่อมีการ search
        if (trim($request->input('searchText')) != '') {
            $contents->where('title', 'like', '%' . $searchTextTitle . '%');
        }
        //ข้อมูลที่ select มาอาจจะมีเงืื่อนไขด้านบนหรือไม่มีเงื่อนไขก็ได้
        $result = $contents->orderBy('updated_at', 'desc')->paginate(20);
        return response()->json($result);
    }

    //Get Single Content
    public function getContent($id)
    {
        $content = Content::with('category', 'images')->where('id', $id)->first();
        return $content;
    }

    //Update Content
    public function updateContent(Request $request)
    {
        $result= DB::transaction(function () use ($request){
            $contentImageController = new ContentImageController();
            $content = Content::find($request->input('id'));
            $result = $content->update([
                'title' => trim($request->input('title')),
                'body' => $request->input('body'),
                'category_id' => json_decode($request->input('category'))->id
            ]);
            if ($request->hasFile('newImages')) {
                foreach ($request->file('newImages') as $image) {
                    $path = $contentImageController->uploadImage($image, $content->id);
                    $content->images()->create([
                        'content_id' => $content->id,
                        'path' => $path
                    ]);
                }
            }
        });
        return response()->json($result);
    }

    public function updateOrCreateContent(Request $request, $categoryTitle)
    {
        $result = DB::transaction(function () use ($request, $categoryTitle) {
            $contentImageController = new ContentImageController();
            $category = ContentCategory::whereTitle($categoryTitle)->first();
            $content = Content::updateOrCreate(
                ['category_id'=>$category->id],
                [
                    'title' => $category->title,
                    'body' => $request->input('body')
                ]
            );
            if ($request->hasFile('newImages')) {
                foreach ($request->file('newImages') as $image) {
                    $path = $contentImageController->uploadImage($image, $content->id);
                    $content->images()->create([
                        'content_id' => $content->id,
                        'path' => $path
                    ]);
                }
            }
        });
        return response()->json($result);
    }

    //Delete Content
    public function deleteContent(Request $request)
    {
        $result = DB::transaction(function () use ($request) {
            $contentImageController = new ContentImageController();
            $contentIDs = array_pluck($request->input('checkedItems'), 'id');
            $contents = Content::with('images')
                ->whereIn('id', $contentIDs)->get();
            foreach ($contents as $content) {
                if ($content->images()->count() > 0) {
                    foreach ($content->images as $image) {
                        $contentImageController->deleteImageFolder($image->path);
                    }
                }
            }
            Content::destroy($contentIDs);
        });
        return $result;
    }
}
