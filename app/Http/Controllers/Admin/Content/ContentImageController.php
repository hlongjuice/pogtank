<?php

namespace App\Http\Controllers\Admin\Content;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Image;
use DB;
use File;

class ContentImageController extends Controller
{
    public function uploadImageInContent(Request $request){
//        dd($request->input('file'));
        $result= DB::transaction(function() use ($request){
            $fileInput = $request->file('images');
            $today=Carbon::now()->format('d-m-Y');
            $current= Carbon::now()->format('H-i-s');
            $directoryPath = public_path().'/images/content/'.$today;

            if(!File::exists($directoryPath)){
                File::makeDirectory($directoryPath);
            }
            $ramDomString = rand(0,1000);
            $originalName=$fileInput->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $filePath='images/content/'.$today.'/'.$current.'-'.$fileName.'.jpg';

            $img=Image::make($fileInput);

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
    //Upload Images
    public function uploadImage($imageInput,$contentID){
        $result= DB::transaction(function() use ($imageInput,$contentID){
            $today=Carbon::now()->format('d-m-Y');
            $current= Carbon::now()->format('H-i-s');
            $directoryPath = public_path().'/images/content/'.$contentID;

            if(!File::exists($directoryPath)){
                File::makeDirectory($directoryPath);
            }
            $ramDomString = rand(0,1000);
            $originalName=$imageInput->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $filePath='images/content/'.$today.'/'.$current.'-'.$fileName.'.jpg';

            $img=Image::make($imageInput);

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
        return $result;
    }
}
