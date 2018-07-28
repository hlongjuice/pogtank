<?php

namespace App\Http\Controllers\Admin\Content;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use DB;

class ContentImageController extends Controller
{
    public function uploadImage(Request $request){
        $result= DB::transaction(function() use ($request){
            $ramDomString = rand();
            $fileName=$request->file('file')->getClientOriginalName();
            $filePath='images/'.$ramDomString.'.jpg';

            $img=Image::make($request->file('file'));

            $fileSize = $img->filesize()/1024;
            // prevent possible upsizing
            if ($fileSize > 150){
                $img->resize(800, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            $img->save($filePath,90);
            return $filePath;
        });


        return response()->json(['location'=>$result]);


    }
}
