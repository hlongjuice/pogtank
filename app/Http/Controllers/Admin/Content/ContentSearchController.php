<?php

namespace App\Http\Controllers\Admin\Content;

use App\Models\Admin\Content\Content;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContentSearchController extends Controller
{
    //Search By Text
    public function searchByText(Request $request)
    {
        $contents = '';
        $contents = Content::with('category');
        $categoryID = $request->input('category')['id'];
        $searchTextTitle = trim($request->input('searchText'));

        if($categoryID > 0) {
            $contents->where('category_id',$request->input('category')['id']);
        }
        if(trim($request->input('searchText')) != ''){
            $contents->where('title',$searchTextTitle);
        }
        $result = $contents->orderBy('updated_at')->paginate(3);
        return response()->json($result);
    }

    //Search By Category
    public function searchByCategory($category_id)
    {
        $contents = Content::with('category')
            ->where('category_id', $category_id)
            ->orderBy('updated_at')
            ->paginate(50);
        return $contents;
    }
}
