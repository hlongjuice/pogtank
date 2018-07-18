<?php

namespace App\Http\Controllers\Admin\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;

class ContentImageController extends Controller
{
    public function uploadImage(Request $request){
        $fileName=$request->file('file')->getClientOriginalName();
        $filePath='images/'.$fileName;
        Image::make($request->file('file'))->save($filePath);
       return response()->json(['location'=>$filePath]);
    }
}
