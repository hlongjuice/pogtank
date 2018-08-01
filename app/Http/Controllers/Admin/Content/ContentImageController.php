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
    public function uploadImage(Request $request){
        $result= DB::transaction(function() use ($request){
            $today=Carbon::now()->format('d-m-Y');
            $current= Carbon::now()->format('H-i-s');
            $directoryPath = public_path().'/images/content/'.$today;

            if(!File::exists($directoryPath)){
                File::makeDirectory($directoryPath);
            }
            $ramDomString = rand(0,1000);
            $originalName=$request->file('file')->getClientOriginalName();
            $fileName = pathinfo($originalName, PATHINFO_FILENAME);
            $filePath='images/content/'.$today.'/'.$current.'-'.$fileName.'.jpg';

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
