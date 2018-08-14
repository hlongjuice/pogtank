<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Admin\Content\Content;
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
    public function getAllContents(){
        $contents = Content::with('category')
            ->orderBy('updated_at')
            ->paginate(5);
        return $contents;
    }
    //Get Single Content
    public function getContent($id){
        $content= Content::with('category')->where('id',$id)->first();
        return $content;
    }
    //Update Content
    public function updateContent(Request $request)
    {
        $content=Content::find($request->input('id'));
        $result= $content->update([
           'title'=>trim($request->input('title')),
           'body'=>$request->input('body'),
           'category_id'=>$request->input('category')['id']
        ]);
        return response()->json($result);
    }

    //Delete Content
    public function deleteContent(Request $request)
    {
        $result= DB::transaction(function() use ($request){
            $contentIDs = array_pluck($request->input('checkedItems'), 'id');
            Content::destroy($contentIDs);
        });
        return $result;
    }
}
